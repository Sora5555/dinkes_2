<?php

namespace App\Http\Controllers;

use App\Exports\PenyebabKematianIbuExport;
use App\Models\Desa;
use App\Models\PenyebabKematianIbu;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class PenyebabKematianIbuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'PenyebabKematianIbu';
    protected $viewName = 'penyebab_kematian_ibu';
    protected $title = 'Penyebab Kematian Ibu';
    public function index(Request $request)
    {
        $unit_kerja = UnitKerja::all();
        // $desa = Desa::all();
        // foreach ($desa as $key => $value) {
        //     # code...
        //     PenyebabKematianIbu::create([
        //         'desa_id' => $value->id,
        //     ]);
        // }
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
    
        $fillable = (new PenyebabKematianIbu())->getFillable(); // Get only fillable attributes
        $sessionYear = Session::get('year'); // Retrieve the year from the session
    
        foreach (Auth::user()->unit_kerja->Desa()->get() as $desa) {
            if ($desa->filterPenyebabKematianIbu($sessionYear)) {
                continue;
            } else {
                $data = [];
    
                foreach ($fillable as $field) {
                    // Set desa_id and default values for other fields
                    $data[$field] = $field === 'desa_id' ? $desa->id : 0;
                }
    
                // Create a model instance
                $result = new PenyebabKematianIbu($data);
    
                // Manually set created_at and updated_at
                $createdAt = Carbon::create($sessionYear, 1, 1); // Default to Jan 1st, 00:00
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
        $penyebabKematianIbu = PenyebabKematianIbu::where('id', $request->id)->first();
        $penyebabKematianIbu->update([
            $request->name => $request->value,
        ]);
        $total = $penyebabKematianIbu->perdarahan + $penyebabKematianIbu->gangguan_hipertensi + $penyebabKematianIbu->infeksi + $penyebabKematianIbu->kelainan_jantung + $penyebabKematianIbu->gangguan_autoimun + $penyebabKematianIbu->gangguan_cerebro + $penyebabKematianIbu->covid_19 + $penyebabKematianIbu->abortus + $penyebabKematianIbu->lain_lain;
        return response()->json([
            'status' => 'success',
            'total' => $total,
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
            return Excel::download(new PenyebabKematianIbuExport, 'Penyebab kematian ibu_report.xlsx');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
