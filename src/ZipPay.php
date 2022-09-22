<?php
namespace verbb\zippay;

use verbb\zippay\gateways\ZipPay as ZipPayGateway;

use Craft;
use craft\base\Model;
use craft\base\Plugin;
use craft\events\RegisterComponentTypesEvent;

use craft\commerce\services\Gateways;

use yii\base\Event;

class ZipPay extends Plugin
{
    // Properties
    // =========================================================================

    public string $schemaVersion = '1.0.0';

    
    // Public Methods
    // =========================================================================

    public function init(): void
    {
        parent::init();

        Event::on(Gateways::class, Gateways::EVENT_REGISTER_GATEWAY_TYPES, function(RegisterComponentTypesEvent $event) {
            $event->types[] = ZipPayGateway::class;
        });
    }
}
