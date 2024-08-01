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
                        <form action="{{ '/pesanan/step2' }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="no_nota">Nomor Nota</label>
                            <input type="text" class="form-control ipt @error('no_nota') is-invalid @enderror" id="no_nota" name="no_nota" value="{{$today}}" readonly>
                            @error('no_nota')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <h5>Konsumen Lama</h5>
                        <div class="form-group">
                            <select class="form-control ipt kons @error('konsumen_lama') is-invalid @enderror" name="konsumen_lama" id="konsumen_lama">
                                <option id="opsi_kml"></option>
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
                            <input type="text" name="id_kon" id="id_kon" hidden>
                            <input type="text" class="form-control ipt @error('nama_konsumen') is-invalid @enderror" id="nama_konsumen" name="nama_konsumen" placeholder="Nama Konsumen" required>
                            @error('nama_konsumen')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="no_hp">No. HP Konsumen</label>
                            <input type="text" class="form-control ipt @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp" placeholder="No. HP Konsumen" required>
                            @error('no_hp')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="summernote">Alamat Konsumen</label>
                            <textarea name="summernote" id="summernote" class="form-control @error('summernote') is-invalid @enderror" placeholder="Alamat Konsumen" style="height:200px;" required></textarea>
                            @error('summernote')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <table class="table">
                            <thead>
                                <th>Paket</th>
                                <th>Tanggal Pengiriman</th>
                                <th>Waktu Makan</th>
                                <th>Catatan Umum</th>
                                <th><a href="#" class="btn btn-success add_more"><i class="fa fa-plus-square"></i></a></th>
                            </thead>
                            <tbody class="add-pkt">
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <select class="form-control ipt paket @error('paket') is-invalid @enderror" name="paket[]" id="paket" style="width:100%;" required>
                                                <option id="opsi_kml"></option>
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
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="icon-calendar"></i></span>
                                                </div>
                                                <input data-provide="datepicker" id="tgl_pesan" name="tgl_pesan[]" data-date-autoclose="false" class="form-control datepicker" placeholder="Tanggal Pesan" required>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <select class="form-control ipt @error('waktu') is-invalid @enderror waktu" name="waktu[]" id="waktu" required>
                                                <option id="opsi_kml" selected disabled>Lunch / Dinner</option>
                                                @foreach($waktu as $wkt)
                                                <option value="{{$wkt->id}}">{{$wkt->waktu}}</option>
                                                @endforeach
                                            </select>
                                            @error('waktu')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" class="form-control ipt @error('ctn') is-invalid @enderror ctn" name="ctn[]" id="ctn[]">
                                            @error('ctn')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </td>
                                    <td> </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Selanjutnya</button>
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
        });
        //     $('#chg').on('change', function (event){
        //         var elem = event.target;
        //         let hrg = [];
        //         if(elem.name === "paket"){
        //             let val = elem.value;
        //             getPkt(val);
        //         }
        //         if(elem.name === "tgl_pesan"){
        //             let arr = elem.value.split(",");
        //             let disk = $('#diskon').val() - 0;
        //             let tmb = $('#hrg_tmb').val() - 0;
        //             let hrg = $('#harga').val();
        //             let jml = arr.length;
        //             let tipe = $('#tipe').val();
        //             if(tipe == 'Harian'){
        //                 let total = (hrg * jml) - disk + tmb ;
        //                 $('#total').val(total);
        //                 $('#vtotal').val(total);
        //                 formatTotal(total);
        //             }else{
        //                 let total = hrg - disk + tmb;
        //                 $('#total').val(total)
        //                 $('#vtotal').val(total)
        //                 formatTotal(total);
        //             }
        //         }
        //     });
        //     $('#add').on('change', function (event){
        //         let elem = event.target;
        //         if(elem.name === 'diskon' || elem.name === 'hrg_tmb'){
        //             let arr = $('#tgl_pesan').val().split(',');
        //             let disk = $('#diskon').val() - 0;
        //             let tmb = $('#hrg_tmb').val() - 0;
        //             let hrg = $('#harga').val();
        //             let jml = arr.length;
        //             let tipe = $('#tipe').val();
        //             if(tipe == 'Harian'){
        //                 let total = (hrg * jml) - disk + tmb ;
        //                 $('#total').val(total);
        //                 $('#vtotal').val(total);
        //                 formatTotal(total);
        //             }else{
        //                 let total = hrg - disk + tmb;
        //                 $('#total').val(total)
        //                 $('#vtotal').val(total)
        //                 formatTotal(total);
        //             }
        //         }
        //     });
                
        // });
        // function formatTotal(tot){
        //     var fixtotal = new Intl.NumberFormat("id-ID", {
        //             style: "currency",
        //             currency: "IDR"
        //         }).format(tot).replace(',00', '').replace('Rp', '');
        //         $('.vtotal').val(fixtotal);
        // }
        $('.add_more').on('click', function() {
            var paket = $('.paket').html();
            var waktu = $('.waktu').html();
            var numberofrow = ($('.add-pkt tr').length - 0) + 1;
            var tr = '<tr>' +
                        '<td>' +
                            '<div class="form-group">' +
                                '<select class="form-control ipt paket @error("paket") is-invalid @enderror" name="paket[]" id="paket' + numberofrow + '" style="width:100%;" required>' + paket +
                                '</select>' +
                                '@error("paket")' +
                                '<div class="invalid-feedback">' +
                                    '{{ $message }}' +
                                '</div>' +
                                '@enderror' +
                            '</div>' +
                        '</td>' +
                        '<td>' +
                            '<div class="form-group">'+
                                '<div class="input-group">'+
                                    '<div class="input-group-prepend">'+
                                        '<span class="input-group-text"><i class="icon-calendar"></i></span>'+
                                    '</div>'+
                                    '<input data-provide="datepicker" id="tgl_pesan" name="tgl_pesan[]" data-date-autoclose="false" class="form-control datepicker" placeholder="Tanggal Pesan" required>'+
                                '</div>'+
                            '</div>'+
                        '</td>'+
                        '<td>'+
                            '<div class="form-group">'+
                                '<select class="form-control ipt @error("waktu") is-invalid @enderror" name="waktu[]" id="waktu" required>'+
                                waktu +
                                '</select>'+
                               ' @error("waktu")'+
                               ' <div class="invalid-feedback">'+
                                    '{{ $message }}'+
                                '</div>'+
                                '@enderror'+
                           '</div>'+
                        '</td>'+
                        '<td>' +
                            '<div class="form-group">' +
                                '<input type="text" class="form-control ipt @error('ctn') is-invalid @enderror ctn" name="ctn[]" id="ctn[]">' +
                                '@error("ctn")' +
                                '<div class="invalid-feedback">' +
                                    '{{ $message }}' +
                                '</div>' +
                                '@enderror' +
                            '</div>' +
                        '</td>' +   
                        '<td><a href="#" class="btn btn-danger delete"><i class="fa fa-minus-square"></i></a></td>' +
                    '</tr>';
            $('.add-pkt').append(tr);
            $('.paket').select2({
                placeholder: "Pilih Paket Catering",
                allowClear: true
            });
            $('.datepicker').datepicker({
                language: "id",
                multidate: true,
                format: 'yyyy-mm-dd',
                todayHighlight: true
            });
        });

        $('.add-pkt').delegate('.delete', 'click', function() {
            $(this).parent().parent().remove();
            $('.paket').select2({
                placeholder: "Pilih Paket Catering",
                allowClear: true
            });
            $('.datepicker').datepicker({
                language: "id",
                multidate: true,
                format: 'yyyy-mm-dd',
                todayHighlight: true
            });
        });

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
        // function getPkt(id){
        //     $.ajax({
        //     url: '/paket/'+id,
        //     async: true,
        //     type: 'get',
        //     dataType: 'json',
        //     success: function(response){

        //     var len = 0;
        //     if(response != null){
        //         len = response.length;
        //     }

        //     if(len > 0){
        //         for(var i=0; i<len; i++){
        //             var tipe = response[i].tipe.nama_tipe;
        //             var harga = response[i].harga;
        //             var art = $('#tgl_pesan').val().split(",");
        //             var n = art.length;
        //             var disk = ($('#diskon').val() - 0);
        //             var tmb = $('#hrg_tmb').val() - 0;
        //             $('#tipe').val(tipe);
        //             $('#harga').val(harga);
        //             if(tipe == 'Harian'){
        //                 var total = (harga * n) - disk + tmb;
        //                 $('#total').val(total);
        //                 formatTotal(total);
        //             }else{
        //                 var total = harga - disk + tmb;
        //                 $('#total').val(total);
        //                 formatTotal(total);
        //             }
                    
                    
        //         }
        //     }
        //     }
        // });
        // }
    </script>
@endpush