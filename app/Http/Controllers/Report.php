<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Product;

class Report extends Controller
{
    public function salesReport()
    {
        return redirect()->route('reports.sales');
    }
}
