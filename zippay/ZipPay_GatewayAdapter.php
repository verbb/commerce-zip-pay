<?php
namespace Commerce\Gateways\Omnipay;

use Commerce\Gateways\OffsiteGatewayAdapter;

class ZipPay_GatewayAdapter extends OffsiteGatewayAdapter
{
    // Public Methods
    // =========================================================================

    public function handle()
    {
        return "ZipPay";
    }
}
