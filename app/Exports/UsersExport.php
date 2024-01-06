<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class UsersExport implements FromView
{
    protected $gender;
    protected $status;
    protected $startDate;
    protected $endDate;
    public function __construct($gender, $status, $startDate, $endDate)
    {
        $this->gender = $gender;
        $this->status = $status;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function view(): View
    {
        $users = User::query();
        if ($this->gender) {
            $users->where('gender', $this->gender);
        }
        if ($this->status) {
            $users->where('status', $this->status);
        }
        if ($this->startDate && $this->endDate) {
            $users->whereDate('created_at', '>=', $this->startDate)
                ->whereDate('created_at', '<=', $this->endDate);
        }
        $users = $users->get();

        return view('admin.user.export', compact('users'));
    }
}