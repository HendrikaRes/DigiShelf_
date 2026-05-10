<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;

class BukuUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $buku = Buku::all();
        return view('user.buku', compact('buku'));
    }


    public function show($id)
{
    $buku = Buku::findOrFail($id);
    return view('user.buku.show', compact('buku'));
}
}
