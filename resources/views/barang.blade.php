<!DOCTYPE html>
<html>
    <head>
        <title>Data Barang</title>
    </head>
    <body>
        <h1>Data Barang</h1>
        <table border="1" cellpadding="2" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>ID Kategori</th>
            <th>Harga Beli</th>
            <th>Harga Jual</th>
        </tr>
        @foreach ($data as $d)
        <tr>
            <td>{{ $d->barang_id }}</td>
            <td>{{ $d->barang_kode }}</td>
            <td>{{ $d->barang_nama }}</td>
            <td>{{ $d->kategori_id }}</td>
            <td>{{ $d->harga_beli }}</td>
            <td>{{ $d->harga_jual }}</td>
            <td>
                <a href="{{ url('/barang/ubah', $d->barang_id) }}">Ubah</a> | 
                <a href="{{ url('/barang/hapus', $d->barang_id) }}">Hapus</a>
            </td>
        </tr>
        @endforeach
    </table>
    </body>
</html>