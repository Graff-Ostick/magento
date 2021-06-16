<?php

namespace Test\Quest\Cron;

use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\App\Config\Storage\WriterInterface;

class Discount
{

    /**
     * @var DateTime
     */
    private $date;
    /**
     * @var WriterInterface
     */
    private $_configWriter;


    public function __construct(
        WriterInterface $configWriter,
        DateTime $date
    ){
        $this->_configWriter = $configWriter;
        $this->date = $date;
    }

    public function execute(){
        $hourNow = intval(date('H'));
        if ($hourNow>=6 && $hourNow<=11){
            $this->_configWriter->save('quest/second_sub_quest/enabled_disabled_time', true);
        }
        else{
            $this->_configWriter->save('quest/second_sub_quest/enabled_disabled_time', false);
        }

    }

}
