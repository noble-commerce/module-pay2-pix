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

namespace Pay2\Pix\Gateway\Response\Handler;

use Magento\Payment\Gateway\Data\PaymentDataObjectInterface;
use Magento\Payment\Gateway\Response\HandlerInterface;
use Magento\Sales\Model\Order\Payment;

class SaveDetails implements HandlerInterface
{
    /**
     * @param array $handlingSubject
     * @param array $response
     */
    public function handle(array $handlingSubject, array $response)
    {
        /** @var PaymentDataObjectInterface $paymentDataObject */
        $paymentDataObject = $handlingSubject['payment'];

        /** @var Payment $payment */
        $payment = $paymentDataObject->getPayment();

        $data = $response['data']['raw_data']['data'];
        $status = strtoupper($data['financialStatement']['status']);

        // Status
        $payment->setAdditionalInformation('status', $status);

        // Transaction information
        $payment->setLastTransId($data['transactionId']);
        $payment->setTransactionId($data['transactionId']);
        $payment->setIsTransactionClosed(false);

        // Pix information
        $qrCodeImage = $data['instantPayment']['generateImage']['imageContent'];
        if ($qrCodeImage) {
            $qrCodeImage = 'data:image/png;base64,' . $qrCodeImage;
        }

        $payment->setAdditionalInformation('reference', $data['instantPayment']['reference']);
        $payment->setAdditionalInformation('text_content', $data['instantPayment']['textContent']);
        $payment->setAdditionalInformation('qr_code_url', $data['instantPayment']['qrcodeURL']);
        $payment->setAdditionalInformation('qr_code_image', $qrCodeImage);

        // Response details
        $details = $response['data'];
        unset($details['raw_data']['data']['instantPayment']['generateImage']);
        $payment->setTransactionAdditionalInfo('details', $details);
    }
}
