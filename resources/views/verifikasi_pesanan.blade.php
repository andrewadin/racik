@extends('layout.master')
@section('title') Pesanan Catering @endsection
@section('css')
<link rel="stylesheet" href="{{asset('assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}">
@endsection
@section('content')
<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-6 col-md-8 col-sm-12">
                <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Pesanan Catering</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="icon-home"></i></a></li>                            
                        <li class="breadcrumb-item">Data Pesanan</li>
                        <li class="breadcrumb-item active">Pesanan Baru</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>Pesanan Catering Baru</h2>                       
                    </div>
                    <div class="body">
                        <form action="{{ '/pesanan/simpan' }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="nama_konsumen">Nama Konsumen</label>
                            <input type="text" name="id_kon" id="id_kon" value="{{$id}}" hidden>
                            <input type="text" class="form-control ipt @error('nama_konsumen') is-invalid @enderror" id="nama_konsumen" name="nama_konsumen" value="{{$nama}}" readonly>
                            @error('nama_konsumen')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="no_hp">No. HP Konsumen</label>
                            <input type="text" class="form-control ipt @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp" value="{{$no_hp}}" readonly>
                            @error('no_hp')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="summernote">Alamat Konsumen</label>
                            <textarea name="summernote" id="summernote" class="form-control @error('summernote') is-invalid @enderror" placeholder="Alamat Konsumen" style="height:200px;" readonly>{{$alamat}}</textarea>
                            @error('summernote')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="n_paket">Paket Catering</label>
                            <input type="text" name="id_paket" id="id_paket" value="{{$paket}}" hidden>
                            <input type="text" class="form-control ipt @error('n_paket') is-invalid @enderror" id="n_paket" name="n_paket" value="{{$n_paket}}" readonly>
                            @error('n_paket')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="catatan">Catatan Konsumen</label>
                            <textarea name="catatan" id="catatan" class="form-control @error('catatan') is-invalid @enderror" placeholder="Catatan" style="height:200px;" readonly>{{$catatan}}</textarea>
                            @error('catatan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Tanggal Pengiriman</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-calendar"></i></span>
                                </div>
                                <input type="text" class="form-control ipt @error('tgl') is-invalid @enderror" id="tgl" name="tgl" value="{{$tgl}}" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Total Biaya</label>
                            <div class="input-group">
                                <input type="text" class="form-control ipt @error('tgl') is-invalid @enderror total" id="total" name="total" value="{{$total}}" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Harga Khusus</label>
                            <div class="input-group">
                                <input type="number" class="form-control ipt @error('tgl') is-invalid @enderror" id="h_khusus" name="h_khusus">
                            </div>
                        </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a class="btn btn-secondary" href="{{ '/pesanan' }}">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="{{asset('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
		
<script src="{{asset('assets/js/bootstrap-datepicker.id.min.js')}}" charset="UTF-8"></script>
<script>
    $(document).ready(function(){
        var total = $('#total').val();
        var fixtotal = new Intl.NumberFormat("id-ID", {
                style: "currency",
                currency: "IDR"
        }).format(total).replace(',00', '').replace('Rp', '');
        $('.total').val(fixtotal);
        });
</script>

@endpush