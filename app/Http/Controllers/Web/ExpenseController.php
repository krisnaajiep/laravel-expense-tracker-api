<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Services\Web\FilterRequestString;

class ExpenseController extends Controller
{
    public function __construct(
        protected FilterRequestString $filterRequestString
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = Http::get('http://expense-tracker-api.test/api/expenses', [
            'start_date' => request('start_date'),
            'end_date' => request('end_date'),
        ]);

        $expenses = collect($response->object()->expenses)->map(function ($expense) {
            $expense->amount = number_format($expense->amount, 2, ',', '.');
            $expense->date_time = Carbon::parse($expense->date_time)->locale('id')->translatedFormat('l, j F Y');
            return $expense;
        });

        $filter_request = $this->filterRequestString->generate(request('start_date'), request('end_date'));

        return view('expenses.index', [
            'user' => session('user'),
            'expenses' => $expenses,
            'filter_request' => $filter_request,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
