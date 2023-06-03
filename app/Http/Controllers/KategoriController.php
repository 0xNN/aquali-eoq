<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Barang;
use Exception;
use DataTables;

class KategoriController extends Controller
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

    public function index()
    {
        if(request()->ajax()){
            $kategori = Kategori::all();
            return DataTables::of($kategori)
            ->addColumn('action', function($kategori){
                $btn = '<div class="btn-group" role="group">
                <button type="button" class="btn btn-sm btnEdit btn-secondary" data-id="'.$kategori->id.'">Edit</button>
                <button type="button" class="btn btn-sm btnDelete btn-danger" data-id="'.$kategori->id.'">Delete</button>
                </div>';
                return $btn;
            })
            ->editColumn('is_eoq', function($kategori){
                return $kategori->is_eoq == 1 ? '<span class="badge rounded-pill bg-success">Ya</span>' : '<span class="badge rounded-pill bg-danger">Tidak</span>';
            })
            ->addIndexColumn()
            ->rawColumns(['action','is_eoq'])
            ->make(true);
        }
        $kategori = Kategori::all();
        $barang = Barang::all();
        return view("kategori.index", compact("kategori","barang"));
    }

    public function store()
    {
        try {
            if (request()->nama_kategori == null) {
                throw new Exception("Nama kategori tidak boleh kosong");
            }
            if (Kategori::where("nama_kategori", request()->nama_kategori)->count() > 0) {
                throw new Exception("Nama kategori sudah ada");
            }
            $kategori = new Kategori;
            $kategori->nama_kategori = request()->nama_kategori;
            $kategori->is_eoq = request()->is_eoq == "true" ? 1 : 0;
            $kategori->save();

            return response()->json([
                "status" => "success",
                "message" => "Berhasil menambahkan kategori"
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        try {
            $kategori = Kategori::find($id);
            if ($kategori == null) {
                throw new Exception("Kategori tidak ditemukan");
            }
            return response()->json([
                "status" => "success",
                "data" => $kategori
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => $e->getMessage()
            ], 500);
        }
    }

    public function update($id)
    {
        try {
            $kategori = Kategori::find($id);
            if ($kategori == null) {
                throw new Exception("Kategori tidak ditemukan");
            }
            if (request()->nama_kategori == null) {
                throw new Exception("Nama kategori tidak boleh kosong");
            }
            $kategori->nama_kategori = request()->nama_kategori;
            $kategori->is_eoq = request()->is_eoq == "true" ? 1 : 0;
            $kategori->save();

            return response()->json([
                "status" => "success",
                "message" => "Berhasil mengubah kategori"
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {

            $kategori = Kategori::find($id);
            if($kategori->barang->count() > 0){
                throw new Exception("Kategori masih memiliki barang");
            }
            if ($kategori == null) {
                throw new Exception("Kategori tidak ditemukan");
            }
            $kategori->delete();

            return response()->json([
                "status" => "success",
                "message" => "Berhasil menghapus kategori"
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
