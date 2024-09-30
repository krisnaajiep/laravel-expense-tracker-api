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
     * Scope a query to only include filter expenses.
     */
    public function scopeFilter(Builder $query, array $filters): void
    {
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

        $query->when($filters['end_date'] ?? false, function (Builder $query, string $end_date) use ($filters) {
            $end_date = Carbon::parse($end_date);

            $query->when($filters['start_date'] ?? false, function (Builder $query, string $start_date,) use ($end_date) {
                $query->where('date_time', '>', Carbon::parse($start_date))
                    ->where('date_time', '<', $end_date);
            }, function () use ($query, $end_date) {
                $query->where('date_time', '<', $end_date);
            });
        });
    }
}
