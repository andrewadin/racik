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
                        <li class="breadcrumb-item active">Edit Pesanan</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>Edit Pesanan Catering</h2>                       
                    </div>
                    <div class="body">
                        @foreach($pesanan as $pes)
                        <form action="{{ '/pesanan' }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="no_nota">Nomor Nota</label>
                            <input type="text" name="id" id="id" value="{{$pes->id}}" hidden>
                            <input type="text" class="form-control ipt @error('no_nota') is-invalid @enderror" id="no_nota" name="no_nota" value="{{$pes->no_nota}}" readonly>
                            @error('no_nota')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <h5>Konsumen Lama</h5>
                        <div class="form-group">
                            <select class="js-example-basic-single js-states form-control ipt kons @error('konsumen_lama') is-invalid @enderror" name="konsumen_lama" id="konsumen_lama">
                                @foreach($konsumen as $kon)
                                <option value="{{$kon->id}}" {{ $pes->konsumen->id == $kon->id ? 'selected' : '' }}>{{$kon->nama}}</option>
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
                            <input type="text" name="id_kon" id="id_kon" hidden>
                            <input type="text" class="form-control ipt @error('nama_konsumen') is-invalid @enderror" id="nama_konsumen" name="nama_konsumen" value ="{{$pes->konsumen->nama}}" placeholder="Nama Konsumen" readonly>
                            @error('nama_konsumen')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="no_hp">No. HP Konsumen</label>
                            <input type="text" class="form-control ipt @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp" value="{{$pes->konsumen->no_hp}}" placeholder="No. HP Konsumen" readonly>
                            @error('no_hp')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="summernote">Alamat Konsumen</label>
                            <textarea name="summernote" id="summernote" class="form-control @error('summernote') is-invalid @enderror" placeholder="Alamat Konsumen" style="height:200px;" readonly>{{$pes->konsumen->alamat}}</textarea>
                            @error('summernote')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div id="chg">
                            <div class="form-group">
                                <label for="paket">Paket Catering</label>
                                <br>
                                <select class="form-control ipt paket @error('paket') is-invalid @enderror" name="paket" id="paket" style="width:100%;" required>
                                    @foreach($paket as $pak)
                                    <option value="{{$pak->id}}" {{ $pes->paket->id == $pak->id ? 'selected' : '' }}>{{$pak->nama_paket}}</option>
                                    @endforeach
                                </select>
                                @error('paket')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="catatan">Catatan Konsumen</label>
                                <textarea name="catatan" id="catatan" class="form-control @error('catatan') is-invalid @enderror" placeholder="Catatan" style="height:200px;">{{$pes->catatan}}</textarea>
                                @error('catatan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <input type="text" name="tipe" id="tipe" hidden disabled>
                            <input type="text" name="harga" id="harga" hidden disabled>
                            <div class="form-group">
                                <label for="">Tanggal Pengiriman</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="icon-calendar"></i></span>
                                    </div>
                                    <input data-provide="datepicker" id="tgl_pesan" name="tgl_pesan" data-date-autoclose="false" class="form-control datepicker" placeholder="Tanggal Pesan" value="{{$tgl}}" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                                <label for="waktu">Waktu Makan</label>
                                <br>
                                <select class="form-control ipt @error('waktu') is-invalid @enderror" name="waktu" id="waktu" required>
                                    @foreach($waktu as $wkt)
                                    <option value="{{$wkt->id}}" {{ $pes->waktu->id == $wkt->id ? 'selected' : '' }}>{{$wkt->waktu}}</option>
                                    @endforeach
                                </select>
                                @error('waktu')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        <div class="form-group">
                            <label for="">Total Biaya</label>
                            <div class="input-group">
                                <input type="text" class="form-control ipt @error('tgl') is-invalid @enderror total" id="total" name="total"  value="{{$pes->total}}" hidden>
                                <input type="text" class="form-control ipt @error('tgl') is-invalid @enderror vtotal" id="vtotal" name="vtotal" value="" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Harga Khusus</label>
                            <div class="input-group">
                                <input type="number" class="form-control ipt @error('tgl') is-invalid @enderror" id="h_khusus" name="h_khusus">
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a class="btn btn-secondary" href="{{ '/pesanan' }}">Kembali</a>
                        </form>
                        @endforeach
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
    $(function(){
        if($('.kons').length > 0) {
            $('.kons').select2({
                placeholder: "Pilih Konsumen Lama",
                allowClear: true
            });
        }
        if($('.paket').length > 0){
            $('.paket').select2({
                placeholder: "Pilih Paket Catering",
                allowClear: true
            });
        }
    });
</script>
<script>
    $('.datepicker').datepicker({
        language: "id",
        multidate: true,
        format: 'yyyy-mm-dd',
        todayHighlight: true
    });
</script>
<script>
    // Ajax get data konsumen untuk emngisi data konsumen lama secara otomatis
        $(document).ready(function(){
            $("#konsumen_lama").on('change', function (){
                console.log("berubah" + $(this).val())
                let value = $(this).val();
                if(value != ""){
                    $('#nama_konsumen').empty();
                    fetchRecords(value);
                }

            });
            $('#chg').on('change', function (event){
                var elem = event.target;
                let hrg = [];
                if(elem.name === "paket"){
                    let val = elem.value;
                    getPkt(val);
                }
                if(elem.name === "tgl_pesan"){
                    let arr = elem.value.split(",");
                    let disk = $('#diskon').val() - 0;
                    let tmb = $('#hrg_tmb').val() - 0;
                    let hrg = $('#harga').val();
                    let jml = arr.length;
                    let tipe = $('#tipe').val();
                    if(tipe == 'Harian'){
                        let total = (hrg * jml) - disk + tmb ;
                        $('#total').val(total);
                        $('#vtotal').val(total);
                        formatTotal(total);
                    }else{
                        let total = hrg - disk + tmb;
                        $('#total').val(total)
                        $('#vtotal').val(total)
                        formatTotal(total);
                    }
                }
            });
            $('#add').on('change', function (event){
                let elem = event.target;
                if(elem.name === 'diskon' || elem.name === 'hrg_tmb'){
                    let arr = $('#tgl_pesan').val().split(',');
                    let disk = $('#diskon').val() - 0;
                    let tmb = $('#hrg_tmb').val() - 0;
                    let hrg = $('#harga').val();
                    let jml = arr.length;
                    let tipe = $('#tipe').val();
                    if(tipe == 'Harian'){
                        let total = (hrg * jml) - disk + tmb ;
                        $('#total').val(total);
                        $('#vtotal').val(total);
                        formatTotal(total);
                    }else{
                        let total = hrg - disk + tmb;
                        $('#total').val(total)
                        $('#vtotal').val(total)
                        formatTotal(total);
                    }
                }
            });
                
        });
        function formatTotal(tot){
            var fixtotal = new Intl.NumberFormat("id-ID", {
                    style: "currency",
                    currency: "IDR"
                }).format(tot).replace(',00', '').replace('Rp', '');
                $('.vtotal').val(fixtotal);
        }
        function fetchRecords(id){
        $.ajax({
            url: '/konsumen/'+id,
            async: true,
            type: 'get',
            dataType: 'json',
            success: function(response){

            var len = 0;
            if(response != null){
                len = response.length;

                $('#nama_konsumen').empty();
            }

            if(len > 0){
                for(var i=0; i<len; i++){
                    var id = response[i].id;
                    var nama = response[i].nama;
                    var no_hp = response[i].no_hp;
                    var alamat = response[i].alamat;

                    console.log(id, nama, no_hp, alamat);
                    $('#id_kon').val(id);
                    $('#nama_konsumen').val(nama);
                    $('#no_hp').val(no_hp);
                    $('#summernote').val(alamat);
                }
            }

            }
        });
        }
        function getPkt(id){
            $.ajax({
            url: '/paket/'+id,
            async: true,
            type: 'get',
            dataType: 'json',
            success: function(response){

            var len = 0;
            if(response != null){
                len = response.length;
            }

            if(len > 0){
                for(var i=0; i<len; i++){
                    var tipe = response[i].tipe.nama_tipe;
                    var harga = response[i].harga;
                    var art = $('#tgl_pesan').val().split(",");
                    var n = art.length;
                    var disk = ($('#diskon').val() - 0);
                    var tmb = $('#hrg_tmb').val() - 0;
                    $('#tipe').val(tipe);
                    $('#harga').val(harga);
                    if(tipe == 'Harian'){
                        var total = (harga * n) - disk + tmb;
                        $('#total').val(total);
                        formatTotal(total);
                    }else{
                        var total = harga - disk + tmb;
                        $('#total').val(total);
                        formatTotal(total);
                    }
                    
                    
                }
            }
            }
        });
        }
    </script>
@endpush