<?php

namespace App\Http\Controllers;

use App\Exports\WusTidakHamilExport;
use App\Models\Desa;
use App\Models\UnitKerja;
use App\Models\Wus;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class WusTidakHamilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'WusTidakHamil';
    protected $viewName = 'wus_tidak_hamil';
    protected $title = 'Wus Tidak Hamil';
    public function index(Request $request)
    {
        $unit_kerja = UnitKerja::all();
        // $desa = Desa::all();
        // foreach ($desa as $key => $value) {
        //     # code...
        //     Wus::create([
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
    
        $fillable = (new Wus())->getFillable(); // Get only fillable attributes
        $sessionYear = Session::get('year'); // Retrieve the year from the session
    
        foreach (Auth::user()->unit_kerja->Desa()->get() as $desa) {
            if ($desa->filterWus($sessionYear, 1)) {
                continue;
            } else {
                $data = [];
    
                foreach ($fillable as $field) {
                    // Set desa_id and default values for other fields
                    $data[$field] = $field === 'desa_id' ? $desa->id : 0;
                }
                dd("A");
    
                // Create a model instance
                $result = new Wus($data);
    
                // Manually set created_at and updated_at
                $createdAt = Carbon::create($sessionYear, 1, 1); // Default to Jan 1st, 00:00
                $result->created_at = $createdAt;
                $result->hamil = 1;
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
        $wusTidakHamil = Wus::where('id', $request->id)->first();
        $wusTidakHamil->update([
            $request->name => $request->value,
        ]);
        $td1 = $wusTidakHamil->jumlah>0?number_format($wusTidakHamil->td1/$wusTidakHamil->jumlah * 100, 2):0;
        $td2 = $wusTidakHamil->jumlah>0?number_format($wusTidakHamil->td2/$wusTidakHamil->jumlah * 100, 2):0;
        $td3 = $wusTidakHamil->jumlah>0?number_format($wusTidakHamil->td3/$wusTidakHamil->jumlah * 100, 2):0;
        $td4 = $wusTidakHamil->jumlah>0?number_format($wusTidakHamil->td4/$wusTidakHamil->jumlah * 100, 2):0;
        $td5 = $wusTidakHamil->jumlah>0?number_format($wusTidakHamil->td5/$wusTidakHamil->jumlah * 100, 2):0;

        return response()->json([
            'status' => 'success',
            'td1' => $td1,
            'td2' => $td2,
            'td3' => $td3,
            'td4' => $td4,
            'td5' => $td5,
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
            return Excel::download(new WusTidakHamilExport, 'Wus Tidak Hamil_report.xlsx');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    public function detail_desa(Request $request, $id, $secondaryFilter = null)
    {
        $unitKerja = UnitKerja::find($id); // Retrieve the unit kerja
        $desas = Desa::where('unit_kerja_id', $id)->get();
    
        $year = Session::get('year');
        // dd($request->input('secondaryFilter'));
        // Dynamically apply the filters based on the provided filter names
        $desas->map(function ($desa) use ($year) {
            // Apply the main filter
            if (method_exists($desa, 'filterWus')) {
                $mainFilteredData = $desa->filterWus($year, 0);
    
                if ($mainFilteredData) {
                    // Automatically assign all attributes returned by the main filter
                    foreach ($mainFilteredData->toArray() as $key => $value) {
                        if($key == "id"){
                            continue;
                        }
                        $desa->{$key} = $value;
                    }
                }
            }
    
            // Apply the optional secondary filter
            // dd($desa);
            return $desa;
        });
    
        return response()->json([
            'status' => 'success',
            'data' => $unitKerja,
            'desa' => $desas,
        ]);
    }
    public function lock(Request $request){
        $unitKerja = UnitKerja::where('id', $request->id)->first();    
        $unitKerja->WusTidakHamilLock(Session::get('year'), $request->status);   
    
        return response()->json([
            'status' => 'success',
            'data' => $unitKerja,
        ]);
    }
}
