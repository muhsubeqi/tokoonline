<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{
    public function index() {

        $categories = Category::where('parent_id', null)->get();

        return view('admin.category.index', compact('categories'));
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::where('parent_id', null)->select('*');
            return DataTables::of($data)
                ->editColumn('subCategory', function($row){
                    $sub = '<ul>';
                        foreach ($row->children as $subCategory) {
                            $sub .= '<li>' . $subCategory->name . '</li>';
                        }
                    $sub .= '</ul>';
                    return $sub;
                })
                ->editColumn('icon', function($row){
                    $icon = isset($row->icon) != null ? $row->icon : '';
                    $content = '
                        <i class="'. $icon .'"></i>
                    ';
                    return $content;
                })
                ->addColumn('action', function($row){
                    $actionBtn = '
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button"
                            id="dropdownMenuButton" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            Klik
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="' . route('admin.category.subCategory', ['subCategory' => $row->id]) .'">Sub Kategori</a>
                            <button type="button" class="dropdown-item" 
                                data-toggle="modal" data-target="#modal_edit"
                                data-id="' . $row->id . '"
                                data-name="' . $row->name . '"
                                data-slug="' . $row->slug . '"
                                data-icon="' . $row->icon . '"
                                >Edit</button>
                            <form action="" onsubmit="deleteData(event)" method="POST">
                            ' . method_field('delete') . csrf_field() . '
                                <input type="hidden" name="id" value="' . $row->id .'">
                                <input type="hidden" name="name" value="' . $row->name .'">
                                <button type="submit" class="dropdown-item text-danger">
                                    Delete    
                                </button>
                            </form>
                        </div>
                    </div>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'subCategory', 'icon'])
                ->toJson();
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'slug' => 'required',
                'icon' => 'nullable',
                'parent_id' => 'nullable'
            ]);

            $category = new Category;
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->icon = $request->icon;
            $category->parent_id = $request->parent_id;
            $category->save();

            $data = [
                'status' => 200,
                'message' => 'Berhasil menambah data kategori',
            ];

        } catch (\Throwable $th) {
            $data = [
                'status' => 500,
                'message' => 'Gagal menambah data kategori',
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
                'icon_edit' => 'nullable',
            ]);

            $category = Category::where('id', $request->id_edit)->first();
            $category->name = $request->name_edit;
            $category->slug = $request->slug_edit;
            $category->icon = $request->icon_edit;
            $category->save();

            $data = [
                'status' => 200,
                'message' => 'Berhasil mengubah data kategori',
            ];

        } catch (\Throwable $th) {
            $data = [
                'status' => 500,
                'message' => 'Gagal mengubah data kategori',
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
    
            $category = Category::find($request->id);
            $category->delete();
    
            $data = [
                'status' => 200,
                'message' => 'Berhasil menghapus data kategori',
            ];
        } catch (\Throwable $th) {
            $data = [
                'status' => 500,
                'message' => 'Gagal menghapus data kategori',
            ];
        }
        return $data;
    }

    public function subCategory($subCategory)
    {
        $category = Category::where('id', $subCategory)->first();
        $sub = Category::where('parent_id', $subCategory)->get();
        $categories = Category::where('parent_id', null)->get();
       
        return view('admin.category.sub-category', compact('sub', 'category', 'categories'));
    }

    public function updateSubCategory(Request $request)
    {
        try {
            $request->validate([
                'id_edit' => 'required',
                'name_edit' => 'required',
                'slug_edit' => 'required',
                'icon_edit' => 'nullable',
                'parent_id_edit' => 'nullable',
            ]);

            $category = Category::where('id', $request->id_edit)->first();
            $category->name = $request->name_edit;
            $category->slug = $request->slug_edit;
            $category->icon = $request->icon_edit;
            $category->parent_id = $request->parent_id_edit;
            $category->save();

            $data = [
                'status' => 200,
                'message' => 'Data berhasil diubah',
            ];

            return $data;
        } catch (\Throwable $th) {
            //throw $th;
            return $th->getMessage();
        }
    }

    public function deleteSubCategory(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required'
            ]);
    
            $category = Category::find($request->id);
            $category->delete();
    
            $data = [
                'status' => 200,
                'message' => 'Berhasil menghapus data sub kategori',
            ];
        } catch (\Throwable $th) {
            $data = [
                'status' => 500,
                'message' => 'Gagal menghapus data sub kategori',
            ];
        }
        return $data;
    }

}