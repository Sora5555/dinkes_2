<?php

namespace App\Http\Controllers;

use App\Exports\PelayananBalitaExport;
use App\Models\Desa;
use App\Models\Kelahiran;
use App\Models\PelayananBalita;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class PelayananBalitaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'PelayananBalita';
    protected $viewName = 'pelayanan_balita';
    protected $title = 'Cakupan Pelayanan Kesehatan Balita';
    public function index(Request $request)
    {
        $unit_kerja = UnitKerja::all();
        // $desa = Desa::all();
        // foreach ($desa as $key => $value) {
        //     # code...
        //     PelayananBalita::create([
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
    
        $fillable = (new PelayananBalita())->getFillable(); // Get only fillable attributes
        $sessionYear = Session::get('year'); // Retrieve the year from the session

    
        foreach (Auth::user()->unit_kerja->Desa()->get() as $desa) {
            if ($desa->filterPelayananBalita($sessionYear)) {
                continue;
            } else {
                $data = [];
    
                foreach ($fillable as $field) {
                    // Set desa_id and default values for other fields
                    $data[$field] = $field === 'desa_id' ? $desa->id : 0;
                }
    
                // Create a model instance
                $result = new PelayananBalita($data);
    
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
        $balita = PelayananBalita::where('id', $request->id)->first();
        $balita->update([
            $request->name => $request->value,
        ]);
        $kelahiran = Kelahiran::where('desa_id', $balita->desa_id)->first();
        $persen_jumlah_L = $kelahiran->lahir_hidup_L>0?number_format($balita->jumlah_L/$kelahiran->lahir_hidup_L * 100, 2):0;
        $persen_jumlah_P = $kelahiran->lahir_hidup_P>0?number_format($balita->jumlah_P/$kelahiran->lahir_hidup_P * 100, 2):0;
        $persen_jumlah_LP = $kelahiran->lahir_hidup_P + $kelahiran->lahir_hidup_L>0?number_format(($balita->jumlah_P + $balita->jumlah_L)/($kelahiran->lahir_hidup_P + $kelahiran->lahir_hidup_L) * 100, 2):0;
        $jumlah_LP = $balita->jumlah_P + $balita->jumlah_L;

        return response()->json([
            'message' => 'success',
            'persen_jumlah_L' => $persen_jumlah_L,
            'persen_jumlah_P' => $persen_jumlah_P,
            'persen_jumlah_LP' => $persen_jumlah_LP,
            'jumlah_LP' => $jumlah_LP,
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
            return Excel::download(new PelayananBalitaExport, 'Pelayanan Balita_report.xlsx');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
