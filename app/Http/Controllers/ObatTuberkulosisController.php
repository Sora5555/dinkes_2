<?php

namespace App\Http\Controllers;

use App\Exports\ObatTuberkulosisExport;
use App\Models\Desa;
use App\Models\ObatTuberkulosis;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class ObatTuberkulosisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'ObatTuberkulosis';
    protected $viewName = 'obat_tuberkulosis';
    protected $title = 'Obat Tuberkulosis';
    public function index(Request $request)
    {
        $unit_kerja = UnitKerja::all();
        $desa = Desa::all();
        foreach ($desa as $key => $value) {
            # code...
            if($value->filterObatTuberkulosis(2024) == null){
                ObatTuberkulosis::create([
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
    
        $fillable = (new ObatTuberkulosis())->getFillable(); // Get only fillable attributes
        $sessionYear = Session::get('year'); // Retrieve the year from the session

    
        foreach (Auth::user()->unit_kerja->Desa()->get() as $desa) {
            if ($desa->filterObatTuberkulosis($sessionYear)) {
                continue;
            } else {
                $data = [];
    
                foreach ($fillable as $field) {
                    // Set desa_id and default values for other fields
                    $data[$field] = $field === 'desa_id' ? $desa->id : 0;
                }
    
                // Create a model instance
                $result = new ObatTuberkulosis($data);
    
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
        $obat = ObatTuberkulosis::where('id', $request->id)->first();
        $obat->update([
            $request->name => $request->value,
        ]);
        $konfirmasi = $obat->konfirmasi_L + $obat->konfirmasi_P;
        $diobati = $obat->diobati_L + $obat->diobati_P;
        $kesembuhan_LP = $obat->kesembuhan_L + $obat->kesembuhan_P;
        $kesembuhan_L = $obat->konfirmasi_L>0?number_format($obat->kesembuhan_L/$obat->konfirmasi_L * 100, 2):0;
        $kesembuhan_P = $obat->konfirmasi_P>0?number_format($obat->kesembuhan_P/$obat->konfirmasi_P * 100, 2):0;
        $persen_kesembuhan_LP = $obat->konfirmasi_P + $obat->konfirmasi_L>0?number_format(($obat->kesembuhan_P + $obat->kesembuhan_L)/($obat->konfirmasi_L + $obat->konfirmasi_P) * 100, 2):0;
        
        $lengkap_LP = $obat->lengkap_L + $obat->lengkap_P;
        $lengkap_L = $obat->diobati_L>0?number_format($obat->lengkap_L/$obat->diobati_L * 100, 2):0;
        $lengkap_P = $obat->diobati_P>0?number_format($obat->lengkap_P/$obat->diobati_P * 100, 2):0;
        $persen_lengkap_LP = $obat->diobati_P + $obat->diobati_L>0?number_format(($obat->lengkap_P + $obat->lengkap_L)/($obat->diobati_L + $obat->diobati_P) * 100, 2):0;
        
        $berhasil_LP = $obat->berhasil_L + $obat->berhasil_P;
        $berhasil_L = $obat->diobati_L>0?number_format($obat->berhasil_L/$obat->diobati_L * 100, 2):0;
        $berhasil_P = $obat->diobati_P>0?number_format($obat->berhasil_P/$obat->diobati_P * 100, 2):0;
        $persen_berhasil_LP = $obat->diobati_P + $obat->diobati_L>0?number_format(($obat->berhasil_P + $obat->berhasil_L)/($obat->diobati_L + $obat->diobati_P) * 100, 2):0;
        
        $kematian = $obat->diobati_P + $obat->diobati_L>0?number_format(($obat->berhasil_P + $obat->berhasil_L)/($obat->diobati_L + $obat->diobati_P) * 100, 2):0;
    
        return response()->json([
            'message' => 'success',
            'konfirmasi' => $konfirmasi,
            'diobati' => $diobati,
            'kesembuhan_LP' => $kesembuhan_LP,
            'kesembuhan_L' => $kesembuhan_L,
            'kesembuhan_P' => $kesembuhan_P,
            'persen_kesembuhan_LP' => $persen_kesembuhan_LP,
            'lengkap_LP' => $lengkap_LP,
            'lengkap_L' => $lengkap_L,
            'lengkap_P' => $lengkap_P,
            'persen_lengkap_LP' => $persen_lengkap_LP,
            'berhasil_LP' => $berhasil_LP,
            'berhasil_L' => $berhasil_L,
            'berhasil_P' => $berhasil_P,
            'persen_berhasil_LP' => $persen_berhasil_LP,
            'kematian' => $kematian,
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
            return Excel::download(new ObatTuberkulosisExport, 'Pengobatan Tuberkulosis_report.xlsx');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
