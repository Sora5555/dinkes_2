<?php

namespace App\Http\Controllers;

use App\Exports\BalitaBcgExport;
use App\Models\BalitaBcg;
use App\Models\Desa;
use App\Models\Kelahiran;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class BalitaBcgController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'BalitaBcg';
    protected $viewName = 'balita_bcg';
    protected $title = 'Imunisasi Hepatitis B0 (0-7) Hari dan BCG';
    public function index(Request $request)
    {
        $unit_kerja = UnitKerja::all();
        // $desa = Desa::all();
        // foreach ($desa as $key => $value) {
        //     # code...
        //     BalitaBcg::create([
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
    
        $fillable = (new BalitaBcg())->getFillable(); // Get only fillable attributes
        $sessionYear = Session::get('year'); // Retrieve the year from the session

    
        foreach (Auth::user()->unit_kerja->Desa()->get() as $desa) {
            if ($desa->filterBalitaBcg($sessionYear)) {
                continue;
            } else {
                $data = [];
    
                foreach ($fillable as $field) {
                    // Set desa_id and default values for other fields
                    $data[$field] = $field === 'desa_id' ? $desa->id : 0;
                }
    
                // Create a model instance
                $result = new BalitaBcg($data);
    
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
        $bcg = BalitaBcg::where('id', $request->id)->first();
        $bcg->update([
            $request->name => $request->value,
        ]);
        $kelahiran = Kelahiran::where('desa_id', $bcg->desa_id)->first();
        $duaempat_jam_L = $kelahiran->lahir_hidup_L>0?number_format($bcg->duaempat_jam_L/$kelahiran->lahir_hidup_L * 100, 2):0;
        $duaempat_jam_P = $kelahiran->lahir_hidup_P>0?number_format($bcg->duaempat_jam_P/$kelahiran->lahir_hidup_P * 100, 2):0;
        $total_duaempat_jam = $bcg->duaempat_jam_P + $bcg->duaempat_jam_L;
        $persen_duaempat_jam = $kelahiran->lahir_hidup_L + $kelahiran->lahir_hidup_P > 0?number_format(($bcg->duaempat_jam_L + $bcg->duaempat_jam_P)/($kelahiran->lahir_hidup_L + $kelahiran->lahir_hidup_P) * 100, 2):0;
        
        $satu_minggu_L = $kelahiran->lahir_hidup_L>0?number_format($bcg->satu_minggu_L/$kelahiran->lahir_hidup_L * 100, 2):0;
        $satu_minggu_P = $kelahiran->lahir_hidup_P>0?number_format($bcg->satu_minggu_P/$kelahiran->lahir_hidup_P * 100, 2):0;
        $total_satu_minggu = $bcg->satu_minggu_P + $bcg->satu_minggu_L;
        $persen_satu_minggu = $kelahiran->lahir_hidup_L + $kelahiran->lahir_hidup_P > 0?number_format(($bcg->satu_minggu_L + $bcg->satu_minggu_P)/($kelahiran->lahir_hidup_L + $kelahiran->lahir_hidup_P) * 100, 2):0;
    
        $total_L = $bcg->duaempat_jam_L + $bcg->satu_minggu_L;
        $persen_L = $kelahiran->lahir_hidup_L>0?number_format(($bcg->duaempat_jam_L + $bcg->satu_minggu_L)/$kelahiran->lahir_hidup_L * 100, 2):0;
        $total_P = $bcg->duaempat_jam_P + $bcg->satu_minggu_P;
        $persen_P = $kelahiran->lahir_hidup_P>0?number_format(($bcg->duaempat_jam_P + $bcg->satu_minggu_P)/$kelahiran->lahir_hidup_P * 100, 2):0;
        $total_LP = $bcg->duaempat_jam_P + $bcg->satu_minggu_P + $bcg->duaempat_jam_L + $bcg->satu_minggu_L;
        $persen_LP = $kelahiran->lahir_hidup_L>0?number_format(($bcg->duaempat_jam_L + $bcg->satu_minggu_L + $bcg->duaempat_jam_P + $bcg->satu_minggu_P)/($kelahiran->lahir_hidup_L +  $kelahiran->lahir_hidup_P)* 100, 2):0;
        
        $bcg_L = $kelahiran->lahir_hidup_L>0?number_format($bcg->bcg_L/$kelahiran->lahir_hidup_L * 100, 2):0;
        $bcg_P = $kelahiran->lahir_hidup_P>0?number_format($bcg->bcg_P/$kelahiran->lahir_hidup_P * 100, 2):0;
        $total_bcg = $bcg->bcg_P + $bcg->bcg_L;
        $persen_bcg = $kelahiran->lahir_hidup_L + $kelahiran->lahir_hidup_P > 0?number_format(($bcg->bcg_L + $bcg->bcg_P)/($kelahiran->lahir_hidup_L + $kelahiran->lahir_hidup_P) * 100, 2):0;
   
        return response()->json([
            'message' => 'success',
            'duaempat_jam_L' => $duaempat_jam_L,
            'duaempat_jam_P' => $duaempat_jam_P,
            'total_duaempat_jam' => $total_duaempat_jam,
            'persen_duaempat_jam' => $persen_duaempat_jam,
            'satu_minggu_L' => $satu_minggu_L,
            'satu_minggu_P' => $satu_minggu_P,
            'total_satu_minggu' => $total_satu_minggu,
            'persen_satu_minggu' => $persen_satu_minggu,
            'bcg_L' => $bcg_L,
            'bcg_P' => $bcg_P,
            'total_bcg' => $total_bcg,
            'persen_bcg' => $persen_bcg,
            'total_L' => $total_L,
            'persen_L' => $persen_L,
            'total_P' => $total_P,
            'persen_P' => $persen_P,
            'total_LP' => $total_LP,
            'persen_LP' => $persen_LP,
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
            return Excel::download(new BalitaBcgExport, 'Balita Imunisasi Bcg dan Hepatitis_report.xlsx');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
