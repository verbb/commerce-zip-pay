<?php
namespace verbb\zippay\models;

use Craft;

use Omnipay\Common\Item;
use Omnipay\ZipPay\ItemInterface;

class ZipItem extends Item implements ItemInterface
{
    // Properties
    // =========================================================================

    public ?string $reference = null;
    public ?string $imageUri = null;


    // Public Methods
    // =========================================================================

    public function getReference()
    {
        return $this->reference;
    }

    public function getImageUri()
    {
        return $this->imageUri;
    }
}
