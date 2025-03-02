<?php

namespace App\Http\Controllers;

use App\Helpers\RequestHelper;
use App\Helpers\SplitwiseHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class SplitwiseController extends Controller
{
    public function createExpenseView()
    {
        $splitwiseHelper = new SplitwiseHelper();
        $categories = $splitwiseHelper->listCategories();
        $groups = $splitwiseHelper->listGroups();
        $members = $splitwiseHelper->listMembers();

        return Inertia::render('Splitwise', [
            'groups' => $groups,
            'categories' => $categories,
            'members' => $members
        ]);
    }

    public function createExpense(Request $request)
    {
        $data = RequestHelper::requestToArray($request);

        $token = $data['member']['name'] == 'Rubén' ? 'IqkLiNcQYjRuopAQSp15QgTKorV696PSQ3uoU9OC' : 'Y1Cbe3HVO64MULCE3mmViiQtsmfwoctHAMLfclqS';

        $response = Http::withToken($token)
                        ->post('https://secure.splitwise.com/api/v3.0/create_expense', [
                            "cost" => $data['cost'],
                            "description" => $data['description'],
                            "details" => null,
                            "date" => $data['date'],
                            "repeat_interval" => "never",
                            "currency_code" => "EUR",
                            "category_id" => $data['category']['id'],
                            "group_id" => $data['group']['id'],
                            "split_equally" => true
                        ]);
        Log::info($response->status());
    }

    public function listGroups()
    {
        return (new SplitwiseHelper())->listGroups();
    }

    public function listCategories()
    {
        return (new SplitwiseHelper())->listCategories();
    }

    public function listMembers()
    {
        return (new SplitwiseHelper())->listMembers();
    }

}
