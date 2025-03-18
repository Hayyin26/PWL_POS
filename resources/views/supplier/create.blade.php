@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools"></div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ url('supplier') }}" class="form-horizontal">
            @csrf

            <!-- Level -->
            <div class="form-group row">
                <label class="col-1 control-label col-form-label">supplier</label>
                <div class="col-11">
                    <select class="form-control" id="supplier_id" name="supplier_id" required>
                        <option value="">- Pilih Level -</option>
                        @foreach($supplier as $item)
                            <option value="{{ $item->supplier_id }}">{{ $item->supplier_nama }}</option>
                        @endforeach
                    </select>
                    @error('supplier_id')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <!-- Username -->
            <div class="form-group row">
                <label class="col-1 control-label col-form-label">Kode Supplier</label>
                <div class="col-11">
                    <input type="text" class="form-control" id="supplier_kode" name="supplier_kode" 
                           value="{{ old('supplier_kode') }}" required>
                    @error('supplier_kode')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <!-- Nama -->
            <div class="form-group row">
                <label class="col-1 control-label col-form-label">Nama Supplier</label>
                <div class="col-11">
                    <input type="text" class="form-control" id="supplier_nama" name="supplier_nama" 
                           value="{{ old('supplier_nama') }}" required>
                    @error('supplier_nama')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <!-- Nama -->
            <div class="form-group row">
                <label class="col-1 control-label col-form-label">Alamat</label>
                <div class="col-11">
                    <input type="text" class="form-control" id="supplier_alamat" name="supplier_alamat" 
                           value="{{ old('supplier_alamat') }}" required>
                    @error('supplier_alamat')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <!-- Tombol Simpan & Kembali -->
            <div class="form-group row">
                <label class="col-1 control-label col-form-label"></label>
                <div class="col-11">
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    <a class="btn btn-sm btn-default ml-1" href="{{ url('supplier') }}">Kembali</a>
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
