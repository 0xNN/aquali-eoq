<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembelian;
use App\Models\PembelianDetail;
use App\Models\Supplier;
use App\Models\Barang;
use DataTables;
use Exception;

class PembelianController extends Controller
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

    public function generate_kode()
    {
        $kode_pembelian = "PB-".floor(microtime(true) * 1000);
        return response()->json([
            'message' => 'success',
            'kode' => $kode_pembelian
        ]);
    }

    public function index()
    {
        if(request()->ajax()){
            $pembelian = Pembelian::all();
            return DataTables::of($pembelian)
            ->addColumn('action', function($pembelian){
                $btn = '<div class="btn-group" role="group">
                <button type="button" class="btn btn-sm btnDetail btn-danger" data-id="'.$pembelian->id.'">Detail</button>
                </div>';
                return $btn;
            })
            ->editColumn('kode_pembelian', function($pembelian){
                return "<a href='javascript:void(0)' data-id='".$pembelian->id."' class='btn btnStatus btn-sm btn-info'>".$pembelian->kode_pembelian."</a>";
            })
            ->editColumn('supplier_id', function($pembelian){
                return $pembelian->supplier->nama_supplier;
            })
            ->editColumn('status_permintaan', function($pembelian){
                if ($pembelian->status_permintaan == 0) {
                    return "Permintaan";
                } else if ($pembelian->status_permintaan == 1) {
                    return "Diterima";
                } else if ($pembelian->status_permintaan == 2) {
                    return "Ditolak";
                }
                return "-";
            })
            ->editColumn('status_pembelian', function($pembelian){
                if ($pembelian->status_pembelian == 0) {
                    return "Belum Diterima";
                } else if ($pembelian->status_pembelian == 1) {
                    return "Diterima";
                }
                return "-";
            })
            ->addIndexColumn()
            ->rawColumns(['action','supplier_id','status_permintaan','status_pembelian','kode_pembelian'])
            ->make(true);
        }
        $pembelian = Pembelian::all();
        $supplier = Supplier::all();
        $barang = Barang::all();
        return view("barang.pembelian.index", compact("pembelian","supplier","barang"));
    }

    public function store()
    {
        try {
            $list_barang = json_decode(request()->list_barang);
            $valid = true;
            collect($list_barang)->each(function($item) use(&$valid) {
                if ($item->jumlah <= 0) {
                    $valid = false;
                }
            });
            if (!$valid) {
                throw new Exception("Jumlah barang tidak boleh 0 dan negatif");
            }
            $pembelian = new Pembelian;
            $pembelian->kode_pembelian = request()->kode_pembelian;
            $pembelian->supplier_id = request()->supplier_id;
            $pembelian->tanggal_permintaan = date("Y-m-d");
            $pembelian->user_id_permintaan = auth()->user()->id;
            $pembelian->save();

            collect($list_barang)->each(function($item) use($pembelian) {
                $barang = Barang::find($item->id);
                $pembelian_detail = new PembelianDetail;
                $pembelian_detail->pembelian_id = $pembelian->id;
                $pembelian_detail->kode_pembelian = $pembelian->kode_pembelian;
                $pembelian_detail->barang_id = $item->id;
                $pembelian_detail->jumlah = $item->jumlah;
                $pembelian_detail->harga_satuan = $barang->harga_beli;
                $pembelian_detail->harga_total = $barang->harga_beli * $item->jumlah;
                $pembelian_detail->save();
            });

            return response()->json([
                "status" => "success",
                "message" => "Berhasil menambahkan pembelian"
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
            $pembelian = Pembelian::find($id);
            if ($pembelian == null) {
                throw new Exception("Pembelian tidak ditemukan");
            }
            if (request()->status_permintaan == "undefined") {
                throw new Exception("Status permintaan tidak boleh kosong");
            }
            $pembelian->status_permintaan = request()->status_permintaan == "terima" ? "1" : "2";
            $pembelian->save();
            return response()->json([
                "status" => "success",
                "message" => "Berhasil mengubah status pembelian"
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
            $pembelian = Pembelian::find($id);
            if ($pembelian == null) {
                throw new Exception("Pembelian tidak ditemukan");
            }
            return response()->json([
                "status" => "success",
                "data" => $pembelian->load(["pembelianDetail" => function($query){
                    $query->with("barang");
                }]),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => $e->getMessage()
            ], 500);
        }
    }

    public function confirm_barang()
    {
        try {
            $pembelian = Pembelian::find(request()->id);
            if ($pembelian == null) {
                throw new Exception("Pembelian tidak ditemukan");
            }
            $pembelian->status_pembelian = 1;
            $pembelian->save();
            return response()->json([
                "status" => "success",
                "message" => "Berhasil mengubah status barang"
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
