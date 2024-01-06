<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    public function index()
    {
        $categories = Category::where('parent_id', null)->get();
        return view('admin.product.index', compact('categories'));
    }

    public function getData(Request $request)
    {
        $search = $request->input('search.value');
        if ($request->ajax()) {

            $data = Product::join('categories as c', 'c.id', '=', 'products.categories_id')
                ->join('users as u', 'u.id', '=', 'products.users_id')
                ->select('products.*', 'c.name as category', 'u.name as uploader');

            return DataTables::of($data)
                ->filter(function ($query) use ($search) {
                    $query->orWhere('products.id', 'LIKE', "%$search%")
                        ->orWhere('products.name', 'LIKE', "%$search%")
                        ->orWhere('products.stock', 'LIKE', "%$search%")
                        ->orWhere('products.price', 'LIKE', "%$search%")
                        ->orWhere('c.name', 'LIKE', "%$search%")
                        ->orWhere('u.name', 'LIKE', "%$search%");
                })
                ->editColumn('photo', function ($row) {
                    $url = asset('data/product/' . $row->photo);
                    return '<img src="' . $url . '" border="0" class="img-rounded" style="width:70px;height:70px;" align="center" />';
                })
                ->editColumn('cat', function ($row) {
                    $cat = '';
                    isset($row->category) ? $cat .= $row->category : $cat .= 'Tidak Ada Kategori';
                    return $cat;
                })
                ->editColumn('uploader', function ($row) {
                    return $row->uploader;
                })
                ->addColumn('action', function ($row) {
                    $description = rawurlencode($row->description);
                    $actionBtn = '
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button"
                            id="dropdownMenuButton" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            Klik
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <button type="button" class="dropdown-item" 
                                data-toggle="modal" data-target="#modal_edit"
                                data-id="' . $row->id . '"
                                data-name="' . $row->name . '"
                                data-slug="' . $row->slug . '"
                                data-description="' . $description . '"
                                data-stock="' . $row->stock . '"
                                data-weight="' . $row->weight . '"
                                data-price="' . $row->price . '"
                                data-categories_id="' . $row->categories_id . '"
                                data-photo="' . $row->photo . '"
                                >Edit</button>
                            <form action="" onsubmit="deleteData(event)" method="POST">
                            ' . method_field('delete') . csrf_field() . '
                                <input type="hidden" name="id" value="' . $row->id . '">
                                <input type="hidden" name="name" value="' . $row->name . '">
                                <button type="submit" class="dropdown-item text-danger">
                                    Delete    
                                </button>
                            </form>
                        </div>
                    </div>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'photo', 'cat', 'uploader'])
                ->toJson();
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'slug' => 'required',
                'description' => 'nullable',
                'stock' => 'required',
                'weight' => 'required',
                'price' => 'required',
                'categories_id' => 'required',
            ]);

            $product = new Product;
            $product->name = $request->name;
            $product->slug = $request->slug;
            $product->description = $request->description;
            $product->stock = $request->stock;
            $product->weight = $request->weight;
            $product->price = $request->price;
            $product->categories_id = $request->categories_id;
            $product->users_id = auth()->user()->id;
            if ($request->has('photo')) {
                $lokasi = 'data/product/';
                $photo = $request->file('photo');
                $extensi = $request->file('photo')->extension();
                $new_photo_name = 'Photo' . date('YmdHis') . uniqid() . '.' . $extensi;
                $photo->move(public_path($lokasi), $new_photo_name);
                $product->photo = $new_photo_name;
            }
            $product->save();

            $data = [
                'status' => 200,
                'message' => 'Berhasil menambah data produk',
            ];

        } catch (\Throwable $th) {
            $data = [
                'status' => 500,
                'message' => 'Gagal menambah data produk',
            ];
        }
        return $data;
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'id_edit' => 'required',
                'name_edit' => 'required',
                'slug_edit' => 'required',
                'description_edit' => 'nullable',
                'stock_edit' => 'required',
                'weight_edit' => 'required',
                'price_edit' => 'required',
                'categories_id_edit' => 'required',
            ]);

            $namaPhoto = $request->input('photo_old');

            $product = Product::where('id', $request->id_edit)->first();
            $product->name = $request->name_edit;
            $product->slug = $request->slug_edit;
            $product->description = $request->description_edit;
            $product->stock = $request->stock_edit;
            $product->weight = $request->weight_edit;
            $product->price = $request->price_edit;
            $product->categories_id = $request->categories_id_edit;
            $product->users_id = auth()->user()->id;
            if ($request->has('photo_edit')) {
                $lokasi = 'data/product/';
                $photo = $request->file('photo_edit');
                $extensi = $request->file('photo_edit')->extension();
                $new_photo_name = 'Photo' . date('YmdHis') . uniqid() . '.' . $extensi;
                $upload = $photo->move(public_path($lokasi), $new_photo_name);
                $namaPhoto = $new_photo_name;
                if ($upload) {
                    $getPhoto = Product::find($request->id_edit)->photo;
                    if ($getPhoto != null) {
                        File::delete(public_path('data/product/' . $getPhoto));
                    }
                }

                $product->photo = $namaPhoto;
            }
            $product->save();

            $data = [
                'status' => 200,
                'message' => 'Berhasil mengubah data produk',
            ];

        } catch (\Throwable $th) {
            $data = [
                'status' => 500,
                'message' => 'Gagal mengubah data produk',
            ];
        }

        return $data;
    }

    public function delete(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required'
            ]);

            $product = Product::find($request->id);
            $getImage = $product->photo;
            if ($getImage != null) {
                File::delete(public_path('data/product/' . $getImage));
            }
            $product->delete();

            $data = [
                'status' => 200,
                'message' => 'Berhasil menghapus data produk',
            ];
        } catch (\Throwable $th) {
            $data = [
                'status' => 500,
                'message' => 'Gagal menghapus data produk',
            ];
        }
        return $data;
    }
}