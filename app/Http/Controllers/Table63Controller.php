<?php

namespace App\Http\Controllers;

use App\Exports\Table63Export;
use App\Models\Desa;
use App\Models\IndukOpd;
use App\Models\Table63;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class Table63Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $routeName = 'table_63';
    protected $viewName = 'input_data.table_63';
    protected $title = 'JUMLAH BAYI YANG LAHIR DARI IBU REAKTIF HBsAg dan MENDAPATKAN HBIG';
    public function index(Request $request)
    {
        //
        // dd(Desa::all());
        if(Table63::count() == 0) {
            foreach (Desa::all() as $key => $value) {
                # code...
                Table63::create([
                    'desa_id' => $value->id,
                    'jumlah_bayi' => 1,
                    'jumlah_k_24' => 1,
                    'jumlah_b_24' => 1,
                ]);
            }
        }
        // $unit_kerja1 = UnitKerja::first();
        // dd($unit_kerja1->kelahiran_per_desa(null)["lahir_hidup_L"]);

        $unit_kerja = UnitKerja::all();

        // dd(Auth::user()->unit_kerja_id);

        // dd(UnitKerja::first()->jumlah_k1);
        // dd($this->routeName);

        $data=[
            'route'=>$this->routeName,
            'title'=>$this->title,
            'unit_kerja' =>  $unit_kerja,
            'desa' => Auth::user()->unit_kerja?Auth::user()->unit_kerja->Desa()->get():Desa::all(),
            // 'jabatan' => Jabatan::get(),
            // 'jenis_jabatan' => JenisJabatan::pluck('nama', 'id'),
            // 'unit_organisasi' => UnitOrganisasi::get()
        ];

        return view($this->viewName.'.index')->with($data);
    }
    public function add(Request $request)
    {
        $counter = 0;
    
        $fillable = (new Table63())->getFillable(); // Get only fillable attributes
        $sessionYear = Session::get('year'); // Retrieve the year from the session

    
        foreach (Auth::user()->unit_kerja->Desa()->get() as $desa) {
            if ($desa->filterTable63($sessionYear, $desa->id)) {
                continue;
            } else {
                $data = [];
    
                foreach ($fillable as $field) {
                    // Set desa_id and default values for other fields
                    $data[$field] = $field === 'desa_id' ? $desa->id : 0;
                }
    
                // Create a model instance
                $result = new Table63($data);
    
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
        try {
            $data = Table63::where('id', $request->id)->first();

            $data->update([
                $request->name => $request->value,
            ]);

            $jumlah = $data->jumlah_k_24 + $data->jumlah_b_24;
            $persen_k_24 =  number_format(($data->jumlah_k_24 / $data->jumlah_bayi) * 100, 2) . '%';
            $persen_b_24 = number_format(($data->jumlah_b_24 / $data->jumlah_bayi) * 100, 2) . '%';
            $persen_jumlah =  number_format(($jumlah / $data->jumlah_bayi) * 100, 2) . '%' ;

            $jumlah_bayi = Table63::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('jumlah_bayi');
            $jumlah_k_24 = Table63::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('jumlah_k_24');
            $jumlah_k_p_24 =  number_format(($jumlah_k_24 / $jumlah_bayi) * 100, 2) . '%';
            $jumlah_b_24 =  Table63::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('jumlah_b_24');
            $jumlah_b_p_24 = number_format(($jumlah_b_24 / $jumlah_bayi) * 100, 2) . '%';
            $jumlah_kb_24 = $jumlah_k_24 + $jumlah_b_24;
            $jumlah_kb_p_24 = number_format(($jumlah_kb_24 / $jumlah_bayi) * 100, 2) . '%';


            return response()->json([
                'status' => 'success',
                'jumlah' => $jumlah,
                'persen_k_24' => $persen_k_24,
                'persen_b_24' => $persen_b_24,
                'persen_jumlah' => $persen_jumlah,

                'jumlah_bayi' => $jumlah_bayi,
                'jumlah_k_24' => $jumlah_k_24,
                'jumlah_k_p_24' => $jumlah_k_p_24,
                'jumlah_b_24' => $jumlah_b_24,
                'jumlah_b_p_24' => $jumlah_b_p_24,
                'jumlah_kb_24' =>  $jumlah_kb_24,
                'jumlah_kb_p_24' =>  $jumlah_kb_p_24,
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => 'error',
            ]);
        }
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
            return Excel::download(new Table63Export, 'JUMLAH BAYI YANG LAHIR DARI IBU REAKTIF HBsAg dan MENDAPATKAN HBIG_report.xlsx');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
