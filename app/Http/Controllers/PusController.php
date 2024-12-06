<?php

namespace App\Http\Controllers;

use App\Exports\PusExport;
use App\Models\Desa;
use App\Models\Pus;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class PusController extends Controller
{
    protected $routeName = 'Pus';
    protected $viewName = 'Pus';
    protected $title = 'Pasien Usia Subur';
    public function index(Request $request)
    {
        $unit_kerja = UnitKerja::all();
        // $desa = Desa::all();
        // foreach ($desa as $key => $value) {
        //     # code...
        //     Pus::create([
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
    
        $fillable = (new Pus())->getFillable(); // Get only fillable attributes
        $sessionYear = Session::get('year'); // Retrieve the year from the session

    
        foreach (Auth::user()->unit_kerja->Desa()->get() as $desa) {
            if ($desa->filterPus($sessionYear)) {
                continue;
            } else {
                $data = [];
    
                foreach ($fillable as $field) {
                    // Set desa_id and default values for other fields
                    $data[$field] = $field === 'desa_id' ? $desa->id : 0;
                }
    
                // Create a model instance
                $result = new Pus($data);
    
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
        $pus = Pus::where('id', $request->id)->first();
        $pus->update([
            $request->name => $request->value,
        ]);
        $kondom = $pus->jumlah>0?number_format($pus->kondom/$pus->jumlah*100, 2):0;
        $pil = $pus->jumlah>0?number_format($pus->pil/$pus->jumlah*100, 2):0;
        $suntik = $pus->jumlah>0?number_format($pus->suntik/$pus->jumlah*100, 2):0;
        $mop = $pus->jumlah>0?number_format($pus->mop/$pus->jumlah*100, 2):0;
        $mow = $pus->jumlah>0?number_format($pus->mow/$pus->jumlah*100, 2):0;
        $akdr = $pus->jumlah>0?number_format($pus->akdr/$pus->jumlah*100, 2):0;
        $implan = $pus->jumlah>0?number_format($pus->implan/$pus->jumlah*100, 2):0;
        $mal = $pus->jumlah>0?number_format($pus->mal/$pus->jumlah*100, 2):0;
        $efek_samping = $pus->jumlah>0?number_format($pus->efek_samping/$pus->jumlah*100, 2):0;
        $komplikasi = $pus->jumlah>0?number_format($pus->komplikasi/$pus->jumlah*100, 2):0;
        $kegagalan = $pus->jumlah>0?number_format($pus->kegagalan/$pus->jumlah*100, 2):0;
        $dropout = $pus->jumlah>0?number_format($pus->dropout/$pus->jumlah*100, 2):0;
        $jumlah = $pus->kondom + $pus->pil + $pus->suntik + $pus->mop + $pus->mow + $pus->akdr + $pus->implan + $pus->mal;
        $persen_jumlah = $pus->jumlah>0?number_format((($pus->kondom + $pus->pil + $pus->suntik + $pus->akdr + $pus->mop + $pus->mow + $pus->implan + $pus->mal)/$pus->jumlah) * 100, 2):0;

        return response()->json([
            'status' => 'success',
            'kondom' => $kondom,
            'pil' => $pil,
            'suntik' => $suntik,
            'mop' => $mop,
            'mow' => $mow,
            'akdr' => $akdr,
            'implan' => $implan,
            'mal' => $mal,
            'efek_samping' => $efek_samping,
            'komplikasi' => $komplikasi,
            'kegagalan' => $kegagalan,
            'dropout' => $dropout,
            'jumlah' => $jumlah,
            'persen_jumlah' => $persen_jumlah,
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
            return Excel::download(new PusExport, 'PUS_report.xlsx');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
