<?php
/**
 * Mageplaza
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Mageplaza.com license that is
 * available through the world-wide-web at this URL:
 * https://www.mageplaza.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Mageplaza
 * @package     Mageplaza_PreOrderGraphQl
 * @copyright   Copyright (c) Mageplaza (https://www.mageplaza.com/)
 * @license     https://www.mageplaza.com/LICENSE.txt
 */

declare(strict_types=1);

namespace Mageplaza\PreOrderGraphQl\Model\Resolver\Cart;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Quote\Model\Quote;
use Magento\Quote\Model\QuoteFactory;
use Mageplaza\PreOrder\Helper\Item as HelperItem;

/**
 * Class Item
 * @package Mageplaza\PreOrderGraphQl\Model\Resolver\Cart
 */
class Item extends AbstractCart
{
    /**
     * @var QuoteFactory
     */
    private $quoteFactory;

    /**
     * Item constructor.
     *
     * @param HelperItem $helperItem
     * @param QuoteFactory $quoteFactory
     */
    public function __construct(HelperItem $helperItem, QuoteFactory $quoteFactory)
    {
        $this->quoteFactory = $quoteFactory;

        parent::__construct($helperItem);
    }

    /**
     * @inheritdoc
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        $item = $value['model'];
        /** @var Quote $quote */
        $quote = $this->quoteFactory->create()->load($item->getQuoteId());

        return $this->helperItem->getCartItemMessage($quote, $item, $item);
    }
}
