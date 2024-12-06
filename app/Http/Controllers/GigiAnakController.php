<?php

namespace App\Http\Controllers;

use App\Exports\GigiAnakExport;
use App\Models\Desa;
use App\Models\GigiAnak;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class GigiAnakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'GigiAnak';
    protected $viewName = 'gigi_anak';
    protected $title = 'Pelayanan Kesehatan Gigi Anak';
    public function index(Request $request)
    {
        $unit_kerja = UnitKerja::all();
        // $desa = Desa::all();
        // foreach ($desa as $key => $value) {
        //     # code...
        //     GigiAnak::create([
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
    
        $fillable = (new GigiAnak())->getFillable(); // Get only fillable attributes
        $sessionYear = Session::get('year'); // Retrieve the year from the session

    
        foreach (Auth::user()->unit_kerja->Desa()->get() as $desa) {
            if ($desa->filterGigiAnak($sessionYear)) {
                continue;
            } else {
                $data = [];
    
                foreach ($fillable as $field) {
                    // Set desa_id and default values for other fields
                    $data[$field] = $field === 'desa_id' ? $desa->id : 0;
                }
    
                // Create a model instance
                $result = new GigiAnak($data);
    
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
        $gigi = GigiAnak::where('id', $request->id)->first();
        $gigi->update([
            $request->name => $request->value,
        ]);
        $sikat = $gigi->jumlah_sd > 0?number_format($gigi->jumlah_sikat/$gigi->jumlah_sd * 100, 2):0;
        $yan = $gigi->jumlah_sd > 0?number_format($gigi->jumlah_yan/$gigi->jumlah_sd * 100, 2):0;
        $diperiksa_L = $gigi->sd_L > 0?number_format($gigi->diperiksa_L/$gigi->sd_L * 100, 2):0;
        $diperiksa_P = $gigi->sd_P > 0?number_format($gigi->diperiksa_P/$gigi->sd_P * 100, 2):0;
        $diperiksa_LP = $gigi->diperiksa_L + $gigi->diperiksa_P;
        $sd_LP = $gigi->sd_L + $gigi->sd_P;
        $persen_diperiksa_LP = $gigi->sd_P + $gigi->sd_L > 0?number_format(($gigi->diperiksa_P + $gigi->diperiksa_L)/($gigi->sd_P + $gigi->sd_L) * 100, 2):0;
        $dapat_L = $gigi->rawat_L > 0?number_format($gigi->dapat_L/$gigi->rawat_L * 100, 2):0;
        $dapat_P = $gigi->rawat_P > 0?number_format($gigi->dapat_P/$gigi->rawat_P * 100, 2):0;
        $dapat_LP = $gigi->dapat_L + $gigi->dapat_P;
        $rawat_LP = $gigi->rawat_L + $gigi->rawat_P;
        $persen_dapat_LP = $gigi->rawat_P + $gigi->rawat_L > 0?number_format(($gigi->dapat_P + $gigi->dapat_L)/($gigi->rawat_P + $gigi->rawat_L) * 100, 2):0;
    
        return response()->json([
            'message' => 'success',
            'sikat' => $sikat, 
            'yan' => $yan, 
            'diperiksa_L' => $diperiksa_L, 
            'diperiksa_P' => $diperiksa_P, 
            'diperiksa_LP' => $diperiksa_LP, 
            'persen_diperiksa_LP' => $persen_diperiksa_LP, 
            'sd_LP' => $sd_LP, 
            'dapat_L' => $dapat_L, 
            'dapat_P' => $dapat_P, 
            'dapat_LP' => $dapat_LP, 
            'persen_dapat_LP' => $persen_dapat_LP, 
            'rawat_LP' => $rawat_LP, 
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
            return Excel::download(new GigiAnakExport, 'Perawatan Gigi Anak_report.xlsx');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
