<?php

namespace App\Traits;
use Session;
use Carbon\Carbon;
use App\Models\Tagihan;
use App\Models\JenisDenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * 
 */
trait TraitsDenda
{
	// protected $carbon = new Carbon;

	public function cekTunggakan($user_id,$tanggal){

		$tagihan = Tagihan::whereHas('pelanggan',function($query)use($user_id){
			$query->where(['user_id'=>$user_id]);
		})->whereIn('status',['0','1','2'])->orderBy('tanggal','asc')->get();

		$check_submited_data = Tagihan::whereHas('pelanggan',function($query)use($user_id){
			$query->where(['user_id'=>$user_id]);
		})->whereIn('status',['0','1','2'])->whereDate('tanggal',$tanggal)->count();
		if (Carbon::create($tanggal)->format('Y-m') == Carbon::now()->format('Y-m')) {
			dd($tanggal, Carbon::create($tanggal)->format('Y-m'), Carbon::now()->format('Y-m'), Carbon::create($tanggal)->format('Y-m') > Carbon::now()->format('Y-m'));
			redirect()->back()->send()->with(['error'=>'anda belum bisa melakukan pelaporan pada bulan '.Carbon::now()->isoFormat('MMMM-Y')])->withInput($request->all());
		}elseif(Carbon::create($tanggal)->format('Y-m') > Carbon::now()->format('Y-m')){
			dd("a");
			redirect()->back()->send()->with(['error'=>'anda belum bisa melakukan pelaporan pada bulan '.Carbon::create($tanggal)->isoFormat('MMMM-Y')])->withInput($request->all());
		}elseif($check_submited_data > 0){
			dd("b");
			redirect()->back()->send()->with(['error'=>'tagihan pada bulan '.Carbon::create($tanggal)->isoFormat('MMMM-Y').' sudah ada'])->withInput($request->all());
		}

		if ($tagihan->last()!== null) {
			$last_month = round($tagihan->last()->tanggal->format('m'));
			$submit_month = Carbon::createFromFormat('Y-m-d',$tanggal);
			$between = collect();
			if (Carbon::create($tanggal)->format('Y-m') < $tagihan->last()->tanggal->format('Y-m')) {
				//jika pelaporan yang diinput lebih jauh daripada data pelaporan pertama
			}else{
				//atau jika buka
				foreach (range($last_month,round($submit_month->format('m'))) as $key => $value) {
					if ($key !== 0 and $key !== 1) {
						//melakukan pengecekan jika data yang ingin diinput adalah bulan sebelumnya dan bukan bulan skrg
						$between[]=[
							'bulan'=>$value,
							'key'=>$key,
							'format'=>Carbon::createFromFormat('Y-m-d',$tanggal),
						];
						if(Carbon::create($tanggal)->format('Y') == $tagihan->last()->tanggal->format('Y')){
							dd(Carbon::create($tanggal)->format('Y') < $tagihan->last()->tanggal->format('Y'), Carbon::create($tanggal)->format('Y'), $tagihan->last()->tanggal->format('Y'));
						redirect()->back()->send()->with(['error'=>'silahkan lakukan pelaporan penggunaan bulan '.Carbon::create($tagihan->last()->tanggal->format('Y-m-d'))->addMonth(1)->isoFormat('MMMM-Y').' terlebih dahulu'])->withInput($request->all());
						}
					}
				}			
			}
		}
	}

