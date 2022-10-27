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

namespace Pay2\Pix\Gateway\Command;

use Magento\Payment\Gateway\CommandInterface;
use Magento\Payment\Gateway\Data\PaymentDataObjectInterface;
use Magento\Sales\Api\OrderPaymentRepositoryInterface;
use Magento\Sales\Model\Order\Payment;

class VoidCommand implements CommandInterface
{

    /**
     * @var OrderPaymentRepositoryInterface
     */
    protected $paymentRepository;

    /**
     * @param \Magento\Sales\Api\OrderPaymentRepositoryInterface $paymentRepository
     */
    public function __construct(
        OrderPaymentRepositoryInterface $paymentRepository
    ) {
        $this->paymentRepository = $paymentRepository;
    }

    /**
     * Process command to void payment without communication with API.
     * Any further process should be done manually.
     * @param array $commandSubject
     * @return void
     */
    public function execute(array $commandSubject)
    {

        /** @var PaymentDataObjectInterface $paymentDataObject */
        $paymentDataObject = $commandSubject['payment'];

        /** @var Payment $payment */
        $payment = $paymentDataObject->getPayment();

        // Status
        $payment->setAdditionalInformation('status', 'VOIDED');
        $payment->setIsTransactionClosed(true);
        $payment->setShouldCloseParentTransaction(true);

        // Pix information
        $payment->setAdditionalInformation('qr_code_image', '');

        $this->paymentRepository->save($payment);
    }
}