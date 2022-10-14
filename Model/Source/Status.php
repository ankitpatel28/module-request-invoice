<?php
namespace AnkitDev\RequestInvoice\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Status
 */
class Status implements OptionSourceInterface
{

    const APPROVE= 'approve';
    const DISAPPROVE= 'disapprove';

    public static function getOptionArray()
    {
        return [
            self::APPROVE => __('Approved'),
            self::DISAPPROVE => __('Pending')
        ];
    }

    /**
     * Get options
     * @return array
     */
    public function toOptionArray()
    {
        $res = [];
        foreach (self::getOptionArray() as $index => $value) {
            $res[] = ['value' => $index, 'label' => $value];
        }
        return $res;
    }
}
