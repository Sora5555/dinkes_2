<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <table>
        <thead>
            <tr>
  
                <th rowspan="2">
                    ID KOTA 
                </th>
                <th rowspan="2">
                    KOTA/KABUPATEN
                </th>
                <th rowspan="2">
                    TANGGAL
                </th>
                <th rowspan="2">
                    WAJIB PAJAK
                </th>
                <th rowspan="2">
                    POKOK
                </th>
                <th >
                    VOLUME
                </th>
                <th rowspan="2">
                    DENDA
                </th>
                
                <th rowspan="2">
                    PEMAKAIAN
                </th>
            </tr>
            <tr>
                <th>M³</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pelanggans as $pelanggan)
                <tr>
               
                    <td>
                        {{ sprintf("%02d", $pelanggan->daerah_id) }}
                    </td>
                    <td>
                        {{ $pelanggan->daerah->nama_daerah }}
                    </td>
                    
                    
                    <td>
                        {{ date("Y-m-d") }}
                    </td>
                    <td>
                        {{ $pelanggan->name }}
                    </td>
                    <td>

                    </td>
                    <td>

                    </td>
                    <td>

                    </td>
                    <td>
                        {{ config("app.months.".$bulan)." ".$tahun }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>