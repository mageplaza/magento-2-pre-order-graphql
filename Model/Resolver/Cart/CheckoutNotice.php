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
use Mageplaza\PreOrder\Helper\Item as HelperItem;
use Mageplaza\PreOrder\Api\PreOrderRepositoryInterfaceFactory;

/**
 * Class CheckoutNotice
 * @package Mageplaza\PreOrderGraphQl\Model\Resolver\Cart
 */
class CheckoutNotice extends AbstractCart
{
    /**
     * @var PreOrderRepositoryInterfaceFactory
     */
    protected $preOrderRepository;

    /**
     * CheckoutNotice constructor.
     *
     * @param HelperItem $helperItem
     * @param PreOrderRepositoryInterfaceFactory $preOrderRepository
     */
    public function __construct(HelperItem $helperItem, PreOrderRepositoryInterfaceFactory $preOrderRepository)
    {
        $this->preOrderRepository = $preOrderRepository;

        parent::__construct($helperItem);
    }

    /**
     * @inheritdoc
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        $quote = $value['model'];

        return $this->preOrderRepository->create()->getNotification($quote->getId());
    }
}
