<?php

namespace App\Http\Controllers;

use App\Exports\BblrPrematurExport;
use App\Models\BblrPrematur;
use App\Models\Desa;
use App\Models\Kelahiran;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class bblrPrematurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'BblrPrematur';
    protected $viewName = 'bblrPrematur';
    protected $title = 'Bblr dan Prematur';
    public function index(Request $request)
    {
        $unit_kerja = UnitKerja::all();
        // $desa = Desa::all();
        // foreach ($desa as $key => $value) {
        //     # code...
        //     BblrPrematur::create([
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
    
        $fillable = (new BblrPrematur())->getFillable(); // Get only fillable attributes
        $sessionYear = Session::get('year'); // Retrieve the year from the session

    
        foreach (Auth::user()->unit_kerja->Desa()->get() as $desa) {
            if ($desa->filterBblr($sessionYear)) {
                continue;
            } else {
                $data = [];
    
                foreach ($fillable as $field) {
                    // Set desa_id and default values for other fields
                    $data[$field] = $field === 'desa_id' ? $desa->id : 0;
                }
    
                // Create a model instance
                $result = new BblrPrematur($data);
    
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
        $bblr = BblrPrematur::where('id', $request->id)->first();
        $bblr->update([
            $request->name => $request->value,
        ]);
        $lahir = Kelahiran::where('desa_id', $bblr->desa_id)->whereYear('created_at', 2024)->first();
        $timbang_L = $lahir->lahir_hidup_L>0?number_format($bblr->timbang_L/$lahir->lahir_hidup_L * 100, 2):0;
        $timbang_P = $lahir->lahir_hidup_P>0?number_format($bblr->timbang_P/$lahir->lahir_hidup_P * 100, 2):0;
        $timbang_LP = $bblr->timbang_P + $bblr->timbang_L;
        $persen_timbang_LP = $lahir->lahir_hidup_P + $lahir->lahir_hidup_L>0?number_format(($bblr->timbang_P + $bblr->timbang_L)/($lahir->lahir_hidup_P + $lahir->lahir_hidup_L) * 100, 2):0;
        
        $bblr_L = $lahir->lahir_hidup_L>0?number_format($bblr->bblr_L/$lahir->lahir_hidup_L * 100, 2):0;
        $bblr_P = $lahir->lahir_hidup_P>0?number_format($bblr->bblr_P/$lahir->lahir_hidup_P * 100, 2):0;
        $bblr_LP = $bblr->bblr_P + $bblr->bblr_L;
        $persen_bblr_LP = $lahir->lahir_hidup_P + $lahir->lahir_hidup_L>0?number_format(($bblr->bblr_P + $bblr->bblr_L)/($lahir->lahir_hidup_P + $lahir->lahir_hidup_L) * 100, 2):0;
        
        $prematur_L = $lahir->lahir_hidup_L>0?number_format($bblr->prematur_L/$lahir->lahir_hidup_L * 100, 2):0;
        $prematur_P = $lahir->lahir_hidup_P>0?number_format($bblr->prematur_P/$lahir->lahir_hidup_P * 100, 2):0;
        $prematur_LP = $bblr->prematur_P + $bblr->prematur_L;
        $persen_prematur_LP = $lahir->lahir_hidup_P + $lahir->lahir_hidup_L>0?number_format(($bblr->prematur_P + $bblr->prematur_L)/($lahir->lahir_hidup_P + $lahir->lahir_hidup_L) * 100, 2):0;
 
        return response()->json([
            'message' => 'success',
            'timbang_L' => $timbang_L,
            'timbang_P' => $timbang_P,
            'timbang_LP' => $timbang_LP,
            'persen_timbang_LP' => $persen_timbang_LP,
            'bblr_L' => $bblr_L,
            'bblr_P' => $bblr_P,
            'bblr_LP' => $bblr_LP,
            'persen_bblr_LP' => $persen_bblr_LP,
            'prematur_L' => $prematur_L,
            'prematur_P' => $prematur_P,
            'prematur_LP' => $prematur_LP,
            'persen_prematur_LP' => $persen_prematur_LP,
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
            return Excel::download(new BblrPrematurExport, 'Bayi Lahir BBLR dan Prematur_report.xlsx');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
