<?php

namespace App\Http\Controllers\Admin;

use App\Exports\TransactionExport;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Services\BulkData;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TransactionController extends Controller
{
    public function index()
    {
        return view('admin.transaction.index');
    }

    public function getData(Request $request)
    {
        $search = $request->input('search.value');
        $status = $request->statusFilter;
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $data = Transaction::join('products as p', 'p.id', '=', 'transactions.products_id')
            ->join('users as u', 'u.id', '=', 'transactions.users_id')
            ->join('cities as c', 'c.id', '=', 'transactions.cities_id')
            ->groupBy('transactions.code')
            ->orderBy('transactions.id', 'DESC')
            ->select('transactions.id', 'transactions.code', 'transactions.qty', 'transactions.subtotal', 'transactions.created_at', 'transactions.photo', 'transactions.ekspedisi', 'transactions.status', 'p.name as product', 'c.city_name as city', 'u.username as username');
        return DataTables::of($data)
            ->filter(function ($query) use ($search, $status, $startDate, $endDate) {
                if (!empty($startDate && $endDate)) {
                    $query->where(function ($q) use ($startDate, $endDate) {
                        $q->whereDate('transactions.created_at', '>=', $startDate)
                            ->whereDate('transactions.created_at', '<=', $endDate);
                    });
                }
                if (!empty($status)) {
                    $query->where(function ($q) use ($status) {
                        $q->where('transactions.status', $status);
                    });
                }
                if (!empty($search)) {
                    $query->where(function ($q) use ($search) {
                        $q->orWhere('transactions.id', 'LIKE', "%$search%")
                            ->orWhere('transactions.code', 'LIKE', "%$search%")
                            ->orWhere('u.username', 'LIKE', "%$search%")
                            ->orWhere('c.city_name', 'LIKE', "%$search%")
                            ->orWhere('transactions.qty', 'LIKE', "%$search%")
                            ->orWhere('transactions.subtotal', 'LIKE', "%$search%")
                            ->orWhere('transactions.ekspedisi', 'LIKE', "%$search%")
                            ->orWhere('transactions.status', 'LIKE', "%$search%");
                    });
                }
            })
            ->editColumn('username', function ($row) {
                return $row->username;
            })
            ->editColumn('product', function ($row) {
                return $row->product;
            })
            ->editColumn('total', function ($row) {
                $transaction = Transaction::where('code', $row->code)->with('product')->get();
                $subtotal = $transaction->sum('subtotal');
                $ongkir = $row->ekspedisi['value'];
                $total = $subtotal + $ongkir;
                return number_format($total, 0, '', '.');
            })
            ->editColumn('ekspedisi', function ($row) {
                return $row->ekspedisi['code'];
            })
            ->addColumn('pembayaran', function ($row) {
                $content = '';
                if ($row->photo != null) {
                    $content = '
                            <button type="button" class="btn btn-sm btn-link" 
                            data-toggle="modal" data-target="#modal_pembayaran"
                            data-id="' . $row->id . '"
                            data-photo="' . $row->photo . '"
                            >Lihat Pembayaran</button>';
                } else {
                    $content = 'Belum ada pembayaran';
                }
                return $content;
            })
            ->editColumn('status', function ($row) {
                $status = BulkData::statusPembayaran;
                $dataStatus = '';
                foreach ($status as $s) {
                    if ($row->status == $s['id']) {
                        $dataStatus .= '<option value="' . $s['id'] . '" selected>' . $s['name'] . '</option>';
                    } else {
                        $dataStatus .= '<option value="' . $s['id'] . '">' . $s['name'] . '</option>';
                    }
                }
                $code = explode("-", $row->code);
                $form = '
                        <form action="" method="POST" id="form_status">
                            ' . csrf_field() . '
                            <select class="form-control select2bs4" name="status" id="status_pembayaran" onchange="editStatus(event, ' . $code[1] . ')">
                                ' . $dataStatus . '
                            </select>
                        </form>
                    ';
                return $form;
            })
            ->addColumn('action', function ($row) {
                // list product yang dibeli
                $transaction = Transaction::where('code', $row->code)->with('product', 'city')->get();
                $trans = json_encode($transaction);
                $trans = rawurlencode($trans);
                // sub total product
                $subtotal = $transaction->sum('subtotal');
                $type = $transaction[0]->city->type;
                $city = $transaction[0]->city->city_name;
                // price expedisi
                $ongkir = $transaction[0]->ekspedisi['value'];
                $codeEks = $transaction[0]->ekspedisi['code'];
                $nameEks = $transaction[0]->ekspedisi['name'];
                $etdEks = $transaction[0]->ekspedisi['etd'];

                $grandtotal = $subtotal + $ongkir;

                $statusData = BulkData::statusPembayaran;
                $status = '';
                foreach ($statusData as $sd) {
                    if ($sd['id'] == $row->status) {
                        $status .= $sd['name'];
                    }
                }

                $actionBtn = '
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button"
                        id="dropdownMenuButton" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        Klik
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <button type="button" class="dropdown-item" 
                            data-toggle="modal" data-target="#modal_detail"
                            data-id="' . $row->id . '"
                            data-code="' . $row->code . '"
                            data-name="' . $row->username . '"
                            data-cities_id="' . $city . '"
                            data-type="' . $type . '"
                            data-status="' . $status . '"
                            data-trans="' . $trans . '"
                            data-subtotal="' . $subtotal . '"
                            data-ongkir="' . $ongkir . '"
                            data-grandtotal="' . $grandtotal . '"
                            data-code-eks="' . $codeEks . '"
                            data-name-eks="' . $nameEks . '"
                            data-etd-eks="' . $etdEks . '"
                            data-buy-date="' . date('d M Y', strtotime($row->created_at)) . '"
                            >Detail</button>
                        <form action="" onsubmit="deleteData(event)" method="POST">
                        ' . method_field('delete') . csrf_field() . '
                            <input type="hidden" name="id" value="' . $row->id . '">
                            <input type="hidden" name="code" value="' . $row->code . '">
                            <button type="submit" class="dropdown-item text-danger">
                                Delete    
                            </button>
                        </form>
                    </div>
                </div>';
                return $actionBtn;
            })
            ->rawColumns(['action', 'username', 'product', 'pembayaran', 'status', 'ekspedisi', 'total'])
            ->toJson();
        if ($request->ajax()) {
        }
    }

    public function pdf(Request $request)
    {
        try {
            $request->validate([
                'code_pdf' => 'required'
            ]);

            $transaction = Transaction::where('code', $request->code_pdf)
                ->get();

            $total = [];
            foreach ($transaction as $row) {
                $total[] = $row->subtotal;
            }

            $pdf = PDF::loadView('admin.transaction.pdf', compact('transaction'));
            return $pdf->download($request->code_pdf . '.' . 'pdf');

        } catch (\Throwable $th) {
            //throw $th;
            return $th->getMessage();
        }
    }

    public function status(Request $request)
    {
        try {
            $request->validate([
                'code' => 'required',
                'status' => 'required'
            ]);

            $code = "INV-" . $request->code;

            $transaction = Transaction::where('code', $code)->get();
            foreach ($transaction as $t) {
                $t->status = $request->status;
                $t->save();
            }

            $data = [
                'status' => 200,
                'message' => 'Status pembayaran berhasil diubah'
            ];

        } catch (\Throwable $th) {
            $data = [
                'status' => 500,
                'message' => $th->getMessage()
            ];
        }

        return $data;
    }

    public function delete(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required',
                'code' => 'required'
            ]);

            $transaction = Transaction::where('code', $request->code)->get();
            foreach ($transaction as $row) {
                $row->delete();
            }

            $data = [
                'status' => 200,
                'message' => 'Data transaksi berhasil dihapus'
            ];

        } catch (\Throwable $th) {
            $data = [
                'status' => 500,
                'message' => 'Data transaksi gagal dihapus'
            ];
        }

        return $data;
    }

    public function print(Request $request)
    {
        $request->validate([
            'code_print' => 'required'
        ]);

        $transaction = Transaction::where('code', $request->code_print)
            ->get();

        $total = [];
        foreach ($transaction as $row) {
            $total[] = $row->subtotal;
        }

        return view('admin.transaction.print', compact('transaction', 'total'));
    }

    public function export(Request $request)
    {
        $status = $request->status_filter;
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        return Excel::download(new TransactionExport($status, $startDate, $endDate), 'transaction.xlsx');
    }
}