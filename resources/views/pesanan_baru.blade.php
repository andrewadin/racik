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
                        <form action="{{ '/pesanan/tambah' }}" method="post">
                        @csrf
                        <h5>Konsumen Lama</h5>
                        <div class="form-group">
                            <select class="form-control ipt @error('konsumen_lama') is-invalid @enderror" name="konsumen_lama" id="konsumen_lama">
                                <option selected id="opsi_kml">Konsumen Lama</option>
                                @foreach($konsumen as $kon)
                                <option value="{{$kon->id}}">{{$kon->nama}}</option>
                                @endforeach
                            </select>
                            @error('konsumen_lama')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="nama_konsumen">Nama Konsumen</label>
                            <input type="text" class="form-control ipt @error('nama_konsumen') is-invalid @enderror" id="nama_konsumen" name="nama_konsumen" placeholder="Nama Konsumen">
                            @error('nama_konsumen')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="no_hp">No. HP Konsumen</label>
                            <input type="text" class="form-control ipt @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp" placeholder="No. HP Konsumen">
                            @error('no_hp')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="summernote">Alamat Konsumen</label>
                            <textarea name="summernote" id="summernote" class="form-control @error('summernote') is-invalid @enderror" placeholder="Alamat Konsumen" style="height:200px;"></textarea>
                            @error('summernote')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="paket">Paket Catering</label>
                            <select class="form-control ipt @error('paket') is-invalid @enderror" name="paket" id="paket">
                                <option selected id="opsi_kml">Pilih Paket</option>
                                @foreach($paket as $pak)
                                <option value="{{$pak->id}}">{{$pak->nama_paket}}</option>
                                @endforeach
                            </select>
                            @error('paket')
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
                                <input data-provide="datepicker" id="tgl_pesan" name="tgl_pesan" data-date-autoclose="false" class="form-control datepicker" placeholder="Tanggal Pesan">
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
    $('.datepicker').datepicker({
        language: "id",
        multidate: true
    });
</script>
<script>
        $(document).ready(function(){
            $("#sekolah").on('change', function (){
                console.log("berubah" + $(this).val())
                let value = $(this).val();
                if(value != ""){
                    $('#kelas').empty();
                    fetchRecords(value);
                }

            });
        });
        function fetchRecords(nama){
        $.ajax({
            url: '/instansi/kelas/'+nama,
            async: true,
            type: 'get',
            dataType: 'json',
            success: function(response){

            var len = 0;
            if(response != null){
                len = response.length;
                var options = '<option>Pilih Kelas</options>';

                $('#kelas').append(options);
            }

            if(len > 0){
                for(var i=0; i<len; i++){
                    var id = response[i].id;
                    var nama_kelas = response[i].nama_kelas;

                    var options = '<option value="' + id +'">' + nama_kelas + '</option>';

                    $('#kelas').append(options);
                }
            }

            }
        });
        }
    </script>
@endpush