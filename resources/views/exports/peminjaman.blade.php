<table>
    <thead>
        <tr>
            <th>Nama Peminjam</th>
            <th>Email</th>
            <th>Telepon</th>
            <th>Instansi</th>
            <th>Ruangan</th>
            <th>Kegiatan</th>
            <th>Tanggal</th>
            <th>Mulai</th>
            <th>Selesai</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($peminjaman as $item)
        <tr>
            <td>{{ $item->nama_peminjam }}</td>
            <td>{{ $item->email_peminjam }}</td>
            <td>{{ $item->telepon_peminjam }}</td>
            <td>{{ $item->instansi_peminjam }}</td>
            <td>{{ $item->ruangan->nama_ruangan ?? '-' }}</td>
            <td>{{ $item->kegiatan }}</td>
            <td>{{ $item->tanggal_peminjaman }}</td>
            <td>{{ $item->waktu_mulai }}</td>
            <td>{{ $item->waktu_selesai }}</td>
            <td>{{ ucfirst($item->status) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
