<?php

namespace Test\ObsPlug\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class Fire implements ObserverInterface
{

    /**
     * @param  \Magento\Framework\Event\Observer $observer
     */

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        echo "Done";
    }
}
