<?php

namespace App\Http\Controllers;

use App\Exports\JumlahKematianIbuExport;
use App\Models\Desa;
use App\Models\JumlahKematianIbu;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class JumlahKematianIbuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'JumlahKematianIbu';
    protected $viewName = 'jumlah_kematian_ibu';
    protected $title = 'Jumlah Kematian Ibu';
    public function index(Request $request)
    {
        $unit_kerja = UnitKerja::all();
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

    $fillable = (new JumlahKematianIbu())->getFillable(); // Get only fillable attributes
    $sessionYear = Session::get('year'); // Retrieve the year from the session

    foreach (Auth::user()->unit_kerja->Desa()->get() as $desa) {
        if ($desa->filterKematianIbu($sessionYear)) {
            continue;
        } else {
            $data = [];

            foreach ($fillable as $field) {
                // Set desa_id and default values for other fields
                $data[$field] = $field === 'desa_id' ? $desa->id : 0;
            }

            // Create a model instance
            $neonatal = new JumlahKematianIbu($data);

            // Manually set created_at and updated_at
            $createdAt = Carbon::create($sessionYear, 1, 1); // Default to Jan 1st, 00:00
            $neonatal->created_at = $createdAt;
            $neonatal->updated_at = $createdAt;

            // Save the model instance
            $neonatal->save();

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
        $jumlahKematianIbu = JumlahKematianIbu::where('id', $request->id)->first();
        $jumlahKematianIbu->update([
            $request->name => $request->value,
        ]);
        $total = $jumlahKematianIbu->jumlah_kematian_ibu_hamil + $jumlahKematianIbu->jumlah_kematian_ibu_bersalin + $jumlahKematianIbu->jumlah_kematian_ibu_nifas;
        return response()->json([
            'status' => 'success',
            'total' => $total,
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
            return Excel::download(new JumlahKematianIbuExport, 'Jumlah kematian ibu_report.xlsx');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
