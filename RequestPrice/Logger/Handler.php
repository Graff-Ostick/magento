<?php
declare(strict_types=1);
namespace Test\RequestPrice\Logger;

use Magento\Framework\Logger\Handler\Base;

class Handler extends Base
{
    /** @var int */
    public $loggerType = Logger::INFO;

    /** @var string */
    public $fileName = '/var/log/grid.log';
}
