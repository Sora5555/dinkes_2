<table>
    <thead>
        <tr>
            <th>username</th>
           <th>Perangkat Opd</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($Pembayaran as $p)
        <tr>
            <td>{{$p->username}}</td>
            <td>{{$p->nama}}</td>
        </tr>
        @endforeach
    </tbody>
</table>