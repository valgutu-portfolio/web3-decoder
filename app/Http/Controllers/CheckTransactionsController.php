<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class CheckTransactionsController extends Controller
{
    protected const CSV_HEADERS = [
        // from json
        'chain',
        'currency',
        'transaction_hash',
        'buyer',
        'timestamp',
        'datetime',
        'total_raised',

        // true or false
        'match',

        // from db
        'id',
        'wallet_address',
        'purchase_type',
        'purchase_type_amount',
        'purchase_usd_amount',
        'revenue_share',
        'click_id',
        'event',
        'status',
        'created_at',
    ];

    public function __invoke(Request $request)
    {
        $data = json_decode($request->file('file')->getContent(), true);

        $this->processTransactions($data);
    }

    private function processTransactions(array $data): bool
    {
        $exportFilename = sprintf('exports/transactions-%s.csv', date('d-m-YTH-i-s'));
        $this->createCsv($exportFilename);

        $solanaProgramTransactions = $data['Solana']['events']['program']['sol'] ?? [];
        $solanaWalletTransactions = $data['Solana']['events']['wallet']['sol'] ?? [];
        $solTransactions = array_merge($solanaWalletTransactions, $solanaProgramTransactions);
        $data['Solana']['events']['sol'] = $solTransactions;

        unset($data['Solana']['events']['program']);
        unset($data['Solana']['events']['wallet']);

        $count = 0;
        foreach ($data as $chainName => $chain) {
            if ($chainName === 'initial') {
                continue;
            }
            foreach ($chain as $purchaseTypes) {
                foreach ($purchaseTypes as $purchaseType => $transactions) {
                    foreach ($transactions as $hash => $transaction) {
                        $count++;
                        $dbTransaction = $this->findTransaction($purchaseType, $transaction['buyer'] ?? '');
                        $hasMatch = !empty($dbTransaction) ? 'true' : 'false';
                        $datetime = Carbon::createFromTimestamp($transaction['timestamp'])->toDateTimeString();

                        $row = [
                            // from json
                            'chain' => $chainName,
                            'currency' => $purchaseType,
                            'transaction_hash' => $hash,
                            'buyer' => $transaction['buyer'],
                            'timestamp' => $transaction['timestamp'],
                            'datetime' => $datetime,
                            'total_raised' => $transaction['totalRaised'],

                            // true or false
                            'match' => $hasMatch,

                            // from db
                            'id' => $dbTransaction['id'] ?? '',
                            'wallet_address' => $dbTransaction['wallet_address'] ?? '',
                            'purchase_type' => $dbTransaction['purchase_type'] ?? '',
                            'purchase_type_amount' => $dbTransaction['purchase_type_amount'] ?? '',
                            'purchase_usd_amount' => $dbTransaction['purchase_usd_amount'] ?? '',
                            'revenue_share' => $dbTransaction['revenue_share'] ?? '',
                            'click_id' => $dbTransaction['click_id'] ?? '',
                            'event' => $dbTransaction['event'] ?? '',
                            'status' => $dbTransaction['status'] ?? '',
                            'created_at' => $dbTransaction['created_at'] ?? '',
                        ];
                        $this->exportRow($exportFilename, $row);
                    }
                }
            }
        }
        dd($count);

        return true;
    }

    private function findTransaction(string $purchaseType, string $buyer): array
    {
        $query = DB::table('presale_transactions');
        $query->whereIn('event', ['conversion', 'revenue']);
        $query->where('purchase_type', $purchaseType);
        $query->where('wallet_address', $buyer);
        return (array) $query->first();
    }

    private function createCsv(string $filename): void
    {
        Storage::disk('local')->put($filename, implode(',', self::CSV_HEADERS));
    }

    private function exportRow(string $filename, array $row): void
    {
        $path = Storage::disk('local')->path($filename);
        File::append($path, PHP_EOL.implode(',', $row));
    }


//    private function export(string $filename, array $headers, array $data)
//    {
//        $path = Storage::disk('local')->path($filename);
//
//        if (!empty($headers)) {
//            File::append($path, PHP_EOL.implode(',', $headers));
//        }
//
//        foreach ($data as $row) {
//            File::append($path, PHP_EOL.implode(',', $row));
//        }
//    }
}
