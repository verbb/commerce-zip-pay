<?php
namespace verbb\zippay\gateways;

use verbb\zippay\models\ZipItem;
use verbb\zippay\models\ZipItemBag;

use Craft;
use craft\helpers\ArrayHelper;
use craft\helpers\UrlHelper;

use craft\commerce\Plugin as Commerce;
use craft\commerce\base\RequestResponseInterface;
use craft\commerce\elements\Order;
use craft\commerce\models\payments\BasePaymentForm;
use craft\commerce\models\Transaction;
use craft\commerce\omnipay\base\OffsiteGateway;

use craft\web\Response;
use craft\web\View;

use Omnipay\ZipPay\RestGateway;
use Omnipay\Common\CreditCard;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Common\AbstractGateway;

class ZipPay extends OffsiteGateway
{
    // Properties
    // =========================================================================

    public $apiKey;
    public $testMode = false;

    public $sendCartInfo = true;


    // Public Methods
    // =========================================================================

    public static function displayName(): string
    {
        return Craft::t('commerce', 'Zip Pay');
    }

    public function getSettingsHtml()
    {
        return Craft::$app->getView()->renderTemplate('commerce-zip-pay/gateway', ['gateway' => $this]);
    }

    public function completeAuthorize(Transaction $transaction): RequestResponseInterface
    {
        $order = $transaction->order;

        // ZipPay doesn't support `cancelUrl` and tries to complete the payment. So check if the request param tells us if a failure.
        $result = Craft::$app->getRequest()->getParam('result');
        $checkoutId = Craft::$app->getRequest()->getParam('checkoutId');

        if ($result === 'cancelled' || $result === 'declined') {
            // Redirect back straight away
            Craft::$app->getResponse()->redirect($order->cancelUrl);
            Craft::$app->end();
        }

        return parent::completeAuthorize($transaction);
    }

    public function createCard(BasePaymentForm $paymentForm, Order $order = null): CreditCard
    {
        $card = parent::createCard($paymentForm, $order);

        // Commerce doesn't seem to handle state very well, just resolving to the stateId. Why not try and
        // set it to the `stateValue` if a valid state object can't be found?
        $state = $card->getBillingState();

        if (!$state) {
            if ($billingAddress = $order->getBillingAddress()) {
                $state = $billingAddress->getStateValue();

                $card->setBillingState($state);
            }
        }

        $state = $card->getShippingState();

        if (!$state) {
            if ($shippingAddress = $order->getShippingAddress()) {
                $state = $shippingAddress->getStateValue();

                $card->setShippingState($state);
            }
        }

        return $card;
    }


    // Protected Methods
    // =========================================================================

    protected function createGateway(): AbstractGateway
    {
        $gateway = static::createOmnipayGateway($this->getGatewayClassName());

        $gateway->setApiKey(Craft::parseEnv($this->apiKey));
        $gateway->setTestMode($this->testMode);

        return $gateway;
    }

    protected function prepareCompleteAuthorizeRequest($request): RequestInterface
    {
        // We need to attach these responses from ZipPay's authorize step
        $result = Craft::$app->getRequest()->getParam('result');

        $request['authorityType'] = 'checkout_id';
        $request['authorityValue'] = Craft::$app->getRequest()->getParam('checkoutId');
        $request['captureFunds'] = true;

        return parent::prepareCompleteAuthorizeRequest($request);
    }

    protected function getItemListForOrder(Order $order): array
    {
        $items = parent::getItemListForOrder($order);

        $discounts = [];

        // Zip can't handle negative line items, so check for discounts.
        foreach ($items as $key => $item) {
            $price = $item['price'] ?? null;

            if ($price !== null and $price < 0) {
                $discount = ArrayHelper::remove($items, $key);
                $discounts[] = $price;
            }
        }

        $items = array_values($items);

        // Subtract the discounts until we've used it up
        if ($discounts) {
            $totalDiscount = array_sum($discounts);

            // Start removing the discount for each line item
            foreach ($items as $key => $item) {
                if ($totalDiscount > 0) {
                    continue;
                }

                $adjustedPrice = $totalDiscount + $items[$key]['price'];

                // Watch if the line price goes into negative
                if ($adjustedPrice < 0) {
                    $adjustedPrice = 0;
                }

                // Update the total discount so we can keep removing
                $totalDiscount = $totalDiscount + $items[$key]['price'];

                // Update the item price
                $items[$key]['price'] = $adjustedPrice;
            }
        }

        return $items;
    }

    protected function getItemBagClassName(): string
    {
        return ZipItemBag::class;
    }

    protected function getGatewayClassName()
    {
        return '\\' . RestGateway::class;
    }
}
