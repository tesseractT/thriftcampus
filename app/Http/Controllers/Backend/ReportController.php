<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DateTime;
use App\Models\Order;
use App\Models\User;

class ReportController extends Controller
{
    public function ReportView()
    {
        return view('backend.report.report_view');
    } //End Method

    public function SearchByDate(Request $request)
    {
        $date = new DateTime($request->date);
        $formattedDate = $date->format('d F Y');

        $orders = Order::where('order_date', $formattedDate)->latest()->get();

        return view('backend.report.report_by_date', compact('orders', 'formattedDate'));
    } //End Method

    public function SearchByMonth(Request $request)
    {
        $month = $request->month;
        $year = $request->year_name;

        $orders = Order::where('order_month', $month)->where('order_year', $year)->latest()->get();

        return view('backend.report.report_by_month', compact('orders', 'month', 'year'));
    } //End Method

    public function SearchByYear(Request $request)
    {

        $year = $request->year;

        $orders = Order::where('order_year', $year)->latest()->get();
        return view('backend.report.report_by_year', compact('orders', 'year'));
    } // End Method

    public function OrderByUser()
    {
        $users = User::where('role', 'user')->latest()->get();
        return view('backend.report.report_by_user', compact('users'));
    } //End Method

    public function SearchByUser(Request $request)
    {
        $users = $request->user;
        $orders = Order::where('user_id', $users)->latest()->get();
        return view('backend.report.report_by_user_search', compact('orders', 'users'));
    } // End Method
}
