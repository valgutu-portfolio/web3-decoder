<?php

namespace App\Repositories\Orders\DTO;

class UpdateOrderRequest
{
    public function __construct(
        protected ?int $id = null,
        protected ?int $orderNumber = null,
        protected ?string $paymentSystemOrderId = null,
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
        protected ?int $status = null,
    )
    {
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function orderNumber(): ?int
    {
        return $this->orderNumber;
    }

    public function paymentSystemOrderId(): ?string
    {
        return $this->paymentSystemOrderId;
    }

    public function currency(): string
    {
        return $this->currency;
    }

    public function amount(): int
    {
        return $this->amount;
    }

    public function phone(): string
    {
        return $this->phone;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function returnUrl(): ?string
    {
        return $this->returnUrl;
    }

    public function failUrl(): ?string
    {
        return $this->failUrl;
    }

    public function language(): ?string
    {
        return $this->language;
    }

    public function jsonParams(): ?string
    {
        return $this->jsonParams;
    }

    public function expirationDate(): ?string
    {
        return $this->expirationDate;
    }

    public function externalOrderId(): ?int
    {
        return $this->externalOrderId;
    }

    public function status(): ?int
    {
        return $this->status;
    }
}
