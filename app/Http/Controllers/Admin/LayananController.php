<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLayananRequest;
use App\Http\Requests\UpdateLayananRequest;
use App\Models\Layanan;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Yajra\DataTables\Facades\DataTables;


class LayananController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {

        if (request()->ajax()) {
            $layanans = Layanan::latest();

            return DataTables::of($layanans)
                ->addIndexColumn()
                ->addColumn('action', 'backend.admin.layanan.elemen.action')
                ->toJson();
        }

        return view('backend.admin.layanan.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.admin.layanan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLayananRequest $request)
    {
        $aku = $request->validated();

        if ($request->hasFile('thumbnail') && $request->file('thumbnail')->isValid()) {
            $path = public_path('storage/linkingpart/');
            $namafile = $request->file('thumbnail')->hashName();

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            Image::make($request->file('thumbnail')->getRealPath())->resize(300, 300, function ($constraint) {
                $constraint->upsize();
                $constraint->aspectRatio();
            })->save($path . '/' . $namafile); // Menggabungkan path dan nama file dengan benar

            $aku['thumbnail'] = 'storage/linkingpart/' . $namafile; // Simpan path relatif dalam database
        }

        Layanan::create($aku);

        Flash::success('alamat berhasil di tambah');
        return redirect()->route('backend.admin.layanan.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Layanan $layanan)
    {
        return view('layanan.show', compact('layanan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Layanan $layanan)
    {
        return view('layanan.edit', compact('layanan'));
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

            if ($layanan->thumbnail != null && file_exists($path . $layanan->thumbnail)) {
                unlink($path . $layanan->thumbnail);
            }

            $aku['thumbnail'] = $namafile;
        }
        $layanan->update($aku);
        return redirect()->route('layanan.index')->with('success', 'yess, alamat bisa di ubah');
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
            return redirect()->route('backend.admin.layanan.index')->with('success', 'Yah, Kehapus deh');
        } catch (\Throwable $bg) {
            return redirect()
                ->route('backend.admin.layanan.index')
                ->with('error', __($bg->getMessage()));
        }
    }
}