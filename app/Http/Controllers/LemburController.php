<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lembur;

class LemburController extends Controller
{
    public function index()
    {
        $lembur = Lembur::all();
        return view('lembur.index', compact('lembur'));
    }
}
