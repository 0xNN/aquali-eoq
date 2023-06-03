<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permintaan;
use App\Models\PermintaanDetail;
use App\Models\Distribusi;
use App\Models\Barang;
use DataTables;
use Exception;

class DistribusiController extends Controller
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
            $distribusi = Distribusi::all();
            return DataTables::of($distribusi)
            // ->addColumn('action', function($distribusi){
            //     $btn = '<div class="btn-group" role="group">
            //     <button type="button" class="btn btn-sm btnDetail btn-danger" data-id="'.$distribusi->id.'">Detail</button>
            //     </div>';
            //     return $btn;
            // })
            ->editColumn('user_id', function($distribusi){
                return $distribusi->user->name;
            })
            ->editColumn('barang_id', function($distribusi){
                return $distribusi->barang->nama_barang;
            })
            ->editColumn('permintaan_id', function($distribusi){
                return $distribusi->permintaan->kode_permintaan;
            })
            ->addIndexColumn()
            ->rawColumns(['kode_distribusi'])
            ->make(true);
        }
        $permintaan = Permintaan::where('status', 1)->get();
        $barang = Barang::all();
        return view("barang.distribusi.index", compact("permintaan","barang"));
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

            collect($list_barang)->each(function($item) {
                $permintaan = PermintaanDetail::where('permintaan_id', request()->permintaan_id)
                ->where('barang_id', $item->id)
                ->first();
                $distribusi_jumlah = Distribusi::where('permintaan_id', request()->permintaan_id)
                ->where('barang_id', $item->id)
                ->sum('jumlah');
                if ($permintaan->jumlah < $distribusi_jumlah + $item->jumlah) {
                    throw new Exception("Jumlah distribusi melebihi jumlah permintaan");
                }
                $distribusi = new Distribusi;
                $distribusi->permintaan_id = request()->permintaan_id;
                $distribusi->barang_id = $item->id;
                $distribusi->jumlah = $item->jumlah;
                $distribusi->keterangan = request()->keterangan;
                $distribusi->user_id = auth()->user()->id;
                $distribusi->save();

                $distribusi_total_jumlah = Distribusi::where('barang_id', $item->id)
                ->sum('jumlah');
                $barang = Barang::find($item->id);
                $barang->stok = $barang->stok - $distribusi_total_jumlah;
                $barang->save();
            });

            return response()->json([
                "status" => "success",
                "message" => "Berhasil menambahkan distribusi"
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
