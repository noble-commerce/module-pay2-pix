# Pay2 - Pix Gateway for Magento 2

Pay2 Pix payment gateway for Magento 2 platform by [NobleCommerce.io](https://noblecommerce.io).

## Installation

1 - Install the module:

```bash
composer require noble-commerce/module-pay2-pix
```

2 - Enable the module and clear cache:

```bash
bin/magento module:enable Pay2_Pix
bin/magento setup:upgrade
bin/magento cache:flush
```

Done!

## Configuration

To configure the payment gateway module, access the store admin and go to "Stores" > "Configuration" > "Sales" > "Payment Methods". Open the "Pay2 Pix Gateway" section and fill in data as required.  

- This module requires that customer tax vat or address vat ID field are enabled to customers fill the CPF/CNPJ value.
- You also must configure the address lines to 4 - the last line must be the complement field.

## Additional Information

- Voiding a order will cancel the payment processing without communicating with the payment gateway. Any further payment gateway communication will also be blocked. Use this command only if you want to manually confirm, process and refund the payment on the order.
