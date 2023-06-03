<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeneratePasswordController extends Controller
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

    public function index($plaintext)
    {
        if (auth()->user()->role != 'admin') {
            return response()->json([
                'message' => 'error',
                'error' => 'Unauthorized'
            ], 401);
        }
        $password = bcrypt($plaintext);
        return response()->json([
            'message' => 'success',
            'password' => $password
        ]);
    }
}
