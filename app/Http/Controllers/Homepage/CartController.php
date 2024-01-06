<?php

namespace App\Http\Controllers\Homepage;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Transaction;
use App\Services\Rajaongkir;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'qty' => 'required',
            'product_id' => 'required'
        ]);

        $product = Product::where('id', $request->product_id)->first();

        Cart::add(['id' => $product->id, 'name' => $product->name, 'qty' => $request->qty, 'price' => $product->price]);

        Cart::content();
        return back()->with('success', 'Berhasil ditambahkan ke keranjang');
    }

    public function cartDetail()
    {
        $products = Product::select('stock')->get();
        return view('homepage.cart.cart', compact('products'));
    }

    public function cartDelete($rowId)
    {
        Cart::remove($rowId);
        return redirect()->route('cart.detail');
    }

    public function form()
    {
        $city = City::all();

        return view('homepage.cart.form', compact('city'));
    }

    public function getCity(Request $request)
    {
        $id = $request->input('id');

        $city = City::with('province')->get();

        foreach ($city as $c) {
            if ($c->id == $id) {
                $data = $c;
                break;
            } else {
                $data = 'no data';
            }
        }

        return $data;
    }

    public function transaction(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'city_id' => 'required',
            'province' => 'required',
            'portal_code' => 'required',
            'ekspedisi' => 'required'
        ]);

        $invoice = 'INV-' . date('ymdhis') . auth()->user()->id;
        $storeCity = Setting::where('setting', 'store_city')->first();

        foreach (Cart::content() as $row) {
            $product = Product::findOrFail($row->id);


            // pengiriman set dari setting city
            $origin = $storeCity->tool1;
            $destination = $request->city_id;
            $weight = $product->weight * intval($row->qty);
            // dd($product, intval($row->qty), $weight);
            $courier = $request->ekspedisi;

            $cost = Rajaongkir::cost($origin, $destination, $weight, $courier);
            $data = json_decode($cost, true);
            Cart::update(
                $row->rowId,
                [
                    "options" =>
                        [
                            'code' => $data['rajaongkir']['results'][0]['code'],
                            'name' => $data['rajaongkir']['results'][0]['name'],
                            'value' => $data['rajaongkir']['results'][0]['costs'][0]['cost'][0]['value'],
                            'etd' => $data['rajaongkir']['results'][0]['costs'][0]['cost'][0]['etd'],
                        ]
                ]
            );

            $transaction = new Transaction;
            $transaction->code = $invoice;
            $transaction->users_id = auth()->user()->id;
            $transaction->products_id = $product->id;
            $transaction->qty = $row->qty;
            $transaction->subtotal = $row->subtotal;
            $transaction->cities_id = $request->city_id;
            $transaction->status = '1';
            $transaction->ekspedisi = [
                'code' => $row->options->code,
                'name' => $row->options->name,
                'value' => $row->options->value,
                'etd' => $row->options->etd,
            ];

            $transaction->save();

            $product->stock = $product->stock - $row->qty;
            $product->save();

            Cart::remove($row->rowId);
        }

        if (Cart::count() == 0) {
            return redirect()->route('cart.myorder');
        }
    }

    public function myorder()
    {
        $transactions = Transaction::where('users_id', auth()->user()->id)->groupBy('code')->paginate(10);

        return view('homepage.cart.myorder', compact('transactions'));
    }

    public function upload(Request $request)
    {
        $namaPhoto = $request->input('photo_old');

        $transaction = Transaction::where('code', $request->code)->first();

        if ($request->has('photo')) {
            $lokasi = 'data/transaction/';
            $photo = $request->file('photo');
            $extensi = $request->file('photo')->extension();
            $new_photo_name = 'Photo' . date('YmdHis') . uniqid() . '.' . $extensi;
            $upload = $photo->move(public_path($lokasi), $new_photo_name);
            $namaPhoto = $new_photo_name;
            if ($upload) {
                $getPhoto = Transaction::where('code', $request->code)->first();
                $getPhoto = $getPhoto->photo;
                if ($getPhoto != null) {
                    File::delete(public_path('data/transaction/' . $getPhoto));
                }
            }
            $transaction->photo = $namaPhoto;
        }

        $transaction->status = "2";
        $transaction->save();

        return redirect()->route('cart.myorder')->with('success', 'Berhasil Upload Bukti Pembayaran');

    }

    public function detailOrder($code)
    {

        $transaction = Transaction::where('code', $code)->with('product', 'user')->get();

        return view('homepage.cart.detail-order', compact('transaction'));
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
                $getImage = $row->photo;
                if ($getImage != null) {
                    File::delete(public_path('data/transaction/' . $getImage));
                }
                $row->delete();
            }

            $data = [
                'status' => 200,
                'message' => 'Data pesanan berhasil dihapus'
            ];

        } catch (\Throwable $th) {
            $data = [
                'status' => 500,
                'message' => 'Data pesanan gagal dihapus'
            ];
        }

        return $data;
    }
}