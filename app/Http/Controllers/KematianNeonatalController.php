<?php

namespace App\Http\Controllers;

use App\Exports\KematianNeonatalExport;
use Session;
use App\Models\Desa;
use App\Models\KematianNeonatal;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class KematianNeonatalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'KematianNeonatal';
    protected $viewName = 'kematian_neonatal';
    protected $title = 'Kematian Neonatal';
    public function index(Request $request)
    {
        $unit_kerja = UnitKerja::all();
        $desa = Desa::all();
        // foreach ($desa as $key => $value) {
        //     # code...
        //     KematianNeonatal::create([
        //         'desa_id' => $value->id,
        //     ]);
        // }
        $unit_kerja = UnitKerja::all();
    $neo_L = 0;
    $post_neo_L = 0;
    $balita_L = 0;
    $neo_P = 0;
    $post_neo_P = 0;
    $balita_P = 0;

        if(Auth::user()->roles->first()->name !== "Admin"){
            foreach(Auth::user()->unit_kerja->Desa()->get() as $desa){
                if($desa->filterNeonatal(Session::get('year'))){
                    $neo_L += $desa->filterKematianNeonatal(Session::get('year'))->neo_L;
                $post_neo_L += $desa->filterKematianNeonatal(Session::get('year'))->post_neo_L;
                $balita_L += $desa->filterKematianNeonatal(Session::get('year'))->balita_L;
                $neo_P += $desa->filterKematianNeonatal(Session::get('year'))->neo_P;
                $post_neo_P += $desa->filterKematianNeonatal(Session::get('year'))->post_neo_P;
                $balita_P += $desa->filterKematianNeonatal(Session::get('year'))->balita_P;
                }
            }
        } else{
            foreach($unit_kerja as $desa){
                $neo_L += $desa->admin_total(Session::get('year'), 'filterKematianNeonatal', 'neo_L');
                $post_neo_L += $desa->admin_total(Session::get('year'), 'filterKematianNeonatal', 'post_neo_L');
                $balita_L += $desa->admin_total(Session::get('year'), 'filterKematianNeonatal', 'balita_L');
                $neo_P += $desa->admin_total(Session::get('year'), 'filterKematianNeonatal', 'neo_P');
                $post_neo_P += $desa->admin_total(Session::get('year'), 'filterKematianNeonatal', 'post_neo_P');
                $balita_P += $desa->admin_total(Session::get('year'), 'filterKematianNeonatal', 'balita_P');
            }
        }
        $data=[
            'route'=>$this->routeName,
            'title'=>$this->title,
            'unit_kerja' =>  $unit_kerja,
            'neo_L' =>  $neo_L,
            'post_neo_L' =>  $post_neo_L,
            'balita_L' =>  $balita_L,
            'neo_P' =>  $neo_P,
            'post_neo_P' =>  $post_neo_P,
            'balita_P' =>  $balita_P,
            'desa' => Auth::user()->unit_kerja?Auth::user()->unit_kerja->Desa()->get():Desa::all(),
        ];

        return view($this->viewName.'.index')->with($data);
    }
    public function add(Request $request)
    {
        $counter = 0;
    
        $fillable = (new KematianNeonatal())->getFillable(); // Get only fillable attributes
        $sessionYear = Session::get('year'); // Retrieve the year from the session

    
        foreach (Auth::user()->unit_kerja->Desa()->get() as $desa) {
            if ($desa->filterKematianNeonatal($sessionYear)) {
                continue;
            } else {
                $data = [];
    
                foreach ($fillable as $field) {
                    // Set desa_id and default values for other fields
                    $data[$field] = $field === 'desa_id' ? $desa->id : 0;
                }
    
                // Create a model instance
                $result = new KematianNeonatal($data);
    
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
        $kematianNeonatal = KematianNeonatal::where('id', $request->id)->first();
        $desa = $kematianNeonatal->Desa;
        $kematianNeonatal->update([
            $request->name => $request->value,
        ]);
        $bayi_L = $kematianNeonatal->neo_L + $kematianNeonatal->post_neo_L;
        $bayi_P = $kematianNeonatal->neo_P + $kematianNeonatal->post_neo_P;
        $total_L = $kematianNeonatal->neo_L + $kematianNeonatal->post_neo_L + $kematianNeonatal->balita_L;
        $total_P = $kematianNeonatal->neo_P + $kematianNeonatal->post_neo_P + $kematianNeonatal->balita_P;
        $neo_LP = $kematianNeonatal->neo_P + $kematianNeonatal->neo_L;
        $post_neo_LP = $kematianNeonatal->post_neo_P + $kematianNeonatal->post_neo_L;
        $bayi_LP = $kematianNeonatal->post_neo_P + $kematianNeonatal->post_neo_L +  $kematianNeonatal->neo_P + $kematianNeonatal->neo_L;
        $balita_LP = $kematianNeonatal->balita_P + $kematianNeonatal->balita_L;
        $total_LP = $kematianNeonatal->balita_P + $kematianNeonatal->balita_L + $kematianNeonatal->post_neo_P + $kematianNeonatal->post_neo_L +  $kematianNeonatal->neo_P + $kematianNeonatal->neo_L;

        $sum_neo_LP = 0;
        $sum_post_neo_LP = 0;
        $sum_bayi_LP = 0;
        $sum_balita_LP = 0;
        $sum_total_LP = 0;
        $total = 0;
        $desa = $kematianNeonatal->Desa->UnitKerja;

        foreach ($desa->desa()->get() as $key => $value) {
            # code...
            $sum_neo_LP += $value->filterKematianNeonatal(Session::get('year'))->neo_L + $value->filterKematianNeonatal(Session::get('year'))->neo_P;
            $sum_post_neo_LP += $value->filterKematianNeonatal(Session::get('year'))->post_neo_L + $value->filterKematianNeonatal(Session::get('year'))->post_neo_P;
            $sum_bayi_LP += $value->filterKematianNeonatal(Session::get('year'))->post_neo_L + $value->filterKematianNeonatal(Session::get('year'))->post_neo_P + $value->filterKematianNeonatal(Session::get('year'))->neo_L + $value->filterKematianNeonatal(Session::get('year'))->neo_P;
            $sum_balita_LP += $value->filterKematianNeonatal(Session::get('year'))->balita_L + $value->filterKematianNeonatal(Session::get('year'))->balita_P;
            $sum_total_LP += $value->filterKematianNeonatal(Session::get('year'))->balita_L + $value->filterKematianNeonatal(Session::get('year'))->balita_P + $value->filterKematianNeonatal(Session::get('year'))->post_neo_L + $value->filterKematianNeonatal(Session::get('year'))->post_neo_P + $value->filterKematianNeonatal(Session::get('year'))->neo_L + $value->filterKematianNeonatal(Session::get('year'))->neo_P;
            $total += $value->filterKematianNeonatal(Session::get('year'))->{$request->name};
        }

        return response()->json([
            'message' => 'success',
            'bayi_L' => $bayi_L,
            'bayi_P' => $bayi_P,
            'total_L' => $total_L,
            'total_P' => $total_P,
            'neo_LP' => $neo_LP,
            'post_neo_LP' => $post_neo_LP,
            'bayi_LP' => $bayi_LP,
            'balita_LP' => $balita_LP,
            'total_LP' => $total_LP,
            'sum_neo_LP' => $sum_neo_LP,
            'sum_post_neo_LP' => $sum_post_neo_LP,
            'sum_bayi_LP' => $sum_bayi_LP,
            'sum_balita_LP' => $sum_balita_LP,
            'sum_total_LP' => $sum_total_LP,
            'total' => $total,
            'column' => $request->name,
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
            return Excel::download(new KematianNeonatalExport, 'Kematian Neonatal_report.xlsx');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
