<?php

namespace App\Http\Controllers\Api;

use App\Models\Expense;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filter = Expense::filter(request(['start_date', 'end_date', 'order_by_amount', 'order_by_date', 'order_by_created_at']));
        $total_amount = $filter->sum('amount');
        $expenses = $filter->latest()->paginate(10)->withQueryString();

        return response()->json([
            'total_amount' => $total_amount,
            'expenses' => $expenses,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExpenseRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExpenseRequest $request, Expense $expense)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        //
    }
}
