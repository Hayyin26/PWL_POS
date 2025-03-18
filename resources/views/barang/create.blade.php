@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools"></div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ url('barang') }}" class="form-horizontal">
            @csrf

            <!--Barang -->
            <div class="form-group row">
                <label class="col-1 control-label col-form-label">Barang</label>
                <div class="col-11">
                    <input type="text" class="form-control" id="barang_id" name="barang_id" 
                           value="{{ old('barang_id') }}" required>
                    @error('barang_id')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <!-- Kode Barang -->
            <div class="form-group row">
                <label class="col-1 control-label col-form-label">Kode Barang</label>
                <div class="col-11">
                    <input type="text" class="form-control" id="barang_kode" name="barang_kode" 
                           value="{{ old('barang_kode') }}" required>
                    @error('barang_kode')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <!-- Nama Barang -->
            <div class="form-group row">
                <label class="col-1 control-label col-form-label">Nama Barang</label>
                <div class="col-11">
                    <input type="text" class="form-control" id="nama_barang" name="nama_barang" 
                           value="{{ old('nama_barang') }}" required>
                    @error('nama_barang')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <!-- Kategori ID -->
            <div class="form-group row">
                <label class="col-1 control-label col-form-label">ID Kategori</label>
                <div class="col-11">
                    <select class="form-control" id="kategori_id" name="kategori_id" required>
                    <option value="">- Pilih ID Kategori -</option>
                    @foreach($barang as $item)
                    <option value="{{ $item->kategori_id }}">{{ $item->kategori_id }}</option>
                    @endforeach
                </select>
                @error('kategori_id')
                <small class="form-text text-danger">{{ $message }}</small>
                @enderror
                </div>
            </div>

            <!-- Harga Beli -->
            <div class="form-group row">
                <label class="col-1 control-label col-form-label">Harga Beli</label>
                <div class="col-11">
                    <input type="harga_beli" class="form-control" id="harga_beli" name="harga_beli" required>
                    @error('harga_beli')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <!-- Harga Jual -->
            <div class="form-group row">
                <label class="col-1 control-label col-form-label">Harga Jual</label>
                <div class="col-11">
                    <input type="harga_jual" class="form-control" id="harga_jual" name="harga_jual" required>
                    @error('harga_jual')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <!-- Tombol Simpan & Kembali -->
            <div class="form-group row">
                <label class="col-1 control-label col-form-label"></label>
                <div class="col-11">
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    <a class="btn btn-sm btn-default ml-1" href="{{ url('barang') }}">Kembali</a>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection

@push('css')
@endpush

@push('js')
@endpush
