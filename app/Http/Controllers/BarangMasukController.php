<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\Pembelian;
use App\Models\Kategori;
use App\Models\Rule;
use DataTables;
use Exception;

class BarangMasukController extends Controller
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
            $barang = BarangMasuk::all();
            return DataTables::of($barang)
            ->editColumn('pembelian_id', function($row) {
                return $row->pembelian->kode_pembelian;
            })
            ->editColumn('barang_id', function($row) {
                return $row->barang->nama_barang;
            })
            ->editColumn('user_id', function($row) {
                return $row->user->name;
            })
            ->addIndexColumn()
            ->rawColumns([])
            ->make(true);
        }
        $kategori = Kategori::all();
        $barang = Barang::all();
        $rule = Rule::all();
        $pembelian = Pembelian::all();
        return view("barang.barang-masuk.index", compact("kategori","barang","rule","pembelian"));
    }

    public function store()
    {
        try {
            if (request()->pembelian_id == null) {
                throw new Exception("Pembelian tidak boleh kosong");
            }
            if (request()->barang_id == null) {
                throw new Exception("Barang tidak boleh kosong");
            }
            if (request()->jumlah == null) {
                throw new Exception("Jumlah tidak boleh kosong");
            }
            $pembelian = Pembelian::find(request()->pembelian_id);
            $jumlah_barang = BarangMasuk::where('pembelian_id', request()->pembelian_id)->where('barang_id', request()->barang_id)->sum('jumlah');
            $batasan_jumlah = $pembelian->pembelianDetail->where('barang_id', request()->barang_id)->first();
            if($batasan_jumlah != null) {
                if($jumlah_barang + request()->jumlah > $batasan_jumlah->jumlah){
                    throw new Exception("Jumlah barang melebihi jumlah pembelian");
                }
                $find = BarangMasuk::where('pembelian_id', request()->pembelian_id)->where('barang_id', request()->barang_id)->first();
                if($find != null){
                    if($find->jumlah + request()->jumlah > $batasan_jumlah->jumlah){
                        throw new Exception("Jumlah barang melebihi jumlah pembelian");
                    } else {
                        $barang_masuk = BarangMasuk::create([
                            'pembelian_id' => request()->pembelian_id,
                            'barang_id' => request()->barang_id,
                            'jumlah' => request()->jumlah,
                            'user_id' => auth()->user()->id,
                        ]);
                        $barang = Barang::find(request()->barang_id);
                        $barang->stok = $barang->stok + request()->jumlah;
                        $barang->save();
                        return response()->json([
                            'status' => 'success',
                            'data' => $barang_masuk
                        ],200);
                    }
                }
                $barang_masuk = BarangMasuk::create([
                    'pembelian_id' => request()->pembelian_id,
                    'barang_id' => request()->barang_id,
                    'jumlah' => request()->jumlah,
                    'user_id' => auth()->user()->id,
                ]);
                $barang = Barang::find(request()->barang_id);
                $barang->stok = $barang->stok + request()->jumlah;
                $barang->save();
                return response()->json([
                    'status' => 'success',
                    'data' => $barang_masuk
                ],200);
            }
            throw new Exception("Terjadi kesalahan sistem!");
        } catch (Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => $e->getMessage()
            ],500);
        }
    }
}
