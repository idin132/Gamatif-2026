<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DataMahasiswaImport;

class ImportController extends Controller
{
    public function import(Request $request)
    {
        $file = $request->file('file');

        // langsung pakai path upload sementara
        Excel::import(new DataMahasiswaImport, $file);

        return redirect()->back()->with('success', 'Data berhasil diimport!');
    }
}