	public function cekDendaAdmin($user_id,$tanggal,$request){
	
		// $carbon = Carbon::now();
		// $now = $carbon;
		// $current_month = $carbon->addMonth(-1);
		$denda = 0;
		$jenis_denda = JenisDenda::where(['type'=>'Sanksi Administrasi'])->first();
		$tanggal_jt = JenisDenda::where(['type'=>'Sanksi Administrasi'])->first()->tanggal_jt;

		
		// $submit_month = Carbon::createFromFormat('Y-m-d',Carbon::create($tanggal)->format('Y-m').'-'.$jenis_denda->tanggal_jt);
		// // if(Carbon::now()->addMonth(-1))
		// $diff = Carbon::createFromFormat('Y-m-d',Carbon::create($tanggal)->format('Y-m').'-'.$jenis_denda->tanggal_jt)->addMonth(2);

		
		// // return $diff;
		// if (Carbon::now()->addMonth(-1)->format('Y-m') > $submit_month->format('Y-m')) { 
		// 	//jika bulan yang mau dibayar adalah pemakaian bulan lalu
		// 	$month = $submit_month->addMonth(1)->diffInMonths($diff);
		// 	dd($month);
		
		// 	$denda = (($jenis_denda->nominal_denda*$month)/100) * $pembayaran;		
		// }
		$diff = (int)Carbon::create($tanggal)->diffInMonths(Carbon::now());
		$formatted = Carbon::create($tanggal);
		$month = $formatted->format('F');
		if($diff > 15){
			$denda = $jenis_denda->nominal_denda;
		} else if($diff == 0){
			if(Carbon::now()->addMonth(-1)->format("d") > $tanggal_jt){
				$denda = $jenis_denda->nominal_denda;
			} 
		} else if($diff > 0){
			if($month == 'February'){
				// dd($formatted->addMonth(1)->format('F'));
				$addedMonth = $formatted->addMonth(1)->format('F');
				if($addedMonth == "March" && Carbon::now()->format('F') == "March"){
					if(Carbon::now()->addMonth(-1)->format("d") < $tanggal_jt){
					// $denda = $jenis_denda->nominal_denda;
				} else {
					$denda = $jenis_denda->nominal_denda;
				}
			}
			else {
				$denda = $jenis_denda->nominal_denda;
			}

		}
		else if($diff > 0){
			$denda = $jenis_denda->nominal_denda;
		}
	}
			
		$nilaiDenda = (int)$denda;
		// if(Auth::user()->name == "hiu"){
		// 	dd($month, $formatted->addMonth(1)->format('F'), $diff);
		// }
		return $nilaiDenda;
}

public function cekDendaPenetapan($user_id, $tanggal, $pembayaran, $libur){
	$counter = 0;
	$i = Carbon::make($tanggal);
	for ($i;  $i < Carbon::now(); $i->addDay(1)) { 
		if(in_array($i->format("Y-m-d"), $libur)){
			continue;
		}
		if(Carbon::make($tanggal) < Carbon::now() && ($pembayaran->status_surat == 0 || $pembayaran->status_surat) ){
			$counter++;
		}
		// dd($counter);
		if($counter >= 15 && $pembayaran->status == 1){
			$pembayaran->update([
				'denda_harian' => $pembayaran->denda_harian + ($pembayaran->jumlah_pembayaran * 2/100),
				'status' => 5,
			]);
		}
		// if($counter >= 14 && $pembayaran->status == 5){
		// 	$pembayaran->update([
		// 		'denda_harian' => $pembayaran->denda_harian + ($pembayaran->jumlah_pembayaran * 2/100),
		// 		'status' => 6,
		// 	]);
		// }
	}
}

