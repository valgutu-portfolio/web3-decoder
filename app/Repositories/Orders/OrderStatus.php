<?php

namespace App\Repositories\Orders;

class OrderStatus
{
    public const PENDING = 0;
    public const PAID = 2;
    public const RETURNED = 4;
    public const FAILED = 6;

    public const PENDING_NAME = 'pending';
    public const PAID_NAME = 'paid';
    public const FAILED_NAME = 'failed';
    public const RETURNED_NAME = 'returned';

    private const STATUS = [
        self::PENDING => self::PENDING_NAME,
        self::PAID => self::PAID_NAME,
        self::FAILED => self::FAILED_NAME,
        self::RETURNED => self::RETURNED_NAME
    ];

    public static function status(int $id): string
    {
        return static::STATUS[$id] ?? static::FAILED_NAME;
    }

    public static function statusesList(): array
    {
        return [
            static::PENDING,
            static::PAID,
            static::FAILED,
            static::RETURNED,
        ];
    }
}
