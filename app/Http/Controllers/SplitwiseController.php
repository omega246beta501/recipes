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
        (new SplitwiseHelper())->createExpense($data);
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

    public function createExpenseFromBank()
    {
        $splitwiseHelper = new SplitwiseHelper();
        return $splitwiseHelper->createExpensesFromTransactions();
    }
}
