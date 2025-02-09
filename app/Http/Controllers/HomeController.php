<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Quotation;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\PaymentHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function get_dashboard_data(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $clinic_id = Auth::user()->clinic_id;

        $total_patient = User::where('type', 3)
            ->where('clinic_id', $clinic_id)
            ->where('status', 1)
            ->whereBetween(DB::raw('DATE(created_at)'), [$start_date, $end_date])
            ->count();

        $total_appointment = Appointment::where('clinic_id', $clinic_id)
            ->where('status', 1)
            ->whereBetween(DB::raw('DATE(created_at)'), [$start_date, $end_date])
            ->count();

        $total_procedure = Quotation::where('clinic_id', $clinic_id)
            ->where('status', 1)
            ->whereBetween(DB::raw('DATE(created_at)'), [$start_date, $end_date])
            ->count();

        $total_revenue = PaymentHistory::where('clinic_id', $clinic_id)
            ->whereBetween(DB::raw('DATE(created_at)'), [$start_date, $end_date])
            ->sum('amount');

        return response()->json([
            'total_patient' => $total_patient,
            'total_appointment' => $total_appointment,
            'total_procedure' => $total_procedure,
            'total_revenue' => $total_revenue,
        ]);
    }
}
