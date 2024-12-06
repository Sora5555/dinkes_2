<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Log;
use App\Models\User;
use App\Mail\Emailing;
use App\Models\Pelanggan;
use App\Models\HistoryEmail;
use Illuminate\Http\Request;
use App\Models\TemplateEmail;
use App\Models\UptDaerah;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;

class HistoryEmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'history_email';
    protected $viewName = 'history_email';
    protected $title = 'History Email';

    public function index()
    {
        //
        $route = $this->routeName;
        $title = $this->title;
        return view($this->viewName.'.index',compact('route','title'));
    }

    public function datatable()
    {
        $datas = HistoryEmail::join('pelanggans','pelanggans.id','=','history_emails.pelanggan_id')->join('template_emails','template_emails.id','=','history_emails.template_email_id')->join('users', 'pelanggans.user_id', '=', 'users.id')->select('history_emails.id','pelanggan_id', 'users.email','template_email_id','history_emails.created_at','template_emails.nama_email');

        $datatables = DataTables::of($datas)
            ->addIndexColumn()
            ->editColumn('created_at',function($data){
                return $data->created_at->format('Y-m-d H:i:s');
            });

        return $datatables->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $route = $this->routeName;
        $title = $this->title;
        $pelanggans = Pelanggan::with('user')->get();
        $upt_daerahs = UptDaerah::all();
        $emails = TemplateEmail::all();
        return view($this->viewName.'.create',compact('route','title','pelanggans','emails', 'upt_daerahs'));
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
        $validator = $request->validate([
            'pelanggan' => 'required',
            'template_email' => 'required|string|max:100',
        ]);
        DB::beginTransaction();
        try {
            $emails = $request->pelanggan;
            foreach($emails as $email){
                $query = HistoryEmail::create([
                    'pelanggan_id' => $email,
                    'template_email_id' => $request->template_email
                ]);
                $pelanggan = Pelanggan::find($email);
                $template_email = TemplateEmail::find($request->template_email);
                
                Mail::to($pelanggan->user->email)->send(new Emailing($pelanggan->user, $template_email, false, Carbon::now()));
                DB::commit();     
            }
            Log::create([
                'pengguna' => Auth::user()->name,
                'kegiatan' => "Mengirim E-mail"
            ]);
            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Menambah email : '.$query->id_pembayaran]);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['error'=>'Gagal Mengirim Pesan : '.$e->getMessage()])->withErrors($request->all());
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
}
