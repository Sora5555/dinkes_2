<?php

namespace App\Http\Controllers;

use App\Exports\ImunBumilExport;
use App\Models\Desa;
use App\Models\IbuHamilDanBersalin;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class ImunBumilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'ImunBumil';
    protected $viewName = 'imun_bumil';
    protected $title = 'Imun Bumil';
    public function index(Request $request)
    {

        $unit_kerja = UnitKerja::all();

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
    
        $fillable = (new IbuHamilDanBersalin())->getFillable(); // Get only fillable attributes
        $sessionYear = Session::get('year'); // Retrieve the year from the session
    
        foreach (Auth::user()->unit_kerja->Desa()->get() as $desa) {
            if ($desa->filterDesa($sessionYear)) {
                continue;
            } else {
                $data = [];
    
                foreach ($fillable as $field) {
                    // Set desa_id and default values for other fields
                    $data[$field] = $field === 'desa_id' ? $desa->id : 0;
                }
    
                // Create a model instance
                $result = new IbuHamilDanBersalin($data);
    
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
        $ibuHamil = IbuHamilDanBersalin::where('id', $request->id)->first();
        $ibuHamil->update([
            $request->name => $request->value,
        ]);
        $td1 = $ibuHamil->jumlah_ibu_hamil>0?number_format($ibuHamil->td1/$ibuHamil->jumlah_ibu_hamil * 100, 2):0;
        $td2 = $ibuHamil->jumlah_ibu_hamil>0?number_format($ibuHamil->td2/$ibuHamil->jumlah_ibu_hamil * 100, 2):0;
        $td3 = $ibuHamil->jumlah_ibu_hamil>0?number_format($ibuHamil->td3/$ibuHamil->jumlah_ibu_hamil * 100, 2):0;
        $td4 = $ibuHamil->jumlah_ibu_hamil>0?number_format($ibuHamil->td4/$ibuHamil->jumlah_ibu_hamil * 100, 2):0;
        $td5 = $ibuHamil->jumlah_ibu_hamil>0?number_format($ibuHamil->td5/$ibuHamil->jumlah_ibu_hamil * 100, 2):0;
        $td2_plus = $ibuHamil->jumlah_ibu_hamil>0?number_format($ibuHamil->td2_plus/$ibuHamil->jumlah_ibu_hamil * 100, 2):0;
        return response()->json([
            'status' => 'success',
            'td1' => $td1,
            'td2' => $td2,
            'td3' => $td3,
            'td4' => $td4,
            'td5' => $td5,
            'td2_plus' => $td2_plus,
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
            return Excel::download(new ImunBumilExport, 'Imun Ibu Hamil_report.xlsx');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
