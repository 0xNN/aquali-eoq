<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\Barang;
use DataTables;
use Exception;

class SupplierController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if(request()->ajax()){
            $supplier = Supplier::all();
            return DataTables::of($supplier)
            ->addColumn('action', function($supplier){
                $btn = '<div class="btn-group" role="group">
                <button type="button" class="btn btn-sm btnEdit btn-secondary" data-id="'.$supplier->id.'">Edit</button>
                <button type="button" class="btn btn-sm btnDelete btn-danger" data-id="'.$supplier->id.'">Delete</button>
                </div>';
                return $btn;
            })
            ->editColumn('nama_supplier', function($supplier){
                return "<a href='javascript:void(0)' data-id='".$supplier->id."' class='btn btnDetail btn-sm btn-info'>".$supplier->nama_supplier."</a>";
            })
            ->addIndexColumn()
            ->rawColumns(['action','nama_supplier'])
            ->make(true);
        }
        $supplier = Supplier::all();
        $barang = Barang::all();
        return view("supplier.index", compact("supplier","barang"));
    }

    public function store()
    {
        try {
            if (Supplier::where("nama_supplier", request()->nama_supplier)->count() > 0) {
                throw new Exception("Nama supplier sudah ada");
            }
            $supplier = new Supplier;
            $supplier->nama_supplier = request()->nama_supplier;
            $supplier->alamat = request()->alamat;
            $supplier->kota = request()->kota;
            $supplier->telepon = request()->telepon;
            $supplier->email = request()->email;
            $supplier->website = request()->website;
            $supplier->save();

            return response()->json([
                "status" => "success",
                "message" => "Berhasil menambahkan supplier"
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
            $supplier = Supplier::find($id);
            if ($supplier == null) {
                throw new Exception("Supplier tidak ditemukan");
            }
            return response()->json([
                "status" => "success",
                "data" => $supplier
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
            $supplier = Supplier::find($id);
            if ($supplier == null) {
                throw new Exception("Supplier tidak ditemukan");
            }
            $supplier->nama_supplier = request()->nama_supplier;
            $supplier->alamat = request()->alamat;
            $supplier->kota = request()->kota;
            $supplier->telepon = request()->telepon;
            $supplier->email = request()->email;
            $supplier->website = request()->website;
            $supplier->save();

            return response()->json([
                "status" => "success",
                "message" => "Berhasil mengubah supplier"
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
            $supplier = Supplier::find($id);
            if ($supplier == null) {
                throw new Exception("Supplier tidak ditemukan");
            }
            if ($supplier->pembelian->count() > 0) {
                throw new Exception("Supplier masih memiliki pembelian");
            }
            $supplier->delete();

            return response()->json([
                "status" => "success",
                "message" => "Berhasil menghapus supplier"
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $supplier = Supplier::find($id);
            if ($supplier == null) {
                throw new Exception("Supplier tidak ditemukan");
            }
            return response()->json([
                "status" => "success",
                "data" => $supplier
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
