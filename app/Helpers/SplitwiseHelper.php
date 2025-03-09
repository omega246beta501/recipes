<?php
namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Sleep;

class SplitwiseHelper {
    public function listMembers()
    {
        return [
            [
                'name' => 'Rubén'
            ],
            [
                'name' => 'Marta'
            ]
        ];
    }

    public function listCategories()
    {
        // $response = Http::withToken('IqkLiNcQYjRuopAQSp15QgTKorV696PSQ3uoU9OC')
        //                 ->get('https://secure.splitwise.com/api/v3.0/get_categories');
        
        // $body = $response->json();

        // $categories = collect($body['categories']);
        // $categories = $categories->sortBy('name')->values();
        // $categories->transform(function($item) {
        //     $subcategories = collect($item['subcategories']);
        //     $subcategories->transform(function($subcategory) {
        //         return [
        //             'id' => $subcategory['id'],
        //             'name' => $subcategory['name'],
        //             'icon' => $subcategory['icon_types']['square']['large'],
        //         ];
        //     });
        //     return [
        //         'id' => $item['id'],
        //         'name' => $item['name'],
        //         'subcategories' => $subcategories,
        //     ];
        // });
        
        $path = storage_path('/app/splitwise/categories.json'); // Adjust path accordingly

        if (!file_exists($path)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        return json_decode(Storage::disk('local')->get('splitwise/categories.json'), true);
    }

    public function listGroups()
    {
        $groups = Cache::remember('_splitwise_groups', 1000, function() {
            $response = Http::withToken('IqkLiNcQYjRuopAQSp15QgTKorV696PSQ3uoU9OC')
                            ->get('https://secure.splitwise.com/api/v3.0/get_groups');
            
            $body = $response->json();
    
            $groups = collect($body['groups']);
            $groups->forget(0); // Delete first element as is a summary group
            $groups = $groups->sortByDesc('updated_at')->values();
            $groups->transform(function($item) {
                return [
                    'id' => $item['id'],
                    'name' => $item['name'],
                ];
            });
    
            return $groups;
        });

        return $groups;

        // return [
        //     [
        //         'id' => 70010141,
        //         'name' => 'Nueva vida Almería',
        //     ],
        //     [
        //         'id' => 30183981,
        //         'name' => 'Pisukituki',
        //     ],
        // ];
    }

    public function listExpenses()
    {
        $expenses = Cache::remember('_splitwise_expenses', 1000, function() {
            $response = Http::withToken('IqkLiNcQYjRuopAQSp15QgTKorV696PSQ3uoU9OC')
                            ->get('https://secure.splitwise.com/api/v3.0/get_expenses?limit=100');
            
            $body = $response->json();
    
            $expenses = collect();

            if ($body == null) { return $expenses; }

            foreach ($body['expenses'] as $item) {
                $repaymentsTo = $item['repayments'][0]['to'] ?? null;
                if ($item['deleted_at'] == null && in_array($item['group_id'], [30183981, 70010141]) && $item['description'] != 'Payment' && $repaymentsTo == 43056804) {
                    $expenses->push([
                        'id' => $item['id'],
                        'description' => $item['description'],
                        'cost' => $item['cost'],
                        'group_id' => $item['group_id'],
                        'category_id' => $item['category']['id'],
                        'date' => explode('T', $item['date'])[0],
                    ]);
                }
            }
    
            return $expenses;
        });

        return $expenses;
    }

    public function createExpense($data)
    {
        $token = $data['member']['name'] == 'Rubén' ? 'IqkLiNcQYjRuopAQSp15QgTKorV696PSQ3uoU9OC' : 'Y1Cbe3HVO64MULCE3mmViiQtsmfwoctHAMLfclqS';

        $date = $data['date'];

        $response = Http::withToken($token)
                        ->post('https://secure.splitwise.com/api/v3.0/create_expense', [
                            "cost" => (string) $data['cost'],
                            "description" => $data['description'],
                            "details" => null,
                            "date" => "{$date}T13:00:00Z",
                            "repeat_interval" => "never",
                            "currency_code" => "EUR",
                            "category_id" => $data['category']['id'],
                            "group_id" => $data['group']['id'],
                            "split_equally" => true
                        ]);
        Log::info($response->body());
    }

    public function getGocardlessToken()
    {
        return Cache::remember('_gocardless_token', 86400, function() {
            $response = Http::post('https://bankaccountdata.gocardless.com/api/v2/token/new/', [
                'secret_id' => '4dca1157-793c-4409-9ea2-2dd46e076d2a',
                'secret_key' => '3ea2de4e28c3950bb5557102cbef5e288eb60179d3b599215557be7a042e075b2e150fa77c00aece1b8c6f6bda1cf2aaa641bbd5b9a76e368c83856d415e6e6c',
            ]);
    
            if ($response->ok()) {
                return $response->json()['access'];
            }
        });
    }

    public function getLastTransactions($fromDate)
    {
        // $token = $this->getGocardlessToken();
        // $response = Http::withToken($token)
        //                 ->get("https://bankaccountdata.gocardless.com/api/v2/accounts/5048c2f9-b777-48a4-8eda-27b6660c222a/transactions/");
        // Retrieve and decode the stored transactions
        $transactions = json_decode(Storage::disk('local')->get('splitwise/json.json'), true);
    
        return collect($transactions['transactions']['booked'])
            ->filter(function ($transaction) use ($fromDate) {
                $conceptSplit = collect(explode(' // ', $transaction['remittanceInformationUnstructured']));
    
                // Only consider negative transactions that are after the given date and not matching a specific header.
                return $transaction['transactionAmount']['amount'] < 0
                    && $conceptSplit->first() !== "TRASPASO PROGRAMA TU CUENTA"
                    && $transaction['valueDate'] >= $fromDate;
            })
            ->map(function ($transaction) {
                $conceptSplit = collect(explode(' // ', $transaction['remittanceInformationUnstructured']));
                $conceptHeader = preg_replace('/\s+/', ' ', trim($conceptSplit->last()));
                $conceptTail = " // {$conceptSplit->first()}";

                $category = $this->calculateCategory($transaction['remittanceInformationUnstructured']);
                $group = $this->calculateGroup($transaction['remittanceInformationUnstructured']);

                $conceptFinal = ($category || $group) ? $conceptHeader : "{$conceptHeader}{$conceptTail}";
                return [
                    'transactionId' => $transaction['transactionId'],
                    'bookingDate'   => $transaction['bookingDate'],
                    'valueDate'     => $transaction['valueDate'],
                    'amount'        => abs($transaction['transactionAmount']['amount']),
                    'category'      => $category,
                    'group'         => $group,
                    'concept'       => $conceptFinal,
                ];
            });
    }
    public function getNotSplittedTransactions()
    {
        $notSplitedTransactions = collect();
        $expenses = $this->listExpenses();
        if (count($expenses)) {
            $lastDateExpense = $expenses->first()['date'];
            $transactions = $this->getLastTransactions($lastDateExpense);

            foreach ($transactions as $transaction) {
                $found = false;
                foreach ($expenses as $expense) {
                    if ($expense['cost'] == $transaction['amount'] && $expense['date'] == $transaction['valueDate']) {
                        $found = true;
                        break;
                    }
                }

                if (!$found) {
                    $notSplitedTransactions->push($transaction);
                }
            }
        }

        return $notSplitedTransactions;
    }

    private function calculateCategory($concept)
    {
        switch ($concept) {
            case str_contains(strtolower($concept), "bizum") && str_contains(strtolower($concept), "agua"):
                return SplitwiseCategory::WATER->value;
                break;
            case str_contains(strtolower($concept), "bizum") && str_contains(strtolower($concept), "luz"):
                return SplitwiseCategory::ELECTRICITY->value;
                break;
            case str_contains($concept, "CHATGPT"):
                return SplitwiseCategory::SERVICES->value;
                break;
            case str_contains($concept, "COMPRAS A DISTANCIA Y SUSCRIPCIONES"):
                return SplitwiseCategory::OTHER->value;
                break;
            case str_contains($concept, "DEPORTES Y JUGUETES"):
                return SplitwiseCategory::SPORTS->value;
                break;
            case str_contains($concept, "GASOLINERAS"):
                return SplitwiseCategory::GAS_FUEL->value;
                break;
            case str_contains($concept, "GRANDES SUPERFICIES"):
                return SplitwiseCategory::GROCERIES->value;
                break;
            case str_contains($concept, "HOGAR, MUEBLES, DECORACION Y ELECTR"):
                return SplitwiseCategory::HOUSEHOLD_SUPPLIES->value;
                break;
            case str_contains($concept, "MODA, CALZADO Y COMPLEMENTOS"):
                return SplitwiseCategory::CLOTHING->value;
                break;
            case str_contains($concept, "RESTAURANTES Y CAFETERIAS"):
                return SplitwiseCategory::DINING_OUT->value;
                break;
            case str_contains($concept, "SECTOR DEL AUTOMOVIL"):
                return SplitwiseCategory::CAR->value;
                break;
            case str_contains($concept, "SUPERMERCADOS"):
                return SplitwiseCategory::GROCERIES->value;
                break;
            case str_contains($concept, "PayPal Europe"): // Google fotos
                return SplitwiseCategory::SERVICES->value;
                break;
            default:
                return null;
                break;
        }
    }

    private function calculateGroup($concept)
    {
        if (str_contains(strtolower($concept), 'bizum')) {
            if (str_contains(strtolower($concept), 'agua') || str_contains(strtolower($concept), 'luz')) {
                return SplitwiseGroup::PISUKITUKI->value;
            }
        }

        return null;
    }

    public function createExpensesFromTransactions()
    {
        $groupId = SplitwiseGroup::ALMERIA_TOGETHER->value;
        $categoryId = SplitwiseCategory::GENERAL->value;

        $notSplitedTransactions = $this->getNotSplittedTransactions();

        foreach ($notSplitedTransactions as $transaction) {
            $this->createExpense([
                'cost' => $transaction['amount'],
                'date' => $transaction['valueDate'],
                'description' => $transaction['concept'],
                'category' => [
                    'id' => $transaction['category'] ?? $categoryId,
                ],
                'group' => [
                    'id' => $transaction['group'] ?? $groupId,
                ],
                'member' => [
                    'name' => 'Rubén',
                ]
            ]);
            Sleep::for(10)->seconds();
        }
    }
}