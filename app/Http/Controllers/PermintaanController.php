<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permintaan;
use App\Models\PermintaanDetail;
use App\Models\Barang;
use DataTables;
use Exception;

class PermintaanController extends Controller
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
        $kode_permintaan = "PM-".floor(microtime(true) * 1000);
        return response()->json([
            'message' => 'success',
            'kode' => $kode_permintaan
        ]);
    }

    public function index()
    {
        if(request()->ajax()){
            $permintaan = Permintaan::all();
            return DataTables::of($permintaan)
            // ->addColumn('action', function($permintaan){
            //     $btn = '<div class="btn-group" role="group">
            //     <button type="button" class="btn btn-sm btnDetail btn-danger" data-id="'.$permintaan->id.'">Detail</button>
            //     </div>';
            //     return $btn;
            // })
            ->editColumn('kode_permintaan', function($permintaan){
                return "<a href='javascript:void(0)' data-id='".$permintaan->id."' class='btn btnStatus btn-sm btn-info'>".$permintaan->kode_permintaan."</a>";
            })
            ->editColumn('status', function($permintaan){
                if ($permintaan->status == 0) {
                    return "Proses";
                } else if ($permintaan->status == 1) {
                    return "Disetujui";
                } else if ($permintaan->status == 2) {
                    return "Ditolak";
                }
                return "-";
            })
            ->editColumn('user_id', function($permintaan){
                return $permintaan->user->name;
            })
            ->addIndexColumn()
            ->rawColumns(['kode_permintaan'])
            ->make(true);
        }
        $permintaan = Permintaan::all();
        $barang = Barang::all();
        return view("barang.permintaan.index", compact("permintaan","barang"));
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
            $permintaan = new Permintaan;
            $permintaan->kode_permintaan = request()->kode_permintaan;
            $permintaan->status = 0;
            $permintaan->keterangan = request()->keterangan;
            $permintaan->user_id = auth()->user()->id;
            $permintaan->save();

            collect($list_barang)->each(function($item) use($permintaan) {
                $barang = Barang::find($item->id);
                $permintaan_detail = new PermintaanDetail;
                $permintaan_detail->kode_permintaan = $permintaan->kode_permintaan;
                $permintaan_detail->permintaan_id = $permintaan->id;
                $permintaan_detail->barang_id = $item->id;
                $permintaan_detail->jumlah = $item->jumlah;
                $permintaan_detail->save();
            });

            return response()->json([
                "status" => "success",
                "message" => "Berhasil menambahkan permintaan"
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
            $permintaan = Permintaan::find($id);
            if ($permintaan == null) {
                throw new Exception("Permintaan tidak ditemukan");
            }
            return response()->json([
                "status" => "success",
                "data" => $permintaan->load(["permintaanDetail" => function($query){
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

    public function update($id)
    {
        try {
            $permintaan = Permintaan::find($id);
            if ($permintaan == null) {
                throw new Exception("Permintaan tidak ditemukan");
            }
            if (request()->status_permintaan == "undefined") {
                throw new Exception("Status permintaan tidak boleh kosong");
            }
            $permintaan->status = request()->status_permintaan == "terima" ? "1" : "2";
            $permintaan->save();
            return response()->json([
                "status" => "success",
                "message" => "Berhasil mengubah status permintaan"
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
