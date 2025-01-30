<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Expense::class);

        $filter = Expense::where('user_id', Auth::user()->id)->filter(request(['category', 'start_date', 'end_date']));

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
        $validated = $request->validated();
        $validated['user_id'] = Auth::user()->id;

        $data = Expense::create($validated);

        return response()->json([
            'message' => 'Data stored successfully',
            'data' => $data,
        ], 201);
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
