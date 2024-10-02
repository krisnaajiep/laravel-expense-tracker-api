<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

class Expense extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    /**
     * Scope a query to only include filter expenses.
     */
    public function scopeFilter(Builder $query, array $filters): void
    {
        $query->when($filters['search'] ?? false, function (Builder $query, string $search) {
            $query->where('category', 'like', '%' . $search . '%')
                ->orWhere('payment_method', 'like', '%' . $search . '%');
        });

        $query->when($filters['start_date'] ?? false, function (Builder $query, string $start_date) {
            switch ($start_date) {
                case 'past_week':
                    $query->where('date_time', '>', now()->subWeeks(1));
                    break;

                case 'last_month':
                    $query->where('date_time', '>', now()->subMonths(1));
                    break;

                case 'last_3_months':
                    $query->where('date_time', '>', now()->subMonths(3));
                    break;

                default:
                    $query->where('date_time', '>', Carbon::parse($start_date));
                    break;
            }
        });

        $query->when($filters['end_date'] ?? false, function (Builder $query, string $end_date) {
            $query->where('date_time', '<', Carbon::parse($end_date));
        });

        $query->when($filters['order_by_amount'] ?? false, function (Builder $query, string $order_by_amount) {
            $query->orderBy('amount', $order_by_amount);
        });

        $query->when($filters['order_by_date'] ?? false, function (Builder $query, string $order_by_date) {
            $query->orderBy('date_time', $order_by_date);
        });

        $query->when($filters['order_by_created_at'] ?? false, function (Builder $query, string $order_by_created_at) {
            $query->orderBy('created_at', $order_by_created_at);
        });
    }
}
