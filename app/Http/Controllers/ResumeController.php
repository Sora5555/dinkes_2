<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResumeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'resume';
    protected $viewName = 'resume';
    protected $title = 'Resume';
    public function index(Request $request)
    {

    $resume = Resume::all();
     // Fetch all unitKerja records

    $unit_kerja = Auth::user()->unit_kerja;
    $data=[
        'route'=>$this->routeName,
        'title'=>$this->title,
        'resume' => $resume,
        'unit_kerja' => $unit_kerja,
    ];

    return view($this->viewName.'.index')->with($data);
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
    public function apiLock(Request $request){
        $datas = $request->id::get();

        foreach ($datas as $key => $data) {
            # code...
            $data->update([
                'status' => $request->status,
            ]);
        }
    }
}
