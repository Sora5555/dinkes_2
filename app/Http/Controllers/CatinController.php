<?php

namespace App\Http\Controllers;

use App\Exports\CatinExport;
use App\Models\Catin;
use App\Models\Desa;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class CatinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'Catin';
    protected $viewName = 'catin';
    protected $title = 'Layanan Kesehatan Catin';
    public function index(Request $request)
    {
        $unit_kerja = UnitKerja::all();
        $desa = Desa::all();
        foreach ($desa as $key => $value) {
            # code...
            if($value->filterCatin(2024) == null){
                Catin::create([
                    'desa_id' => $value->id,
                ]);
            }
        }
        $data=[
            'route'=>$this->routeName,
            'title'=>$this->title,
            'unit_kerja' =>  $unit_kerja,
            'desa' => Auth::user()->unit_kerja?Auth::user()->unit_kerja->Desa()->get():Desa::all(),
        ];

        return view($this->viewName.'.index')->with($data);
    }
    public function add(Request $request)
    {
        $counter = 0;
    
        $fillable = (new Catin())->getFillable(); // Get only fillable attributes
        $sessionYear = Session::get('year'); // Retrieve the year from the session

    
        foreach (Auth::user()->unit_kerja->Desa()->get() as $desa) {
            if ($desa->filterCatin($sessionYear)) {
                continue;
            } else {
                $data = [];
    
                foreach ($fillable as $field) {
                    // Set desa_id and default values for other fields
                    $data[$field] = $field === 'desa_id' ? $desa->id : 0;
                }
    
                // Create a model instance
                $result = new Catin($data);
    
                // Manually set created_at and updated_at
                $createdAt = Carbon::create($sessionYear, 1, 1);
                 // Default to Jan 1st, 00:00
                $result->created_at = $createdAt;
                $result->updated_at = $createdAt;
    
                // Save the model instance
                $result->save();
    
                $counter++;
            }
        }
    
        return redirect()->route($this->routeName . '.index')->with(['success' => 'Berhasil!']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $catin = Catin::where('id', $request->id)->first();
        $catin->update([
            $request->name => $request->value,
        ]);
        $kua = $catin->kua_L + $catin->kua_P;
        $layanan_LP = $catin->layanan_L + $catin->layanan_P;
        $layanan_L = $catin->kua_L > 0?number_format($catin->layanan_L/$catin->kua_L * 100, 2):0;
        $layanan_P = $catin->kua_P > 0?number_format($catin->layanan_P/$catin->kua_P * 100, 2):0;
        $anemia = $catin->layanan_P > 0?number_format($catin->anemia/$catin->layanan_P * 100, 2):0;
        $gizi = $catin->layanan_P > 0?number_format($catin->gizi/$catin->layanan_P * 100, 2):0;
        $persen_layanan_LP = $catin->kua_P + $catin->kua_L > 0?number_format(($catin->layanan_L + $catin->layanan_P)/($catin->kua_L + $catin->kua_P) * 100, 2):0;
        
        return response()->json([
            'message' => 'success',
            'kua' => $kua,
            'layanan_L' => $layanan_L,
            'layanan_P' => $layanan_P,
            'layanan_LP' => $layanan_LP,
            'persen_layanan_LP' => $persen_layanan_LP,
            'gizi' => $gizi,
            'anemia' => $anemia,

        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function exportExcel()
    {
        try {
            return Excel::download(new CatinExport, 'Pelayanan Kesehatan Calon Pengantin_report.xlsx');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
