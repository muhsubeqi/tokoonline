<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class TransactionExport implements FromView
{
    protected $status;
    protected $startDate;
    protected $endDate;
    public function __construct($status, $startDate, $endDate)
    {
        $this->status = $status;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function view(): View
    {
        $transactions = Transaction::with('city', 'user', 'product')->groupBy('code');
        if ($this->status) {
            $transactions->where('status', $this->status);
        }
        if ($this->startDate && $this->endDate) {
            $transactions->whereDate('created_at', '>=', $this->startDate)
                ->whereDate('created_at', '<=', $this->endDate);
        }
        $transactions = $transactions->get();
        return view('admin.transaction.export', compact('transactions'));
    }
}