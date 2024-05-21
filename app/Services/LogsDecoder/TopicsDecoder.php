<?php

namespace App\Services\LogsDecoder;

class TopicsDecoder
{
    public static function decode(array $eventAbi, array $topics): array
    {
        $inputs = DecoderHelpers::filterInputs($eventAbi, true);

        $result[0] = $topics[0];
        unset($topics[0]);

        foreach ($inputs as $pos => $input) {
            $topicPos = $pos + 1;
            $result[$input['name']] = ParamDecoder::decode($input['internalType'], $topics[$topicPos]);
        }
        return $result;
    }
}
