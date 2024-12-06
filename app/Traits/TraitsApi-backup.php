<?php
namespace App\Traits;
use Carbon\Carbon;
use App\Models\Tagihan;
use Illuminate\Support\Facades\Http;

trait TraitsApi
{
	public function loginApi($type){
        if ($type == 'Virtual Account'){
            $response = Http::post('https://api-dev.bankaltimtara.co.id:8083/api/va/user/auth', [
                'username' => 'generateva',
                'password' => 'generateva123',
            ]);
        }elseif($type == 'QRIS'){
            $response = Http::post('https://api-dev.bankaltimtara.co.id:8084/api/qrismpm/user/auth', [
                'username' => 'qrisdev',
                'password' => 'PB@|1Kp@paN19112021',
            ]);
        }
        return response()->json($response->body());
    }

    public function requestVA($tagihan){
        $data = [
            'number'=>(string)'0099'.substr($tagihan->id_tagihan,-15),
            'name'=>$tagihan->pelanggan->name,
            'amount'=>(string)round($tagihan->jumlah_pembayaran+$tagihan->denda_harian+$tagihan->denda_admin),
            'description'=>'Bayar PAP Bulan '.Carbon::create($tagihan->tanggal)->isoFormat('MMMM Y')
        ];
        $token = json_decode($this->loginApi('Virtual Account')->original)->token;
        $response = Http::withToken($token)
        ->post('https://api-dev.bankaltimtara.co.id:8083/api/va/create',$data)->body();
        $response = json_decode($response);
        // dd($data);
        $html = view('layouts.includes.response-va',compact('data'))->render();
        $data['amount'] = 'Rp '.number_format($data['amount']);
        $data['html'] = $html;
        return $data; 
    }

    public function requestQRIS($tagihan){
        $data = [
            'institution'=>'211028001',
            'kd_tagihan'=>(string)'0099'.substr($tagihan->id_tagihan,-15),
            'method'=>'12',
            'amount'=>(string)round($tagihan->jumlah_pembayaran+$tagihan->denda_harian+$tagihan->denda_admin)
        ];
        $token = json_decode($this->loginApi('QRIS')->original)->token;
        $response = Http::withToken($token)
        ->post('https://api-dev.bankaltimtara.co.id:8084/api/qrismpm/generate',$data)->body();
        $response = json_decode($response);
        $html = view('layouts.includes.response-qris',compact('data','response'))->render();
        $data['amount'] = 'Rp '.number_format($data['amount']);
        $data['html'] = $html;
        $data['qris'] = $response->barcode;
        return $data;
    }


    public function updateVA($tagihan){
        $data = [
            'number'=>(string)'0099'.substr($tagihan->id_tagihan,-15),
            'amount'=>(string)round($tagihan->jumlah_pembayaran+$tagihan->denda_harian+$tagihan->denda_admin),
        ];
        $token = json_decode($this->loginApi('Virtual Account')->original)->token;
        $response = Http::withToken($token)
        ->post('https://api-dev.bankaltimtara.co.id:8083/api/va/update',$data)->body();
        $response = json_decode($response);
        if ($response->code != '00') {
           return abort(500);
        }
    }

    public function deleteVA($number){
        $data = [
            'number'=>(string)$number
        ];
        $token = json_decode($this->loginApi('Virtual Account')->original)->token;
        $response = Http::withToken($token)
        ->post('https://api-dev.bankaltimtara.co.id:8083/api/va/delete',$data)->body();
        $response = json_decode($response);
        if ($response->code == '04') {
           return abort(500);
       }
   }

    public function cekStatus($tagihan){
        $token = json_decode($this->loginApi($tagihan->metode)->original)->token;
        if ($tagihan->metode == 'Virtual Account') {
            // $contoh = '0099221102024708669';
            $response = Http::withToken($token)
            ->get('https://api-dev.bankaltimtara.co.id:8083/api/va/paid/nova/'.$tagihan->kd_tagihan)->body();
        }elseif($tagihan->metode == 'QRIS'){
            $contoh = '0099221102020139493';
            $response = Http::withToken($token)
            ->post('https://api-dev.bankaltimtara.co.id:8084/api/qrismpm/transaction/status',[
                'kd_tagihan'=>$tagihan->kd_tagihan,
                'institusi'=>"211028001"
            ])->body();
        }
        $response = json_decode($response);
        if ($response->code == '00') {
            $tagihan->update(['status'=>2]);
            return true;
        }else{
            return false;
        }
    }
}