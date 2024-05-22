<?php

namespace App\Http\Controllers;

use App\Services\LogsDecoder\EventAbi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use phpseclib\Math\BigInteger;
use Web3\Contracts\Ethabi;

class LogsDecoderController extends Controller
{
    protected $abiService;

    public function __construct(Ethabi $abiService)
    {
        $this->abiService = $abiService;
    }

    public function __invoke(Request $request)
    {
        // set precision to display big numbers
        ini_set('precision',50);

        $abi = new EventAbi($request->get('eventAbi'));

        $logs = $request->get('logs');
        $topics = $logs['topics'] ?? [];
        $data = $logs['data'] ?? '';

        $decodedLogs = $this->decodeLogs($abi, $topics, $data);

        return new JsonResponse(['logs' => $decodedLogs]);
    }

    private function decodeLogs(EventAbi $abi, array $topics, string $data): array
    {
        $decodedTopics = $this->decodeTopics($abi, $topics);
        $decodedData = $this->decodeData($abi, $data);
        return array_merge($decodedTopics, $decodedData);
    }

    private function decodeTopics(EventAbi $abi, array $topics): array
    {
        $decodedTopics = [];

        if (count($topics) > count($abi->getIndexedInputs())) {
            // remove topics[0] as it is the eventHash
            array_shift($topics);
        }

        foreach ($abi->getIndexedInputs() as $key => $input) {
            $decodedInput = $this->abiService->decodeParameter($input['type'], $topics[$key]);
            if ($decodedInput instanceof BigInteger) {
                $decodedTopics[$input['name']] = $decodedInput->toString();
            } else {
                $decodedTopics[$input['name']] = $decodedInput;
            }
        }

        return $decodedTopics;
    }

    private function decodeData(EventAbi $abi, string $data): array
    {
        $decodedData = [];

        $decodedInputs = $this->abiService->decodeParameters($abi->getInputsTypes(false), $data);
        foreach ($abi->getNonIndexedInputs() as $key => $input) {
            $decodedInput = $decodedInputs[$key];

            if ($decodedInput instanceof BigInteger) {
                $decodedData[$input['name']] = $decodedInput->toString();
            } else {
                $decodedData[$input['name']] = $decodedInput;
            }
        }

        return $decodedData;
    }
}
