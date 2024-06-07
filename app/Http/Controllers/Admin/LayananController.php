<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLayananRequest;
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
                ->addColumn('action', 'backend.layanan.index')
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
        return redirect()->route('layanan.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
