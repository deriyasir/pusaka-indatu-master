<?php

namespace App\Http\Controllers;

use App\Models\UserAddress;
use Illuminate\Http\Request;

class AlamatController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('alamat.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'alamat' => 'required',
            'kota' => 'required',
            'provinsi' => 'required',
            'kode_pos' => 'required',
        ]);

        auth()->user()->alamat()->create($request->except('_token'));

        return redirect()->route('profil')->with('success', 'Alamat berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  UserAddress $alamat
     * @return \Illuminate\Http\Response
     */
    public function edit(UserAddress $alamat)
    {
        return view('alamat.edit', compact('alamat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  UserAddress $alamat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserAddress $alamat)
    {
        $request->validate([
            'alamat' => 'required',
            'kota' => 'required',
            'provinsi' => 'required',
            'kode_pos' => 'required',
        ]);

        $alamat->update($request->except('_token'));

        return redirect()->route('profil')->with('success', 'Alamat berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  UserAddress $alamat
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserAddress $alamat)
    {
        $alamat->delete();
        return redirect()->route('profil')->with('success', 'Alamat berhasil dihapus');
    }
}
