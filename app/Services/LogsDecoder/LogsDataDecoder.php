<?php

namespace App\Services\LogsDecoder;

class LogsDataDecoder
{
    public static function decode(array $eventAbi, string $hexData): array
    {
        $inputs = $eventAbi['inputs'];

        $inputs = DecoderHelpers::filterInputs($eventAbi, false);

        $dataParts = static::splitDataIntoParts($hexData, count($inputs));

        $data = [];
        foreach ($inputs as $pos => $input) {
            $data[$input['name']] = ParamDecoder::decode($input['internalType'], $dataParts[$pos]);
        }
        return $data;
    }

    private static function splitDataIntoParts(string $hexData, int $countDataParams): array
    {
        $dataPartLength = strlen($hexData)/$countDataParams;
        $data = DecoderHelpers::remove0x($hexData);
        return str_split($data, $dataPartLength);
    }
}
