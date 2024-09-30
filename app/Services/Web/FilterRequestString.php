<?php

namespace App\Services\Web;

use Illuminate\Support\Carbon;

class FilterRequestString
{
  public function generate(?string $start_date, ?string $end_date): ?string
  {
    if (!is_null($end_date)) {
      $start_date = Carbon::parse($start_date)->format('j F Y');
      $end_date = Carbon::parse($end_date)->format('j F Y');

      $string = 'from ' . $start_date . ' to ' . $end_date;
    } else {
      switch ($start_date) {
        case 'past_week':
          $string = 'Past Week';
          break;

        case 'last_month':
          $string = 'Last Month';
          break;

        case 'last_3_months':
          $string = 'Last 3 Months';
          break;

        default:
          $string = null;
          break;
      }
    }

    return $string;
  }
}
