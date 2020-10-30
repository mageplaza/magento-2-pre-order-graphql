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
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\QuoteGraphQl\Model\Cart\GetCartForUser;
use Mageplaza\PreOrder\Helper\Data;
use Mageplaza\PreOrder\Api\PreOrderRepositoryInterfaceFactory;
use Magento\Framework\GraphQl\Query\ResolverInterface;

/**
 * Class CheckoutNotice
 * @package Mageplaza\PreOrderGraphQl\Model\Resolver\Cart
 */
class CheckoutNotice implements ResolverInterface
{
    /**
     * @var GetCartForUser
     */
    protected $getCartForUser;

    /**
     * @var PreOrderRepositoryInterfaceFactory
     */
    protected $preOrderRepository;

    /**
     * @var Data
     */
    protected $helperData;

    /**
     * CheckoutNotice constructor.
     *
     * @param GetCartForUser $getCartForUser
     * @param Data $helperData
     * @param PreOrderRepositoryInterfaceFactory $preOrderRepository
     */
    public function __construct(
        GetCartForUser $getCartForUser,
        Data $helperData,
        PreOrderRepositoryInterfaceFactory $preOrderRepository
    ) {
        $this->getCartForUser     = $getCartForUser;
        $this->preOrderRepository = $preOrderRepository;
        $this->helperData         = $helperData;
    }

    /**
     * @inheritdoc
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        if (!$this->helperData->isEnabled()) {
            throw new GraphQlNoSuchEntityException(__('Pre Order is disabled.'));
        }

        if ($this->helperData->versionCompare('2.3.3')) {
            $store = $context->getExtensionAttributes()->getStore();
            $quote = $this->getCartForUser->execute($args['cart_id'], $context->getUserId(), (int)$store->getId());
        } else {
            $quote = $this->getCartForUser->execute($args['cart_id'], $context->getUserId());
        }

        return $this->preOrderRepository->create()->getNotification($quote->getId());
    }
}
