<?php

namespace App\Http\Controllers;

use App\Models\IndukOpd;
use Illuminate\Http\Request;

class CascadingRenstraController extends Controller
{
    protected $routeName = 'cascading_renstra';
    protected $viewName = 'cascading_renstra';
    protected $title = 'Cascading Renstra';

    public function index()
    {
        //
        $route = $this->routeName;
        $title = $this->title;
        $induk_opd_arr = IndukOpd::pluck('nama', 'id');
        return view('cascading_renstra.index',compact('route','title', 'induk_opd_arr'));

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
}