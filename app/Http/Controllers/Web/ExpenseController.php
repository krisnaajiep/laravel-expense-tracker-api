<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Services\Web\FilterRequestString;
use Illuminate\Pagination\LengthAwarePaginator;

class ExpenseController extends Controller
{
    public function __construct(
        protected FilterRequestString $filterRequestString
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $current_page = LengthAwarePaginator::resolveCurrentPage();

        $request->merge(['page' => $current_page]);

        $response = Http::get('http://expense-tracker-api.test/api/expenses', $request->all());

        if ($response->status() === 500) abort(500);

        $total_amount = number_format($response->json('total_amount'), 2, ',', '.');

        $expenses = $response->object()->expenses;

        $expenses_data = collect($expenses->data)->map(function ($expense) {
            $expense->amount = number_format($expense->amount, 2, ',', '.');
            $expense->date_time = Carbon::parse($expense->date_time)->locale('id')->translatedFormat('l, j F Y');
            return $expense;
        });

        $filter_request = $this->filterRequestString->generate(request('start_date'), request('end_date'));

        $paginator = new LengthAwarePaginator(
            $expenses->data,
            $expenses->total,
            $expenses->per_page,
            $current_page,
            ['path' => $request->url(), 'query' => $request->query()],
        );

        $start_number = ($paginator->currentPage() - 1) * $paginator->perPage() + 1;

        return view('expenses.index', [
            'user' => session('user'),
            'total_amount' => $total_amount,
            'expenses_data' => $expenses_data,
            'filter_request' => $filter_request,
            'paginator' => $paginator,
            'start_number' => $start_number,
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
