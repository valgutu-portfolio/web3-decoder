<?php

namespace App\Repositories\Orders\DTO;

class CreateOrderRequest
{
    public function __construct(
        protected ?int $orderNumber = null,
        protected string $currency = 'BYN',
        protected int $amount = 0,
        protected string $phone = '',
        protected string $email = '',
        protected ?string $returnUrl = null,
        protected ?string $failUrl = null,
        protected ?string $language = 'ru',
        protected ?string $jsonParams = null,
        protected ?string $expirationDate = null,
        protected ?int $externalOrderId = null,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'order_number' => $this->orderNumber,
            'currency' => $this->currency,
            'amount' => $this->amount,
            'language' => $this->language,
            'email' => $this->email,
            'phone' => $this->phone,
            'return_url' => $this->returnUrl,
            'fail_url' => $this->failUrl,
            'json_params' => $this->jsonParams,
            'expiration_date' => $this->expirationDate,
            'external_order_id' => $this->externalOrderId,
        ];
    }
}
