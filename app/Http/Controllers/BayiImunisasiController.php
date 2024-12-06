<?php

namespace App\Http\Controllers;

use App\Exports\BayiImunisasiExport;
use App\Models\BayiImunisasi;
use App\Models\Desa;
use App\Models\Kelahiran;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class BayiImunisasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'BayiImunisasi';
    protected $viewName = 'bayi_imunisasi';
    protected $title = 'Bayi Imunisasi Campak Rubella Polio';
    public function index(Request $request)
    {
        $unit_kerja = UnitKerja::all();
        // $desa = Desa::all();
        // foreach ($desa as $key => $value) {
        //     # code...
        //     BayiImunisasi::create([
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
    
        $fillable = (new BayiImunisasi())->getFillable(); // Get only fillable attributes
        $sessionYear = Session::get('year'); // Retrieve the year from the session

    
        foreach (Auth::user()->unit_kerja->Desa()->get() as $desa) {
            if ($desa->filterBayiImunisasi($sessionYear)) {
                continue;
            } else {
                $data = [];
    
                foreach ($fillable as $field) {
                    // Set desa_id and default values for other fields
                    $data[$field] = $field === 'desa_id' ? $desa->id : 0;
                }
    
                // Create a model instance
                $result = new BayiImunisasi($data);
    
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
        $bayi = BayiImunisasi::where('id', $request->id)->first();
        $bayi->update([
            $request->name => $request->value,
        ]);
        $kelahiran = Kelahiran::where('desa_id', $bayi->desa_id)->first();
        $dpt_L = $kelahiran->lahir_hidup_L>0?number_format($bayi->dpt_L/$kelahiran->lahir_hidup_L * 100, 2):0;
        $dpt_P = $kelahiran->lahir_hidup_P>0?number_format($bayi->dpt_P/$kelahiran->lahir_hidup_P * 100, 2):0;
        $total_dpt = $bayi->dpt_P + $bayi->dpt_L;
        $persen_dpt = $kelahiran->lahir_hidup_P + $kelahiran->lahir_hidup_L>0?number_format(($bayi->dpt_P + $bayi->dpt_L)/($kelahiran->lahir_hidup_P + $kelahiran->lahir_hidup_L) * 100, 2):0;
        
        $polio_L = $kelahiran->lahir_hidup_L>0?number_format($bayi->polio_L/$kelahiran->lahir_hidup_L * 100, 2):0;
        $polio_P = $kelahiran->lahir_hidup_P>0?number_format($bayi->polio_P/$kelahiran->lahir_hidup_P * 100, 2):0;
        $total_polio = $bayi->polio_P + $bayi->polio_L;
        $persen_polio = $kelahiran->lahir_hidup_P + $kelahiran->lahir_hidup_L>0?number_format(($bayi->polio_P + $bayi->polio_L)/($kelahiran->lahir_hidup_P + $kelahiran->lahir_hidup_L) * 100, 2):0;
        
        $rubela_L = $kelahiran->lahir_hidup_L>0?number_format($bayi->rubela_L/$kelahiran->lahir_hidup_L * 100, 2):0;
        $rubela_P = $kelahiran->lahir_hidup_P>0?number_format($bayi->rubela_P/$kelahiran->lahir_hidup_P * 100, 2):0;
        $total_rubela = $bayi->rubela_P + $bayi->rubela_L;
        $persen_rubela = $kelahiran->lahir_hidup_P + $kelahiran->lahir_hidup_L>0?number_format(($bayi->rubela_P + $bayi->rubela_L)/($kelahiran->lahir_hidup_P + $kelahiran->lahir_hidup_L) * 100, 2):0;
        
        $lengkap_L = $kelahiran->lahir_hidup_L>0?number_format($bayi->lengkap_L/$kelahiran->lahir_hidup_L * 100, 2):0;
        $lengkap_P = $kelahiran->lahir_hidup_P>0?number_format($bayi->lengkap_P/$kelahiran->lahir_hidup_P * 100, 2):0;
        $total_lengkap = $bayi->lengkap_P + $bayi->lengkap_L;
        $persen_lengkap = $kelahiran->lahir_hidup_P + $kelahiran->lahir_hidup_L>0?number_format(($bayi->lengkap_P + $bayi->lengkap_L)/($kelahiran->lahir_hidup_P + $kelahiran->lahir_hidup_L) * 100, 2):0;
 
        return response()->json([
            'message' => 'success',
            'dpt_L' => $dpt_L,
            'dpt_P' => $dpt_P,
            'total_dpt' => $total_dpt,
            'persen_dpt' => $persen_dpt,
            'polio_L' => $polio_L,
            'polio_P' => $polio_P,
            'total_polio' => $total_polio,
            'persen_polio' => $persen_polio,
            'rubela_L' => $rubela_L,
            'rubela_P' => $rubela_P,
            'total_rubela' => $total_rubela,
            'persen_rubela' => $persen_rubela,
            'lengkap_L' => $lengkap_L,
            'lengkap_P' => $lengkap_P,
            'total_lengkap' => $total_lengkap,
            'persen_lengkap' => $persen_lengkap,
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
            return Excel::download(new BayiImunisasiExport, 'Bayi Imunisasi Campak Rubella Polio_report.xlsx');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
