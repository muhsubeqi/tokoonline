<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ReportExport;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Services\BulkData;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.report.index');
    }

    public function export(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        return Excel::download(new ReportExport($startDate, $endDate), 'report.xlsx');
    }

    public function income(Request $request)
    {
        $reports = Transaction::with('city', 'user', 'product')->groupBy('code')->where('status', '=', '4');
        if ($request->start_date && $request->end_date) {
            $reports->whereDate('created_at', '>=', $request->start_date)
                ->whereDate('created_at', '<=', $request->end_date);
        }
        $reports = $reports->get();

        $productTotal = 0;
        $costTotal = 0;
        $incomeTotal = 0;
        foreach ($reports as $row) {
            $products = Transaction::where('code', $row->code)->get();
            $subtotal = $products->sum('subtotal');
            $productTotal += $subtotal;
            $costTotal += $row->ekspedisi['value'];
            $total = $subtotal - $row->ekspedisi['value'];
            $incomeTotal += $total;
        }

        $data = [
            'productTotal' => $productTotal,
            'costTotal' => $costTotal,
            'incomeTotal' => $incomeTotal,
        ];

        return $data;
    }
}