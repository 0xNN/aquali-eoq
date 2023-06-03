<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Rule;
use DataTables;
use Exception;

class BarangController extends Controller
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
            $barang = Barang::all();
            return DataTables::of($barang)
            ->addColumn('action', function($barang){
                $btn = '<div class="btn-group" role="group">
                <button type="button" class="btn btn-sm btnEdit btn-secondary" data-id="'.$barang->id.'">Edit</button>
                <button type="button" class="btn btn-sm btnDelete btn-danger" data-id="'.$barang->id.'">Delete</button>
                </div>';
                return $btn;
            })
            ->editColumn('kategori.nama_kategori', function($barang){
                return $barang->kategori->nama_kategori;
            })
            ->editColumn('kode_barang', function($barang){
                return "<a href='javascript:void(0)' data-id='".$barang->id."' class='btn btnDetail btn-sm btn-info'>".$barang->kode_barang."</a>";
            })
            ->editColumn('eoq', function($barang){
                if($barang->kategori->is_eoq == 0) {
                    return '<span class="badge rounded-pill bg-danger">Not EOQ</span>';
                }
                return '<span class="badge rounded-pill bg-success">'.number_format($barang->eoq,0,',','.') .'</span>';
            })
            ->editColumn('eoq_capaian', function($barang){
                if ($barang->kategori->is_eoq == 0) {
                    return '-';
                }
                if ($barang->eoq != 0) {
                    return round($barang->penggunaan_tahun / $barang->eoq, 0, PHP_ROUND_HALF_UP);
                }
                return 0;
            })
            ->editColumn('eoq_sisa', function($barang){
                if ($barang->kategori->is_eoq == 0) {
                    return '-';
                }
                return round($barang->penggunaan_tahun / $barang->eoq, 0, PHP_ROUND_HALF_UP) - $barang->pembelianDetail->count();
            })
            ->addIndexColumn()
            ->rawColumns(['action','kode_barang','eoq','eoq_capaian','eoq_sisa'])
            ->make(true);
        }
        $kategori = Kategori::all();
        $barang = Barang::all();
        $rule = Rule::all();
        return view("barang.index", compact("kategori","barang","rule"));
    }

    public function store()
    {
        try {
            if (Barang::where("kode_barang", request()->kode_barang)->count() > 0) {
                throw new Exception("Kode barang sudah ada");
            }
            $barang = new Barang;
            $barang->kode_barang = request()->kode_barang;
            $barang->nama_barang = request()->nama_barang;
            $barang->kategori_id = request()->kategori_id;
            $barang->rule_id = request()->rule_id;
            $barang->harga_beli = request()->harga_beli;
            $barang->harga_jual = request()->harga_jual;
            $barang->penggunaan_tahun = request()->penggunaan_tahun;
            $barang->stok = request()->stok;
            // $barang->safety_stok = request()->safety_stok;

            // Proses Upload Image
            if(request()->gambar != null){
                $file = request()->file('gambar');
                $fileName = time()."_".$file->getClientOriginalName();
                $file->move(public_path('images/uploads'), $fileName);
                $barang->gambar = $fileName;
            }

            // Proses Keterangan
            if(request()->keterangan != null){
                $barang->keterangan = request()->keterangan;
            }

            $rule = Rule::find(request()->rule_id);
            if ($barang->kategori->is_eoq == 1) {
                // Proses EOQ
                $r_eoq = ( 2 * $barang->penggunaan_tahun * (($rule->biaya_pemesanan/100) * $barang->harga_beli)) / (($rule->biaya_penyimpanan/100) * $barang->harga_beli);
                $barang->eoq = round(sqrt($r_eoq), 0, PHP_ROUND_HALF_UP);
            }

            if ($barang->eoq != 0) {
                $barang->safety_stok = $barang->penggunaan_tahun - $barang->eoq;
                $barang->rop = round(($rule->lead_time * 312) + $barang->safety_stok, 0,PHP_ROUND_HALF_UP);
            }
            $barang->save();

            return response()->json([
                "status" => "success",
                "message" => "Berhasil menambahkan barang"
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
            $barang = Barang::find($id);
            if ($barang == null) {
                throw new Exception("Barang tidak ditemukan");
            }
            return response()->json([
                "status" => "success",
                "data" => $barang,
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
            $barang = Barang::find($id);
            if ($barang == null) {
                throw new Exception("Barang tidak ditemukan");
            }
            $barang->kode_barang = request()->kode_barang;
            $barang->nama_barang = request()->nama_barang;
            $barang->kategori_id = request()->kategori_id;
            $barang->rule_id = request()->rule_id;
            $barang->harga_beli = request()->harga_beli;
            $barang->harga_jual = request()->harga_jual;
            $barang->penggunaan_tahun = request()->penggunaan_tahun;
            $barang->stok = request()->stok;
            $barang->safety_stok = request()->safety_stok;
            if(request()->gambar != null){
                $file = request()->file('gambar');
                $fileName = time()."_".$file->getClientOriginalName();
                $file->move(public_path('images/uploads'), $fileName);
                $barang->gambar = $fileName;
            }
            if(request()->keterangan != null){
                $barang->keterangan = request()->keterangan;
            }
            if ($barang->kategori->is_eoq == 1) {
                // Proses EOQ
                $rule = Rule::find(request()->rule_id);
                $r_eoq = ( 2 * $barang->penggunaan_tahun * (($rule->biaya_pemesanan/100) * $barang->harga_beli)) / (($rule->biaya_penyimpanan/100) * $barang->harga_beli);
                $barang->eoq = round(sqrt($r_eoq), 0, PHP_ROUND_HALF_UP);
            }
            if ($barang->eoq != 0) {
                $barang->safety_stok = $barang->penggunaan_tahun - $barang->eoq;
                $barang->rop = round(($rule->lead_time * 312) + $barang->safety_stok, 0,PHP_ROUND_HALF_UP);
            }
            $barang->save();

            return response()->json([
                "status" => "success",
                "message" => "Berhasil mengubah barang"
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
            $barang = Barang::find($id);
            if ($barang == null) {
                throw new Exception("Barang tidak ditemukan");
            }
            $barang->delete();

            return response()->json([
                "status" => "success",
                "message" => "Berhasil menghapus barang"
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
            $barang = Barang::find($id);
            if ($barang == null) {
                throw new Exception("Barang tidak ditemukan");
            }
            return response()->json([
                "status" => "success",
                "data" => $barang->load("kategori"),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
