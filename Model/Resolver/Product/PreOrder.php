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

namespace Mageplaza\PreOrderGraphQl\Model\Resolver\Product;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Model\Product;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\GraphQl\Model\Query\ContextInterface;
use Mageplaza\PreOrder\Helper\Data;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Mageplaza\PreOrder\Api\PreOrderRepositoryInterface;
use Magento\CustomerGraphQl\Model\Customer\GetCustomer;

/**
 * Class PreOrder
 * @package Mageplaza\PreOrderGraphQl\Model\Resolver\Product
 */
class PreOrder implements ResolverInterface
{
    /**
     * @var Data
     */
    protected $helperData;

    /**
     * @var PreOrderRepositoryInterface
     */
    protected $preOrderRepository;

    /**
     * @var GetCustomer
     */
    protected $getCustomer;

    /**
     * PreOrder constructor.
     *
     * @param Data $helperData
     * @param PreOrderRepositoryInterface $preOrderRepository
     * @param GetCustomer $getCustomer
     */
    public function __construct(
        Data $helperData,
        PreOrderRepositoryInterface $preOrderRepository,
        GetCustomer $getCustomer
    ) {
        $this->helperData         = $helperData;
        $this->preOrderRepository = $preOrderRepository;
        $this->getCustomer        = $getCustomer;
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
                $product = $this->preOrderRepository->getForGuest($value['sku']);

                return $this->getPreOrderProductData($product);
            }
        }

        $customer = $this->getCustomer->execute($context);
        $product  = $this->preOrderRepository->get($customer->getId(), $value['sku']);

        return $this->getPreOrderProductData($product);
    }

    /**
     * @param Product|ProductInterface $product
     *
     * @return array
     */
    private function getPreOrderProductData($product)
    {
        $extensionAttributes = $product->getExtensionAttributes();

        if (($extensionAttributes && $extensionAttributes->getMpPreOrder())) {
            return [
                'stock_notice' => $extensionAttributes->getMpPreOrder()->getStockNotice(),
                'button_label' => $extensionAttributes->getMpPreOrder()->getButtonLabel(),
                'children'     => $extensionAttributes->getMpPreOrder()->getChildren(),
                'option_map'   => $extensionAttributes->getMpPreOrder()->getOptionMap()
            ];
        }
    }
}
