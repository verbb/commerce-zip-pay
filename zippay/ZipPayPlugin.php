<?php
namespace Craft;

require __DIR__ . '/vendor/autoload.php';

class ZipPayPlugin extends BasePlugin
{
    // =========================================================================
    // PLUGIN INFO
    // =========================================================================

    public function getName()
    {
        return Craft::t('Zip Pay');
    }

    public function getVersion()
    {
        return '1.0.0';
    }

    public function getSchemaVersion()
    {
        return '1.0.0';
    }

    public function getDeveloper()
    {
        return 'Verbb';
    }

    public function getDeveloperUrl()
    {
        return 'https://verbb.io';
    }



    // =========================================================================
    // HOOKS
    // =========================================================================

    public function commerce_registerGatewayAdapters()
    {
       require_once __DIR__ . '/ZipPay_GatewayAdapter.php';

       return array('\Commerce\Gateways\Omnipay\ZipPay_GatewayAdapter');
    }
 
}
