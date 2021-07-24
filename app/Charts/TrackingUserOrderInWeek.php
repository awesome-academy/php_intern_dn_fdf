<?php

declare(strict_types=1);

namespace App\Charts;

use Carbon\Carbon;
use App\Models\Order;
use Chartisan\PHP\Chartisan;
use Illuminate\Http\Request;
use ConsoleTVs\Charts\BaseChart;

class TrackingUserOrderInWeek extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        $monday = strtotime("last monday");
        $monday = date('w', $monday) == date('w') ? $monday + 7 * 86400 : $monday;

        $mon = date("Y-m-d", strtotime(date("Y-m-d", $monday)));
        $tue = date("Y-m-d", strtotime(date("Y-m-d", $monday)  . " +1 days"));
        $wed = date("Y-m-d", strtotime(date("Y-m-d", $monday)  . " +2 days"));
        $thu = date("Y-m-d", strtotime(date("Y-m-d", $monday)  . " +3 days"));
        $fri = date("Y-m-d", strtotime(date("Y-m-d", $monday)  . " +4 days"));
        $sat = date("Y-m-d", strtotime(date("Y-m-d", $monday)  . " +5 days"));
        $sun = date("Y-m-d", strtotime(date("Y-m-d", $monday)  . " +6 days"));
        $monNextWeek = date("Y-m-d", strtotime(date("Y-m-d", $monday)  . " +7 days"));

        $orderInMon = Order::whereBetween('created_at', [$mon, $tue])->count();
        $orderInTue = Order::whereBetween('created_at', [$tue, $wed])->count();
        $orderInWed = Order::whereBetween('created_at', [$wed, $thu])->count();
        $orderInThu = Order::whereBetween('created_at', [$thu, $fri])->count();
        $orderInFri = Order::whereBetween('created_at', [$fri, $sat])->count();
        $orderInSat = Order::whereBetween('created_at', [$sat, $sun])->count();
        $orderInSun = Order::whereBetween('created_at', [$sun, $monNextWeek])->count();

        $labels = [
            trans('homepage.mon'),
            trans('homepage.tue'),
            trans('homepage.wed'),
            trans('homepage.thu'),
            trans('homepage.fri'),
            trans('homepage.sat'),
            trans('homepage.sun'),
        ];

        $datasets = [
            $orderInMon,
            $orderInTue,
            $orderInWed,
            $orderInThu,
            $orderInFri,
            $orderInSat,
            $orderInSun,
        ];

        return Chartisan::build()
            ->labels($labels)
            ->dataset('data', $datasets);
    }
}
