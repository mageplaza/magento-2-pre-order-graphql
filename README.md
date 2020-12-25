# Magento 2 Pre Order GraphQL/PWA

**Magento Pre Order GraphQL is now a part of Mageplaza Pre Order extension that adds GraphQL features; this supports PWA Studio.**

Mageplaza Pre Order for Magento 2 enables the pre-order functionality, which is a must-have for any online store. Customers can place an order in advance before the products are restocked or officially released. This brings many benefits to both customers and store owners. 

As a store admin, you can configure to apply pre-order to any product without limitation. The product types include simple products, group products, configurable products, and bundle products. 

From the admin backend, you can also select the conditions to apply pre-order for products, especially based on the product quantity: 
If the product is out of stock: the quantity is zero. 
If the product is upcoming: the quantity is zero. 
If the product quantity is smaller than the customers’ demand

The extension will detect and sort out the products that match the conditions and automatically enables the pre-order button for those products.  

Customers will also want to know about the status of the products they are going to purchase. So it’s necessary to announce to them the quantity of the products and your solution for that. Therefore, Magento 2 Pre Order extension includes the notification feature. When customers browse through your products and place an order on out-of-stock or upcoming products, the pre-order notification will pop out. Customers will know that they can pre-order the items and will more likely to continue the purchase instead of leaving your store. 

In another case, if the available quantity doesn’t satisfy customers’ demand, there will be a notification about the remaining items. You can display the pre-order notifications on different pages, such as category page, product page, shopping cart page, checkout page, admin order page, frontend view order page, or admin view order page. 

## 1. How to install

Run the following command in Magento 2 root folder:

```
composer require mageplaza/module-pre-order-graphql
php bin/magento setup:upgrade
php bin/magento setup:static-content:deploy
```

**Note:**
Magento 2 Pre Order GraphQL requires installing [Mageplaza Pre Order](https://www.mageplaza.com/magento-2-pre-order/) in your Magento installation.

## 2. How to use

To perform GraphQL queries in Magento, please do the following requirements:

- Use Magento 2.3.x or higher. Set your site to [developer mode](https://www.mageplaza.com/devdocs/enable-disable-developer-mode-magento-2.html).
- Set GraphQL endpoint as `http://<magento2-server>/graphql` in url box, click **Set endpoint**. 
(e.g. `http://dev.site.com/graphql`)
- To view the queries that the **Mageplaza Pre Order GraphQL** extension supports, you can look in `Docs > Query` in the right corner

## 3. Devdocs

- [Pre Order API & examples](https://documenter.getpostman.com/view/10589000/TVYDfLBx)
- [Pre Order GraphQL & examples](https://documenter.getpostman.com/view/10589000/TVYKZwEg)


## 4. Contribute to this module

Feel free to **Fork** and contribute to this module and create a pull request so we will merge your changes main branch.

## 5. Get Support

- Feel free to [contact us](https://www.mageplaza.com/contact.html) if you have any further questions.
- Like this project, Give us a **Star** ![star](https://i.imgur.com/S8e0ctO.png)
