<?php

namespace App\Http\Controllers;

use App\Services\LogsDecoder\LogsDataDecoder;
use App\Services\LogsDecoder\TopicsDecoder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LogsDecoderController extends Controller
{
    public function __invoke(Request $request)
    {
        // set precision to display big numbers
        ini_set('precision',50);

        // get input parameters
        $logs = $request->input('logs');
        $topics = $logs['topics'] ?? [];
        $hexData = $logs['data'] ?? []; // data is a hexadecimal string which contains all non-indexed parameters
        $eventAbi = $request->input('eventAbi');

        $decodedData = LogsDataDecoder::decode($eventAbi, $hexData);
        $decodedTopics = TopicsDecoder::decode($eventAbi, $topics);

        return new JsonResponse(['topics' => $decodedTopics, 'data' => $decodedData]);
    }
}
