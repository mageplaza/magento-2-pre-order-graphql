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

namespace Mageplaza\PreOrderGraphQl\Model\Resolver\Order;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\GraphQl\Model\Query\ContextInterface;
use Mageplaza\PreOrder\Helper\Data;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Sales\Api\OrderRepositoryInterface;

/**
 * Class OrderNotification
 * @package Mageplaza\PreOrderGraphQl\Model\Resolver\Order
 */
class OrderNotification implements ResolverInterface
{
    /**
     * @var Data
     */
    protected $helperData;

    /**
     * @var OrderRepositoryInterface
     */
    protected $orderRepository;

    /**
     * OrderNotification constructor.
     *
     * @param Data $helperData
     * @param OrderRepositoryInterface $orderRepository
     */
    public function __construct(
        Data $helperData,
        OrderRepositoryInterface $orderRepository
    ) {
        $this->helperData      = $helperData;
        $this->orderRepository = $orderRepository;
    }

    /**
     * @inheritdoc
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        if (!$this->helperData->isEnabled()) {
            return null;
        }

        /** @var ContextInterface $context */
        if ($this->helperData->versionCompare('2.3.3')) {
            if ($context->getExtensionAttributes()->getIsCustomer() === false) {
                return null;
            }
        }

        $orderId = $value['id'];
        if (isset($orderId) && $orderId) {
            $order = $this->orderRepository->get((int)$orderId);
            if ($this->helperData->isApplicableOrder($order) &&
                in_array('frontend', $this->helperData->getOrderNoticePage($order->getStoreId()), true)) {
                return $this->helperData->getOrderNotice($order->getStoreId());
            }
        }
    }
}
