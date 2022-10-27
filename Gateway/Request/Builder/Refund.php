<?php

/**
 * DISCLAIMER
 *
 * Do not edit this file if you want to update this module for future new versions.
 *
 * @category Pay2
 * @package Pay2_Pix
 * @copyright Copyright (c) 2022 NobleCommerce
 * @author NobleCommerce <hello@noblecommerce.io>
 *
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Pay2\Pix\Gateway\Request\Builder;

use Magento\Framework\Exception\LocalizedException;
use Magento\Payment\Gateway\Data\PaymentDataObjectInterface;
use Magento\Payment\Gateway\Request\BuilderInterface;
use Magento\Sales\Model\Order\Payment;

class Refund implements BuilderInterface
{

    /**
     * @inheritDoc
     */
    public function build(array $buildSubject)
    {

        /** @var PaymentDataObjectInterface $paymentDataObject */
        $paymentDataObject = $buildSubject['payment'];

        /** @var Payment $payment */
        $payment = $paymentDataObject->getPayment();
        $transactionId = $payment->getLastTransId();
        $status = $payment->getAdditionalInformation('status');

        if (!$transactionId) {
            throw new LocalizedException(__('Transaction not found to process refund.'));
        }
        if ($status === 'VOIDED') {
            throw new LocalizedException(__('Transaction was voided.'));
        }

        return [
            'transaction_id' => $transactionId,
        ];
    }
}
