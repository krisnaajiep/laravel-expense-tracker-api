<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    /** @use HasFactory<\Database\Factories\ExpenseFactory> */
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<string>|bool
     */
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    /**
     * Get the user that owns the expense.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include filter expenses.
     */
    public function scopeFilter(Builder $query, array $filters): void
    {
        $query->when($filters['category'] ?? false, function (Builder $query, string $category) {
            $query->where('category', 'like', '%' . $category . '%');
        });

        $query->when($filters['start_date'] ?? false, function (Builder $query, string $start_date) {
            switch ($start_date) {
                case 'past_week':
                    $query->where('created_at', '>', now()->subWeeks(1));
                    break;

                case 'last_month':
                    $query->where('created_at', '>', now()->subMonths(1));
                    break;

                case 'last_3_months':
                    $query->where('created_at', '>', now()->subMonths(3));
                    break;

                default:
                    $query->where('created_at', '>', Carbon::parse($start_date));
                    break;
            }
        });

        $query->when($filters['end_date'] ?? false, function (Builder $query, string $end_date) {
            $query->where('created_at', '<', Carbon::parse($end_date));
        });
    }
}
