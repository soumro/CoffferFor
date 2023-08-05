<?php

declare(strict_types=1);

namespace coffeforme\Service;

use coffeforme\Model\Payment as PaymentModel;
use stdClass;

class Payment
{
    private const PAYPAL_PAYMENT_URL = 'https://www.paypal.com/cgi-bin/websrc';
    private PaymentModel $paymentModel;

    public function __construct()
    {
        $this->paymentModel = new PaymentModel();
    }

    public function create(array $paymentDetails): string|bool
    {
        return $this->paymentModel->insert($paymentDetails);
    }

    public function getDetails(string $userId)
    {
        return $this->paymentModel->getDetails($userId);
    }

    public function isPaymentExists(string $userId): bool
    {
        return $this->paymentModel->isDetailsExists($userId);
    }

    public function updatePaymentDetails(string $userId, string $paypalEmail, string $currency)
    {
        return $this->paymentModel->updateDetails($userId, $paypalEmail, $currency);
    }

    public function getPayPalLink(stdClass $itemDetails): string
    {
        $queries = [
            'cmd' => '_xclick',
            'business' => $itemDetails->paypalEmail,
            'itemName' => $itemDetails->itemName,
            'amount' => $itemDetails->price,
            'currency_code' => $itemDetails->currency
        ];

        return self::PAYPAL_PAYMENT_URL . '?' . http_build_query($queries);
    }
}