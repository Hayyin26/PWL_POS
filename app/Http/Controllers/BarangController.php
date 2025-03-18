<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use App\Models\BarangModel;

class BarangController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Barang',
            'list'  => ['Home', 'Barang']
        ];

        $page = (object) [
            'title' => 'Daftar barang yang terdaftar dalam sistem'
        ];

        $activeMenu = 'barang';

        $barang= BarangModel::all();

        return view('barang.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang,'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $barang = BarangModel::select('barang_id','barang_kode','barang_nama','kategori_id', 'harga_beli','harga_jual')
                    ->with('kategori');

        if ($request->barang_id) {
            $barang->where('barang_id', $request->barang_id);
        }

        return DataTables::of($barang)
            ->addIndexColumn()
            ->addColumn('aksi', function ($barang) {
                $btn  = '<a href="'.url('/barang/' . $barang->barang_id).'" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="'.url('/barang/' . $barang->barang_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="'.url('/barang/'.$barang->barang_id).'">'
                     . csrf_field() . method_field('DELETE') 
                     . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah anda yakin menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Barang',
            'list'  => ['Home', 'Barang', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Barang baru'
        ];

        $barang = BarangModel::all();
        $activeMenu = 'Barang';

        return view('barang.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
{
    $request->validate([
        'barang_nama'  => 'required|string|max:100',
        'barang_kode'  => 'required|string|max:10|unique:m_barang,barang_kode',
        'kategori_id'  => 'required|integer',
        'harga_beli'   => 'required|numeric',
        'harga_jual'   => 'required|numeric',
    ]);

    BarangModel::create([
        'barang_nama'  => $request->barang_nama,
        'barang_kode'  => $request->barang_kode,
        'kategori_id'  => $request->kategori_id,
        'harga_beli'   => $request->harga_beli,
        'harga_jual'   => $request->harga_jual,
    ]);

    return redirect('/barang')->with('success', 'Data Barang berhasil disimpan');
}


    public function show(string $id)
    {
        $barang = BarangModel::with('barang')->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail barang',
            'list'  => ['Home', 'Barang', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail User'
        ];

        $activeMenu = 'barang';

        return view('barang.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang, 'activeMenu' => $activeMenu]);
    }

    public function edit(string $id) 
    {
        $barang = BarangModel::find($id);
        $level = LevelModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit Barang',
            'list'  => ['Home', 'Barang', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Barang'
        ];

        $activeMenu = 'barang';

        return view('barang.edit',['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, string $id)
{
    $request->validate([
        'barang_nama'  => 'required|string|max:100',
        'barang_kode'  => 'required|string|max:10|unique:m_barang,barang_kode,'.$id.',barang_id',
        'kategori_id'  => 'required|integer',
        'harga_beli'   => 'required|numeric',
        'harga_jual'   => 'required|numeric',
    ]);

    $barang = BarangModel::findOrFail($id);
    
    $barang->update([
        'barang_nama'  => $request->barang_nama,
        'barang_kode'  => $request->barang_kode,
        'kategori_id'  => $request->kategori_id,
        'harga_beli'   => $request->harga_beli,
        'harga_jual'   => $request->harga_jual,
    ]);

    return redirect('/barang')->with('success', 'Data Barang berhasil diperbarui');
}

    public function destroy(string $id)
    {
        $check = BarangModel::find($id);
        if (!$check) {
            return redirect('/barang')->with('error', 'Data user tidak ditemukan');
        }

        try {
            BarangModel::destroy($id);

            return redirect('/barang')->with('success', 'Data user berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            
            return redirect('/barang')-with('error', 'Data user gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}

