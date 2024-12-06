<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\fileUpload;
use App\Models\UnitKerja;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Session;

class FileController extends Controller
{
    //
    public function detail_desa(Request $request, $id, $secondaryFilter = null)
{
    $unitKerja = UnitKerja::find($id); // Retrieve the unit kerja
    $desas = Desa::where('unit_kerja_id', $id)->get();

    $year = Session::get('year');
    $mainFilter = $request->input('mainFilter');
    $secondaryFilter = $request->input('secondaryFilter');
    // dd($request->input('secondaryFilter'));
    // Dynamically apply the filters based on the provided filter names
    $desas->map(function ($desa) use ($mainFilter, $secondaryFilter, $year) {
        // Apply the main filter
        if (method_exists($desa, $mainFilter)) {
            $mainFilteredData = $desa->{$mainFilter}($year);

            if ($mainFilteredData) {
                // Automatically assign all attributes returned by the main filter
                foreach ($mainFilteredData->toArray() as $key => $value) {
                    if($key == "id"){
                        continue;
                    }
                    $desa->{$key} = $value;
                }
            }
        }

        // Apply the optional secondary filter
        if ($secondaryFilter && method_exists($desa, $secondaryFilter)) {
            // dd($desa->filterKelahiran(2023), $desa);
            $secondaryFilteredData = $desa->{$secondaryFilter}($year);
            if ($secondaryFilteredData) {
                // Automatically assign all attributes returned by the secondary filter
                foreach ($secondaryFilteredData->toArray() as $key => $value) {
                    if($key == "id"){
                        continue;
                    }
                    $desa->{$key} = $value;
                }
            }
        }
        // dd($desa);
        return $desa;
    });

    return response()->json([
        'status' => 'success',
        'data' => $unitKerja,
        'desa' => $desas,
    ]);
}
    public function detail_desa2(Request $request, $id, $secondaryFilter = null, $thirdFilter = null)
{
    $unitKerja = UnitKerja::find($id); // Retrieve the unit kerja
    $desas = Desa::where('unit_kerja_id', $id)->get();

    $year = Session::get('year');
    $mainFilter = $request->input('mainFilter');
    $secondaryFilter = $request->input('secondaryFilter');
    $thirdFilter = $request->input('thirdFilter');
    // dd($request->input('secondaryFilter'));
    // Dynamically apply the filters based on the provided filter names
    $desas->map(function ($desa) use ($mainFilter, $secondaryFilter, $thirdFilter, $year) {
        // Apply the main filter
        if (method_exists($desa, $mainFilter)) {
            $mainFilteredData = $desa->{$mainFilter}($year, $desa->id);
            // dd($mainFilteredData);

            if ($mainFilteredData) {
                // Automatically assign all attributes returned by the main filter
                foreach ($mainFilteredData->toArray() as $key => $value) {
                    if($key == "id"){
                        continue;
                    }
                    $desa->{$key} = $value;
                }
            }
        }
        if (method_exists($desa, $thirdFilter)) {
            $thirdFilteredData = $desa->{$thirdFilter}($year, $desa->id);
            // dd($mainFilteredData);

            if ($thirdFilteredData) {
                // Automatically assign all attributes returned by the main filter
                foreach ($thirdFilteredData->toArray() as $key => $value) {
                    if($key == "id"){
                        continue;
                    }
                    $desa->{$key} = $value;
                }
            }
        }

        // Apply the optional secondary filter
        if ($secondaryFilter && method_exists($desa, $secondaryFilter)) {
            // dd($desa->filterKelahiran(2023), $desa);
            $secondaryFilteredData = $desa->{$secondaryFilter}($year);
            // dd($secondaryFilteredData);
            if ($secondaryFilteredData) {
                // Automatically assign all attributes returned by the secondary filter
                foreach ($secondaryFilteredData->toArray() as $key => $value) {
                    if($key == "id"){
                        continue;
                    }
                    $desa->{$key} = $value;
                }
            }
        }
        // dd($desa);
        return $desa;
    });

    return response()->json([
        'status' => 'success',
        'data' => $unitKerja,
        'desa' => $desas,
    ]);
}
public function upload(Request $request){
    $user = Auth::user();
    if(!$user->hasFile($request->name, Session::get('year'))){
        $file=$request->file('file_upload');
        $direktori=public_path().'/storage/image/';          
        $nama_file=str_replace(' ','-',$request->file_upload->getClientOriginalName());
        $file_format= $request->file_upload->getClientOriginalExtension();
        $uploadSuccess = $request->file_upload->move($direktori,$nama_file);

        fileUpload::create([
            'user_id' => $user->id,
            'menu' => $request->name,
            'year' => Session::get('year'),
            'file_name' => $nama_file,
            'file_path' => '/storage/image/',
            'status' => 0,
        ]);
    } else {
        $old_file = $user->downloadFile($request->name, Session::get('year'));
        $file=$request->file('file_upload');
        $direktori=public_path().'/storage/image/';
        File::delete($direktori.$old_file->file_name);          
        $nama_file=str_replace(' ','-',$request->file_upload->getClientOriginalName());
        $file_format= $request->file_upload->getClientOriginalExtension();
        $uploadSuccess = $request->file_upload->move($direktori,$nama_file);
        $old_file->update([
            'file_name' => $nama_file,
            'file_path' => '/storage/image/',
        ]);
    }

    return redirect()->back()->with(['success'=>'Berhasil!']);

}
public function apiLockUpload(Request $request){

    $user = User::where('id', $request->id)->first();
    $name = $request->input('name');
    $fileUpload = $user->downloadFile($name, Session::get('year'));    
    if(isset($fileUpload)){
        $fileUpload->update([
            'status' => $request->status,
        ]);
    } else {
        fileUpload::create([
            'user_id' => $user->id,
            'menu' => $name,
            'year' => Session::get('year'),
            'file_name' => '-',
            'file_path' => '-',
            'status' => $request->status,
        ]);
    }

    return response()->json([
        'status' => 'success',
        'data' => $user,
    ]);
}
public function lock(Request $request){

    $unitKerja = UnitKerja::where('id', $request->id)->first();    
    $unitKerja->GeneralLock(Session::get('year'), $request->status, $request->input('name'));   

    return response()->json([
        'status' => 'success',
        'data' => $unitKerja,
    ]);
}
public function lock2(Request $request){

    $unitKerja = UnitKerja::where('id', $request->id)->first();    
    $unitKerja->GeneralLock2(Session::get('year'), $request->status, $request->input('name'));   

    return response()->json([
        'status' => 'success',
        'data' => $unitKerja,
    ]);
}
}
