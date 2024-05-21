<?php

namespace App\Services\LogsDecoder;

class DecoderHelpers
{
    public static function remove0x(string $data): string
    {
        $prefix = '0x';
        // remove 0x from the beginning of the data
        if (substr($prefix, 0, strlen($prefix)) == $prefix) {
            $data = substr($data, strlen($prefix));
        }
        return $data;
    }

    public static function filterInputs(array $eventAbi, bool $indexed): array
    {
        $inputs = $eventAbi['inputs'];
        $nonIndexedInputs = [];
        foreach ($inputs as $input) {
            if ($indexed === $input['indexed']) {
                $nonIndexedInputs[] = $input;
            }
        }
        return $nonIndexedInputs;
    }
}
