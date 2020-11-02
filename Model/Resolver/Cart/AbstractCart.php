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

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Mageplaza\PreOrder\Helper\Item as HelperItem;
use Magento\Framework\GraphQl\Query\ResolverInterface;

/**
 * Class AbstractCart
 * @package Mageplaza\PreOrderGraphQl\Model\Resolver\Cart
 */
abstract class AbstractCart implements ResolverInterface
{
    /**
     * @var HelperItem
     */
    protected $helperItem;

    /**
     * CheckoutNotice constructor.
     *
     * @param HelperItem $helperItem
     */
    public function __construct(
        HelperItem $helperItem
    ) {
        $this->helperItem   = $helperItem;
    }

    /**
     * @inheritdoc
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        if (!$this->helperItem->isEnabled()) {
            return null;
        }

        if (!isset($value['model'])) {
            throw new LocalizedException(__('"model" value should be specified'));
        }
    }
}
