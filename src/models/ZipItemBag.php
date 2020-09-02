<?php
namespace verbb\zippay\models;

use Omnipay\Common\ItemBag;
use Omnipay\Common\ItemInterface;

class ZipItemBag extends ItemBag
{
    // Public Methods
    // =========================================================================
    
    public function add($item)
    {
        if ($item instanceof ItemInterface) {
            $this->items[] = $item;
        } else {
            $this->items[] = new ZipItem($item);
        }
    }
}
