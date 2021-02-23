<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Charts\EvaluateChart;

class EvaluateChartController extends Controller
{
    public static function index() {
        $usersChart = new EvaluateChart;
        $usersChart->labels(['Jan', 'Feb', 'Mar']);
        $usersChart->dataset('Users by trimester', 'line', [10, 25, 13]);
        return view('quiz.chart', [ 'usersChart' => $usersChart ] );
    } 
}
