<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rule;
use DataTables;
use Exception;

class RuleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if(request()->ajax()){
            $rule = Rule::all();
            return DataTables::of($rule)
            ->addColumn('action', function($rule){
                $btn = '<div class="btn-group" role="group">
                <button type="button" class="btn btn-sm btnEdit btn-secondary" data-id="'.$rule->id.'">Edit</button>
                <button type="button" class="btn btn-sm btnDelete btn-danger" data-id="'.$rule->id.'">Delete</button>
                </div>';
                return $btn;
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
        }
        $rule = Rule::all();
        return view("rule.index", compact("rule"));
    }

    public function store()
    {
        try {
            $rule = new Rule;
            $rule->biaya_pemesanan = request()->biaya_pemesanan;
            $rule->biaya_penyimpanan = request()->biaya_penyimpanan;
            $rule->lead_time = request()->lead_time;
            $rule->save();

            return response()->json([
                "status" => "success",
                "message" => "Berhasil menambahkan rule"
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
            $rule = Rule::find($id);
            return response()->json([
                "status" => "success",
                "data" => $rule
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
            $rule = Rule::find($id);
            $rule->biaya_pemesanan = request()->biaya_pemesanan;
            $rule->biaya_penyimpanan = request()->biaya_penyimpanan;
            $rule->lead_time = request()->lead_time;
            $rule->save();

            return response()->json([
                "status" => "success",
                "message" => "Berhasil mengubah rule"
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
            $rule = Rule::find($id);
            $rule->delete();

            return response()->json([
                "status" => "success",
                "message" => "Berhasil menghapus rule"
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
