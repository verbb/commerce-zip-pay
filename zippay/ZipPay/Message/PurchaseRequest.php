<?php
namespace Omnipay\ZipPay\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\AbstractRequest;
use zipMoney\Api\Checkout;
use zipMoney\Configuration;
use zipMoney\Request\Order;

class PurchaseRequest extends AbstractRequest
{

	public function getOrderId()
	{
		$orderID = $this->parameters->get('order_id');
		return $orderID ? $orderID : $this->getTransactionId();
	}

	public function setCartURL($url)
	{
		return $this->setParameter('cart_url', $url);
	}

	public function getCartURL()
	{
		return $this->getParameter('cart_url');
	}

	public function getData()
	{
		return array(
			'currency_code' => $this->getCurrency(),
			'order_id' => $this->getOrderId(),
			'cart_url' => $this->getCartURL(),
			'success_url' => $this->getReturnUrl(),
			'cancel_url' => $this->getCancelUrl(),
			'error_url' => $this->getNotifyUrl(),
			'decline_url' => $this->getNotifyUrl(),
			'total' => $this->getAmount()
		);
	}

	public function sendData($data)
	{
		$checkout = new Checkout();
		$checkout->request->charge = false;
		$checkout->request->currency_code = $data['currency_code'];
		$checkout->request->txn_id = false;
		$checkout->request->order_id =  $data['order_id'];
		$checkout->request->in_store = false;


		$checkout->request->cart_url =  $data['cart_url'];
		$checkout->request->success_url =  $data['success_url'];
		$checkout->request->cancel_url =  $data['cancel_url'];
		$checkout->request->error_url =  $data['error_url'];
		$checkout->request->decline_url =  $data['decline_url'];

		$order = new Order();
		$order->id = $data['order_id'];
		$order->tax = 0;
		$order->shipping_tax = 0;
		$order->shipping_value = 0;
		$order->total = $data['total'];

		$checkout->request->order = $order;
		try{
			$response = $checkout->process();
			$this->response = new PurchaseResponse($this, $data);
			if($response->isSuccess()){
				$redirectURL = $response->getRedirectUrl();
				$this->response->setRedirectURL($redirectURL);
			} else {
				$responseArray = $response->toArray();
				$message = isset($responseArray['Message']) ? $responseArray['Message'] : null;
				$exception = new InvalidRequestException($message);
				throw $exception;
			}
			return $this->response;

		} catch (\Exception $e){
			$exception = new InvalidRequestException($e->getMessage());
			throw $exception;
		}

	}


}