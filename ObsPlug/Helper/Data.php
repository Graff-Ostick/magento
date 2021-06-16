<?php
namespace Test\ObsPlug\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    public function upperString($string)
    {
        return strtoupper($string);
    }
}
