<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Payments;
use Faker\Provider\ar_SA\Payment;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $items = Payments::where('name', Auth::user()->name)->get();
        return view('pages.student.index', [
            'items' => $items
        ]);
    }
}
