<?php

declare(strict_types=1);

namespace coffeforme\Controller;

use coffeforme\Kernel\Input;
use coffeforme\Kernel\PhpTemplate\View;
use coffeforme\Kernel\Session;
use coffeforme\Service\User as UserService;
use coffeforme\Service\UserSession as UserSessionService;
use coffeforme\Service\Payment as PaymentService;
use coffeforme\Service\Item as ItemService;
use coffeforme\Service\UserValidation;
use stdClass;


class Payment extends Base
{
    public const DEFAULT_CURRENCY = 'USD';
    private PaymentService $paymentService;
    private UserValidation $userValidation;
    private UserService $userService;
    private ItemService $itemService;
    public function __construct()
    {
        parent::__construct();
        $this->userService = new UserService();
        $this->paymentService = new PaymentService();
        $this->userValidation = new UserValidation();
        $this->itemService = new ItemService();
        // $this->isLoggedIn = $this->userSessionService->isLoggedin();
    }

    public function payment(): void
    {
        $viewVariables = [
            'isLoggedIn' => $this->isLoggedIn
        ];
        $userId = $this->userSessionService->getId();
        $ispaymentExist = $this->paymentService->isPaymentExists($userId);

        if (Input::postExists('payment_submit')) {
            $paypalEmail = Input::post('paypal_email');
            $currency = Input::post('currency');

            if (isset($paypalEmail, $currency)) {
                if (!$this->userValidation->isEmailValid($paypalEmail)) {
                    $viewVariables[view::ERROR_MESSAGE_KEY] = 'Paypal Email is not Valid';
                } elseif ($ispaymentExist) {
                    $this->paymentService->updatePaymentDetails($userId, $paypalEmail, $currency);

                    $viewVariables[view::SUCCESS_MESSAGE_KEY] = 'Payment Details Saved';
                } else {
                    $paymentDetails = [
                        'userId' => $userId,
                        'paypalEmail' => $paypalEmail,
                        'currency' => $currency
                    ];
                    $this->paymentService->create($paymentDetails);
                    $viewVariables[view::SUCCESS_MESSAGE_KEY] = 'Payment Details Added';
                }
            } else {
                $viewVariables[view::ERROR_MESSAGE_KEY] = 'All fields are required';
            }

        }
        $viewVariables['paypalEmail'] = '';
        $viewVariables['currency'] = self::DEFAULT_CURRENCY;
        if ($ispaymentExist && $paymentDetails = $this->paymentService->getDetails($userId)) {

            $viewVariables['paypalEmail'] = $paymentDetails->paypalEmail;
            $viewVariables['currency'] = $paymentDetails->currency;

        }
        View::output('payment/payment', 'Payment Gateway', $viewVariables);
    }

    public function item(): void
    {
        $viewVariables = [
            'isLoggedIn' => $this->isLoggedIn,
            'isFieldDisabled' => false,
        ];

        $userId = $this->userSessionService->getId();
        $doesItemExist = $this->itemService->hasUserAnItem($userId);

        if (!$this->paymentService->isPaymentExists($userId)) {
            $viewVariables['isFieldDisabled'] = true;
            $message = sprintf('⚠️ You need to set <a href="%s">Your Payment Method</a> First', site_url('/payment'));
            $viewVariables[view::ERROR_MESSAGE_KEY] = $message;
        }

        if (Input::postExists('item_submit')) {

            $idName = Input::post('id_name');
            $itemName = Input::post('item_name');
            $businessName = Input::post('business_name');
            $summary = Input::post('summary');
            $price = Input::post('price');

            if (isset($idName, $itemName, $summary)) {

                if (!$this->doesItemNameAlreadyExists($idName, $this->itemService->getfromUserId($userId))) {
                    $inputItemDetails = [
                        'idName' => $idName,
                        'itemName' => $itemName,
                        'businessName' => $businessName,
                        'summary' => $summary,
                        'price' => (float) $price
                    ];


                    $doesItemExist ?
                        $this->itemService->update($userId, $inputItemDetails) :
                        $this->itemService->create($userId, $inputItemDetails);

                    $viewVariables[view::SUCCESS_MESSAGE_KEY] = 'Successfully Saved';
                } else {
                    $viewVariables[view::ERROR_MESSAGE_KEY] = sprintf('The %s Id Name Already Exists', $idName);
                }
            } else {
                $viewVariables[view::ERROR_MESSAGE_KEY] = 'Some fields are required';
            }

        }
        $viewVariables['idName'] = '';
        $viewVariables['itemName'] = '';
        $viewVariables['businessName'] = '';
        $viewVariables['summary'] = '';
        $viewVariables['price'] = '';
        if ($doesItemExist) {
            if ($doesItemExist && $itemDetails = $this->itemService->getfromUserId($userId)) {

                $viewVariables['idName'] = $itemDetails->idName;
                $viewVariables['itemName'] = $itemDetails->itemName;
                $viewVariables['businessName'] = $itemDetails->businessName;
                $viewVariables['summary'] = $itemDetails->summary;
                $viewVariables['price'] = $itemDetails->price;
                $viewVariables['shareItemUrl'] = $this->itemService->getUserItemUrl($itemDetails->idName);
            }
        }
        View::output('payment/item', 'Edit Item', $viewVariables);
    }

    private function doesItemNameAlreadyExists(string $idName, bool|stdClass $itemDetails): bool
    {
        if (!empty($itemDetails->idName) && $itemDetails->idName === $idName) {
            return false;
        }
        return $this->itemService->doesItemNameExists($idName);
    }

    public function showItem(): void
    {
        $viewVariables = [
            'isLoggedIn' => $this->isLoggedIn
        ];

        $idName = Input::get('id');

        if ($itemData = $this->itemService->getfromIdName($idName)) {

            $viewVariables += [
                'idName' => $itemData->idName,
                'itemName' => $itemData->itemName,
                'businessName' => $itemData->businessName,
                'summary' => $itemData->summary,
                'price' => $itemData->price,
                'payemntLink' => $this->paymentService->getPayPalLink($itemData),
                'currency' => $itemData->currency
            ];

            $pageTitle = sprintf('Item %s', $itemData->itemName);

            View::output('payment/show', $pageTitle, $viewVariables);
        } else {
            $this->pageNotfound();
        }
    }
}