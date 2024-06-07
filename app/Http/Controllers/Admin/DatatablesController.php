<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DatatablesController extends Controller
{
    public function layanan()
    {
        $query = Layanan::latest();

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('actions', 'backend.admin.layanan.include.actions')
            ->rawColumns(['actions'])
            ->toJson();
    }
}
