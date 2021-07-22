<?php

declare(strict_types = 1);

namespace App\Charts;

use Carbon\Carbon;
use App\Models\Order;
use Chartisan\PHP\Chartisan;
use Illuminate\Http\Request;
use ConsoleTVs\Charts\BaseChart;

class TrackingUserOrder extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        $totalDayOfCurrentMonth = date('t');
        $labels = [];
        $datasets = [];

        for ($i = 1; $i <= $totalDayOfCurrentMonth; $i++) {
            ${"day" . $i} = Carbon::now()->format('Y-m-' . $i);
            $labels[] = $i;
        }

        for ($i = 1; $i <= $totalDayOfCurrentMonth; $i++) {
            if ($i == $totalDayOfCurrentMonth) {
                $splitTime = explode('-', ${'day' . $i});
                $betweenTime = [${"day" . ($i)}, $splitTime[0] . '-' . ($splitTime[1] + 1) . '-01'];
                ${"orderIn" . $i . "Day"} = Order::whereBetween('created_at', $betweenTime)->count();
            } else {
                $betweenTime = [${"day" . ($i)}, ${"day" . ($i + 1)}];
                ${"orderIn" . $i . "Day"} = Order::whereBetween('created_at', $betweenTime)->count();
            }

            $datasets[] = ${"orderIn" . $i . "Day"};
        }

        return Chartisan::build()
            ->labels($labels)
            ->dataset('data', $datasets);
    }
}
