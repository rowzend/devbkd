<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Intervention\Image\Facades\Image;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StoreLayananRequest;
use App\Http\Requests\UpdateLayananRequest;

class LayananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $layanans = Layanan::latest();

            return DataTables::of($layanans)
                ->addIndexColumn()
                ->addColumn('action', 'backend.layanan.index')
                ->toJson();
        }
        return view('backend.layanan.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.layanan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLayananRequest $request)
    {
        $aku = $request->validated();
        if ($request->hasFile('thumbnail') && $request->file('thumbnail')->isValid()) {
            $path = storage_path('app/public/linkingpart/');
            $namafile = $request->file('thumbnail')->hashName();

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            Image::make($request->file('thumbnail')->getRealPath())->resize(300, 300, function ($constraint) {
                $constraint->upsize();
                $constraint->aspectRatio();
            })->save($path, $namafile);

            $aku['thumbnail'] = $namafile;
        }
        Layanan::create($aku);
        return redirect()->route('backend.layanan.index')->with('success', 'alamat berhasil di tambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(Layanan $layanan)
    {
        return view('backend.layanan.show', compact('layanan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Layanan $layanan)
    {
        return view('backend.layanan.edit', compact('layanan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLayananRequest $request, Layanan $layanan)
    {
        $aku = $request->validated();
        if ($request->hasFile('thumbnail') && $request->file('thumbnail')->isValid()) {
            $path = storage_path('app/public/linkingpart/');
            $namafile = $request->file('thumbnail')->hashName();

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            Image::make($request->file('thumbnail')->getRealPath())->resize(300, 300, function ($constraint) {
                $constraint->upsize();
                $constraint->aspectRatio();
            })->save($path, $namafile);

            if ($layanan->thumbnail != null && file_exists($path, $layanan->thumbnail)) {
                unlink($path . $layanan->thumbnail);
            }

            $aku['thumbnail'] = $namafile;
        }
        $layanan->update($aku);
        return redirect()->route('backend.layanan.index')->with('success', 'yess, alamat bisa di ubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Layanan $layanan)
    {
        try {
            $path = storage_path('app/public/linkingpart/');
            if ($layanan->thumbnail != null && file_exists($path . $layanan->thumbnail)) {
                unlink($path . $layanan->thumbnail);
            }
            $layanan->delete();
            return redirect()->route('backend.layanan.index')->with('success', 'Yah, Kehapus deh');
        } catch (\Throwable $bg) {
            return redirect()
                ->route('backend.layanan.index')
                ->with('error', __($bg->getMessage()));
        }
    }
}
