<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromView;

use Illuminate\Contracts\View\View;

class ReportExport implements FromView
{
    protected $startDate;
    protected $endDate;
    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function view(): View
    {
        $startDate = $this->startDate;
        $endDate = $this->endDate;
        $reports = Transaction::with('city', 'user', 'product')->groupBy('code')->where('status', '=', '4');
        if ($startDate && $endDate) {
            $reports->whereDate('created_at', '>=', $startDate)
                ->whereDate('created_at', '<=', $endDate);
        }
        $reports = $reports->get();
        return view('admin.report.export', compact('reports', 'startDate', 'endDate'));
    }
}