	public function cekDendaKeterlambatan($user_id,$tanggal,$pembayaran){

		// $carbon = Carbon::now();
		// $now = $carbon;
		// $current_month = $carbon->addMonth(-1);
		$denda = 0;
		$jenis_denda = JenisDenda::where(['type'=>'Denda Keterlambatan'])->first();

		if($jenis_denda){
			if($jenis_denda->tanggal_jt == 30 || $jenis_denda->tanggal_jt == 31){
				
			$diff = Carbon::create($tanggal)->diffInMonths(Carbon::now()->format('Y-m'));
				if($diff == 0){
					if(Carbon::now()->format("d") == Carbon::now()->endOfMonth()->format('d')){
						$denda = (($jenis_denda->nominal_denda*($diff)/100)) * $pembayaran;
					}
				}
				else if($diff > 15){
					$denda = (($jenis_denda->nominal_denda*(15)/100)) * $pembayaran;
    			} 
    			else if($diff > 0) {
					if(Carbon::now()->format("d") > $jenis_denda->tanggal_jt){
						$denda = (($jenis_denda->nominal_denda*($diff + 1)/100)) * $pembayaran;
						dd("a");
					} else if($diff >= 2){
						$denda = (($jenis_denda->nominal_denda*($diff)/100)) * $pembayaran;
						dd("b");
					}
				}
			$nilaiDenda = (int)$denda;
			return $nilaiDenda;
			} else {
				$diff = Carbon::create($tanggal)->diffInMonths(Carbon::now()->format('Y-m'));

				if($diff > 15){
					$denda = (($jenis_denda->nominal_denda*($diff + 1)/100)) * $pembayaran;
				} else if($diff == 0){
				if(Carbon::now()->addMonth(-1)->format("d") > $jenis_denda->tanggal_jt){
					$denda = (($jenis_denda->nominal_denda/100)) * $pembayaran;
				} 
				} else if($diff > 0){
					if(Carbon::now()->format("d") > $jenis_denda->tanggal_jt){
						$denda = (($jenis_denda->nominal_denda*($diff-1)/100)) * $pembayaran;
					} else if($diff >= 2){
						$denda = (($jenis_denda->nominal_denda*($diff-1)/100)) * $pembayaran;
					}
				}
		$nilaiDenda = (int)$denda;
		return $nilaiDenda;
			}
		} else {
			return $denda;
		}
		// $submit_month = Carbon::createFromFormat('Y-m-d',Carbon::create($tanggal)->format('Y-m').'-'.$jenis_denda->tanggal_jt);
		// // if(Carbon::now()->addMonth(-1))
		// $diff = Carbon::createFromFormat('Y-m-d',Carbon::create($tanggal)->format('Y-m').'-'.$jenis_denda->tanggal_jt)->addMonth(2);

		
		// // return $diff;
		// if (Carbon::now()->addMonth(-1)->format('Y-m') > $submit_month->format('Y-m')) { 
		// 	//jika bulan yang mau dibayar adalah pemakaian bulan lalu
		// 	$month = $submit_month->addMonth(1)->diffInMonths($diff);
		// 	dd($month);
		
		// 	$denda = (($jenis_denda->nominal_denda*$month)/100) * $pembayaran;		
		// }
	}



	public function refreshDendaKeterlambatan($user_id,$tanggal,$pembayaran,$date){
		// $carbon = Carbon::now();
		// $now = $carbon;
		// $current_month = $carbon->addMonth(-1);
		$denda = 0;
		$jenis_denda = JenisDenda::where(['type'=>'Denda Keterlambatan'])->first();

		
		if($jenis_denda){
			if($jenis_denda->tanggal_jt == 30 || $jenis_denda->tanggal_jt == 31){
				
			$diff = Carbon::create($tanggal)->diffInMonths(Carbon::now()->format('Y-m'));
				if($diff == 0){
					if(Carbon::now()->format("d") == Carbon::now()->endOfMonth()->format('d')){
						$denda = (($jenis_denda->nominal_denda*($diff)/100)) * $pembayaran;
					}
				}
				else if($diff > 15){
					$denda = (($jenis_denda->nominal_denda*(15)/100)) * $pembayaran;
    			} 
    			else if($diff > 0) {
					$denda = (($jenis_denda->nominal_denda*($diff)/100)) * $pembayaran;
				}
			$nilaiDenda = (int)$denda;
			return $nilaiDenda;
			} else {
				$diff = Carbon::create($tanggal)->diffInMonths(Carbon::now()->format('Y-m'));
				if($diff > 15){
					$denda = (($jenis_denda->nominal_denda*($diff)/100)) * $pembayaran;
				} else if($diff == 0){
				if(Carbon::now()->addMonth(-1)->format("d") > $jenis_denda->tanggal_jt){
					$denda = (($jenis_denda->nominal_denda/100)) * $pembayaran;
				} 
				} else if($diff > 0){
					if(Carbon::now()->format("d") > $jenis_denda->tanggal_jt){
						$denda = (($jenis_denda->nominal_denda*($diff)/100)) * $pembayaran;
					} else {
						$denda = (($jenis_denda->nominal_denda*($diff)/100)) * $pembayaran;
					}
				}
		$nilaiDenda = (int)$denda;
		return $nilaiDenda;
			}
		} else {
			return $denda;
		}
}
}

?>