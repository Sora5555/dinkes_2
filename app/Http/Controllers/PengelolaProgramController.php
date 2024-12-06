<?php

namespace App\Http\Controllers;

use App\Models\PengelolaProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengelolaProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'pengelola_program';
    protected $viewName = 'pengelola_program';
    protected $title = 'pengelola_program';
    public function index()
    {
        //
        $route = $this->routeName;
        $title = $this->title;
        $pengelola_program = PengelolaProgram::where('user_id', Auth::user()->id)->get();
        return view('pengelola_program.index',compact('route','title','pengelola_program'));
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
        try {
            $pengelola_program = PengelolaProgram::where('user_id', Auth::user()->id)->where('program', $request->program)->first();
            if(!$pengelola_program){
                PengelolaProgram::create([
                    'nama' => $request->nama,
                    'program' => $request->program,
                    'nip' => $request->nip,
                    'desa_id' => 0,
                    'user_id' => Auth::user()->id,
                ]);
            } else {
                return redirect(route($this->routeName.'.index'))->with(['error'=>'Sudah ada pengelola program ini']);
            }
            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Menambah data']);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
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
        try {
            $pengelola_program = PengelolaProgram::where('id', $id)->first();
            if($pengelola_program->program != $request->program){
                $program_edit = PengelolaProgram::where('user_id', Auth::user()->id)->where('program', $request->program)->first();
                if($program_edit){
                    return redirect(route($this->routeName.'.index'))->with(['error'=>'Sudah ada pengelola program ini']);
                } else {
                    $pengelola_program->update([
                        'nama' => $request->nama,
                        'program' => $request->program,
                        'nip' => $request->nip,
                    ]);
                }
            } else {
                $pengelola_program->update([
                    'nama' => $request->nama,
                    'program' => $request->program,
                    'nip' => $request->nip,
                ]);
            }
            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Mengubah Data']);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
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
        try {
            $pengelola_program = PengelolaProgram::where('id', $id)->first();
            $pengelola_program->delete();

            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Menghapus Data']);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
    }
    public function apiEdit($id){

        $program = ["Ibu Hamil Dan Bersalin", "Neonatal", "Kesehatan Balita", "Peserta Didik", "Pelayanan Produktif", "Pelayanan Lansia", "Tuberkulosis", "Hipertensi", "Diabetes", "Kunjungan", "Orang Dalam Gangguan Jiwa"];
        $data = PengelolaProgram::where('id', $id)->first();

        return response()->json([
            'status' => 'success',
            'data' => $data,
            'program' => $program,
        ]);
    }
}
