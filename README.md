# Pay2 - Pix Gateway for Magento 2

Oficial Pay2 Pix Payment Gateway for Magento 2 platform by [NobleCommerce.io](https://noblecommerce.io).

## Installation

1 - Install the module:

```bash
composer require pay2-bank/pay2-magento2
```

2 - Enable the module and clear cache:

```bash
bin/magento module:enable Pay2_Pix
bin/magento setup:upgrade
bin/magento cache:flush
```

Done!

## Configuration

To configure the payment gateway module, access the store admin and go to "Stores" > "Configuration" > "Sales" > "Payment Methods". Open the "Pay2 Pix Gateway" section and fill data as required.  

