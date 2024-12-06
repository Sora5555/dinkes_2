<?php

namespace App\Http\Controllers;

use App\Exports\KomplikasiBidanExport;
use App\Models\Desa;
use App\Models\IbuHamilDanBersalin;
use App\Models\KomplikasiBidan;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class KomplikasiBidanController extends Controller
{
    protected $routeName = 'KomplikasiBidan';
    protected $viewName = 'komplikasi_bidan';
    protected $title = 'Komplikasi Bidan';
    public function index(Request $request)
    {
        $unit_kerja = UnitKerja::all();
        // $desa = Desa::all();
        // foreach ($desa as $key => $value) {
        //     # code...
        //     KomplikasiBidan::create([
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
    
        $fillable = (new KomplikasiBidan())->getFillable(); // Get only fillable attributes
        $sessionYear = Session::get('year'); // Retrieve the year from the session

    
        foreach (Auth::user()->unit_kerja->Desa()->get() as $desa) {
            if ($desa->filterKomplikasiBidan($sessionYear)) {
                continue;
            } else {
                $data = [];
    
                foreach ($fillable as $field) {
                    // Set desa_id and default values for other fields
                    $data[$field] = $field === 'desa_id' ? $desa->id : 0;
                }
    
                // Create a model instance
                $result = new KomplikasiBidan($data);
    
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
        $komplikasiBidan = KomplikasiBidan::where('id', $request->id)->first();
        $komplikasiBidan->update([
            $request->name => $request->value,
        ]);
        $ibuHamil = IbuHamilDanBersalin::where('desa_id', $komplikasiBidan->desa_id)->whereYear('created_at', 2024)->first();
        $jumlah_persen = (20/100) * $ibuHamil->jumlah_ibu_hamil>0 ? number_format($komplikasiBidan->jumlah/((20/100) * $ibuHamil->jumlah_ibu_hamil) * 100, 2):0;
        return response()->json([
            'status' => 'success',
            'persen_jumlah' => $jumlah_persen,
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
            return Excel::download(new KomplikasiBidanExport, 'Komplikasi Bidan_report.xlsx');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
