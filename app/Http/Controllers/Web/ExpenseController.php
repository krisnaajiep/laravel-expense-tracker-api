<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Services\Web\DateRangeString;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, DateRangeString $date_range_string)
    {
        $request->merge(['page' => LengthAwarePaginator::resolveCurrentPage()]);

        $response = Http::get('http://expense-tracker-api.test/api/expenses', $request->all());

        if ($response->status() === 500) abort(500);

        $expenses_data = collect($response->object()->expenses->data)->map(function ($expense) {
            $expense->amount = number_format($expense->amount, 2, ',', '.');
            $expense->date_time = Carbon::parse($expense->date_time)->translatedFormat('l, j F Y');
            return $expense;
        });

        $paginator = new LengthAwarePaginator(
            $response->object()->expenses->data,
            $response->object()->expenses->total,
            $response->object()->expenses->per_page,
            LengthAwarePaginator::resolveCurrentPage(),
            ['path' => $request->url(), 'query' => $request->query()],
        );

        return view('expenses.index', [
            'user' => session('user'),
            'total_amount' => number_format($response->json('total_amount'), 2, ',', '.'),
            'expenses_data' => $expenses_data,
            'date_range_string' => $date_range_string(request('start_date'), request('end_date')),
            'paginator' => $paginator,
            'start_number' => ($paginator->currentPage() - 1) * $paginator->perPage() + 1,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('expenses.create', [
            'user' => session('user'),
        ]);
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
