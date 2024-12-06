<?php

namespace App\Http\Controllers;

use App\Models\IbuHamilDanBersalin;
use App\Models\Desa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel;
use Maatwebsite\Excel\Facades\Excel as FacadesExcel;
use PhpParser\Node\Stmt\Foreach_;

class ImportController extends Controller
{
    //
public function import(Request $request)
{
    $file = $request->file('excel_file');
    // dd($request->all());

    $data = FacadesExcel::toArray([], $file, null, \Maatwebsite\Excel\Excel::XLSX)[0];

    // Store the data in the session
    Session::put('import_data', $data);
    Session::put('nama_model', $request->data);

    return redirect()->route('import.preview');
}
public function showPreview()
{
    // Retrieve the data from the session
    $data = Session::get('import_data');
    $nama_model = Session::get('nama_model');

    return view('import.preview', compact('data'));
}
public function confirmImport()
{
    // Retrieve the data from the session and store it in the database
    $data = Session::get('import_data');
    $nama_model = Session::get('nama_model');
    foreach ($data as $key => $row) {
        if($key == 0){
            continue;
        } else {
            $desa = Desa::where('nama', $row[1])->first();

            foreach ($row as $key1 => $value) {
                # code...
                if($key1 == 0 || $key1 == 1){
                    continue;
                }
                if($desa){
                    $nama_model_lengkap = "\App\Models\\".$nama_model;
                    $IbuHamil = $nama_model_lengkap::where('desa_id', $desa->id)->first();
                    $IbuHamil->update([
                        $data[0][$key1] => $value,
                        // Add more columns as needed
                    ]);
                }
            }
        }
    }

    // Clear the session data
    Session::forget('import_data');
    Session::forget('nama_model');

    return redirect()->back()->with('success', 'Data imported successfully.');
}

}
