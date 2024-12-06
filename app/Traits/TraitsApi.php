<?php
namespace App\Traits;
use Carbon\Carbon;
use App\Models\Tagihan;
use Illuminate\Support\Facades\Http;

trait TraitsApi
{
	public function loginApi($type, $vaUsername, $qrisUsername){
        if ($type == 'Virtual Account'){
            $response = Http::post('https://e-api.bankaltimtara.co.id:8083/api-pemda/user/auth', [
                'username' => $vaUsername,
                'password' => '123456',
            ]);
        }elseif($type == 'QRIS'){
            $response = Http::post('https://qris-pemda.bankaltimtara.co.id/api/qrismpm/user/auth', [
                'username' => $qrisUsername,
                'password' => '123456',
            ]);
        }
        return response()->json($response->body());
    }

    public function requestVA($tagihan, $code, $vaUsername, $institution, $qrisUsername){
        // dd($code, $vaUsername, $qrisUsername, $institution, $tagihan->pelanggan);
        $data = [
            'number'=>(string)$code.substr($tagihan->id_tagihan,-15),
            'name'=>$tagihan->pelanggan->name,
            'amount'=>(string)round($tagihan->jumlah_pembayaran+$tagihan->denda_harian+$tagihan->denda_admin),
            'description'=>'Bayar PAP Bulan '.Carbon::create($tagihan->tanggal)->isoFormat('MMMM Y')
        ];
        $token = json_decode($this->loginApi('Virtual Account', $vaUsername, $qrisUsername)->original)->token;
        $response = Http::withToken($token)
        ->post('https://e-api.bankaltimtara.co.id:8083/api-pemda/va/create',$data)->body();
        $response = json_decode($response);
        // dd($data);
        $html = view('layouts.includes.response-va',compact('data'))->render();
        $data['amount'] = 'Rp '.number_format($data['amount']);
        $data['html'] = $html;
        return $data; 
    }

    public function requestQRIS($tagihan, $code, $vaUsername, $institution, $qrisUsername){
        $data = [
            'institution'=>$institution,
            'amount'=>(string)round($tagihan->jumlah_pembayaran+$tagihan->denda_harian+$tagihan->denda_admin),
            'method'=>'12',
            'kd_tagihan'=>(string)$code.substr($tagihan->id_tagihan,-15),
        ];
        $token = json_decode($this->loginApi('QRIS', $vaUsername, $qrisUsername)->original)->token;
        $response = Http::withToken($token)
        ->post('https://qris-pemda.bankaltimtara.co.id/api/qrismpm/generate',$data)->body();
        $response = json_decode($response);
        $html = view('layouts.includes.response-qris',compact('data','response'))->render();
        $data['amount'] = 'Rp '.number_format($data['amount']);
        $data['html'] = $html;
        $data['qris'] = $response->barcode;
        return $data;
    }


    public function updateVA($tagihan, $code, $vaUsername, $institution, $qrisUsername){
        $data = [
            'number'=>(string)$code.substr($tagihan->id_tagihan,-15),
            'amount'=>(string)round($tagihan->jumlah_pembayaran+$tagihan->denda_harian+$tagihan->denda_admin),
        ];
        $token = json_decode($this->loginApi('Virtual Account', $vaUsername, $qrisUsername)->original)->token;
        $response = Http::withToken($token)
        ->post('https://e-api.bankaltimtara.co.id:8083/api-pemda/va/update',$data)->body();
        $response = json_decode($response);
        if ($response->code != '00') {
           return abort(500);
        }
    }

    public function deleteVA($number, $code, $vaUsername, $institution, $qrisUsername){
        $data = [
            'number'=>(string)$number
        ];
        $token = json_decode($this->loginApi('Virtual Account', $vaUsername, $qrisUsername)->original)->token;
        $response = Http::withToken($token)
        ->post('https://e-api.bankaltimtara.co.id:8083/api-pemda/va/delete',$data)->body();
        $response = json_decode($response);
        if ($response->code == '04') {
           return abort(500);
       }
   }

    public function cekStatus($tagihan, $code, $vaUsername, $institution, $qrisUsername){
        $token = json_decode($this->loginApi($tagihan->metode, $vaUsername, $qrisUsername)->original)->token;
        if ($tagihan->metode == 'Virtual Account') {
            // $contoh = '0099221102024708669';
            $response = Http::withToken($token)
            ->get('https://e-api.bankaltimtara.co.id:8083/api-pemda/va/paid/nova'.$tagihan->kd_tagihan)->body();
        }elseif($tagihan->metode == 'QRIS'){
            $contoh = '0099221102020139493';
            $response = Http::withToken($token)
            ->post('https://qris-pemda.bankaltimtara.co.id/api/qrismpm/transaction/status',[
                'kd_tagihan'=>$tagihan->kd_tagihan,
                'institusi'=>$institution
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