<?php
declare(strict_types=1);

namespace Test\RequestPrice\Plugin;

use Magento\Catalog\Pricing\Render\FinalPriceBox as Subject;

/**
 * Hide price plugin.
 */
class HidePrice
{
    /**
     * After to html.
     *
     * @param Subject $subject
     * @param         $result
     *
     * @return mixed|string
     */
    function afterToHtml(Subject $subject, $result): string
    {
        return $subject ? '' : $result;
    }
}
