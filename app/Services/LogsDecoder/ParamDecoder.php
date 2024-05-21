<?php

namespace App\Services\LogsDecoder;

class ParamDecoder
{
    private const TYPES = [
        'number' => 'uint256',
        'address' => 'address',
    ];

    /**
     * @throws \Exception
     */
    public static function decode(string $type, string $hex): string
    {
        if (!in_array($type, static::TYPES)) {
            throw new \Exception('Invalid type.');
        }
        return match ($type) {
            static::TYPES['number'] => static::decodeNumber($hex),
            static::TYPES['address'] => static::decodeAddress($hex),
            default => '',
        };
    }

    private static function decodeNumber(string $hex): string
    {
        return strval(hexdec($hex));
    }

    private static function decodeAddress(string $address): string
    {
        // remove 0x to process the string
        $address = DecoderHelpers::remove0x($address);
        // remove 0s
        $address = ltrim($address, '0');
        // append 0x back
        return '0x'.$address;
    }
}
