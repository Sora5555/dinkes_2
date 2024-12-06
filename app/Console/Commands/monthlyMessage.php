<?php

namespace App\Console\Commands;

use Helper\Helper;
use App\Mail\Emailing;
use App\Models\Pelanggan;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class monthlyMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'message:monthly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to send wa notifications to remind client to pay';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
       $pelanggans = Pelanggan::All();
       foreach($pelanggans as $pelanggan){
        $vars  = array(
            '{id_pelanggan}' => $pelanggan->id,
            '{nama_pelanggan}' => $pelanggan->name,
        );
        $msg = "Halo, jangan lupa melakukan pelaporan dan pembayaran untuk penggunaan air ya. (Abaikan bila sudah membayar)";
        $msg1 = strtr($msg, $vars);
        Helper::sendWa($pelanggan->no_telepon,$msg1);
        Mail::to($pelanggan->user->email)->send(new Emailing($pelanggan, true, true, false));
       }
    }
}
