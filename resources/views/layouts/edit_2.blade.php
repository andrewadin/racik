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
                        <form action="{{ '/pesanan' }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="no_nota">Nomor Nota</label>
                            <input type="text" class="form-control ipt @error('no_nota') is-invalid @enderror" id="no_nota" name="no_nota" value="{{$no_nota}}" readonly>
                            @error('no_nota')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="nama_konsumen">Nama Konsumen</label>
                            <input type="text" name="id_kon" id="id_kon"  value="{{$idks}}"hidden>
                            <input type="text" class="form-control ipt @error('nama_konsumen') is-invalid @enderror" id="nama_konsumen" name="nama_konsumen" placeholder="Nama Konsumen"  value="{{$nks}}" readonly>
                            @error('nama_konsumen')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="no_hp">No. HP Konsumen</label>
                            <input type="text" class="form-control ipt @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp" placeholder="No. HP Konsumen" value="{{$hpks}}" readonly>
                            @error('no_hp')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="summernote">Alamat Konsumen</label>
                            <textarea name="summernote" id="summernote" class="form-control @error('summernote') is-invalid @enderror" placeholder="Alamat Konsumen" style="height:200px;" readonly>{{$alks}}</textarea>
                            @error('summernote')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        @for($i=0; $i < count($npkt); $i++)
                        <h5>{{$npkt[$i]}} ({{$waktu[$i]}})</h5>
                        <input type="text" name="pkt[{{$i}}]" id="pkt[{{$i}}]" value="{{$paket[$i]}}" hidden>
                        <input type="text" name="wkt[{{$i}}]" id="wkt[{{$i}}]" value="{{$wkt[$i]}}" hidden>
                        <input type="text" name="hrg[{{$i}}]" id="hrg[{{$i}}]" value="{{$hrg[$i]}}" hidden>
                        <table class="table">
                            <thead>
                                <th>Taggal Pengiriman</th>
                                <th>Catatan</th>
                            </thead>
                            <tbody>
                                @for($j=0; $j < count($tgl_pesan[$i]); $j++)
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="icon-calendar"></i></span>
                                                </div>
                                                <input type="text" id="tgl_pesan[{{$i}}][{{$j}}]" name="tgl_pesan[{{$i}}][{{$j}}]" data-date-autoclose="false" class="form-control" placeholder="Tanggal Pesan" value="{{$tgl_pesan[$i][$j]->format('Y-m-d')}}" hidden>
                                                <input type="text" id="vtgl_pesan" name="vtgl_pesan[][]" data-date-autoclose="false" class="form-control" placeholder="Tanggal Pesan" value="{{$tgl_pesan[$i][$j]->isoFormat('dddd, D-MM-Y')}}" readonly>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" class="form-control ipt @error('catatan') is-invalid @enderror" id="catatan[{{$i}}][{{$j}}]" name="catatan[{{$i}}][{{$j}}]" placeholder="Catatan">
                                            @error('catatan')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </td>
                                    <td> </td>
                                </tr>
                                @endfor
                            </tbody>
                        </table>
                        @endfor
                        <div id="add">
                            <div class="form-group">
                                <label for="">Harga Tambahan</label>
                                <div class="input-group">
                                    <input type="number" class="form-control ipt @error('hrg_tmb') is-invalid @enderror" id="hrg_tmb" name="hrg_tmb" value="0">
                                </div>
                                    @error('hrg_tmb')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Diskon</label>
                                <div class="input-group">
                                    <input type="number" class="form-control ipt @error('diskon') is-invalid @enderror" id="diskon" name="diskon" value="0">
                                </div>
                                @error('diskon')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Harga Khusus</label>
                                <div class="input-group">
                                    <input type="number" class="form-control ipt @error('hrg_kh') is-invalid @enderror" id="hrg_kh" name="hrg_kh">
                                </div>
                                @error('hrg_kh')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Total</label>
                            <input type="text" name="vtotal" id="vtotal" class="form-control vtotal" readonly>
                            <input type="text" name="total" id="total" class="form-control" value="{{$total}}" hidden>
                            <input type="text" name="temp_total" id="temp_total" class="form-control" value="{{$total}}" hidden>
                        </div>
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
        // if($('.kons').length > 0) {
        //     $('.kons').select2({
        //         placeholder: "Pilih Konsumen Lama",
        //         allowClear: true
        //     });
        // }
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
            var total = $('#total').val();
            formatTotal(total);
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
            $('#add').on('change', function (event){
                let elem = event.target;
                if(elem.name === 'diskon' || elem.name === 'hrg_tmb'){
                    let temp = $('#temp_total').val() - 0;
                    let disk = $('#diskon').val() - 0;
                    let tmb = $('#hrg_tmb').val() - 0;
                    let total = $('#total').val() - 0;
                    if(disk == 0){
                        total = temp + tmb;
                        $('#total').val(total);
                        $('#vtotal').val(total);
                        formatTotal(total);
                    }else if(tmb == 0){
                        total = temp - disk;
                        $('#total').val(total);
                        $('#vtotal').val(total);
                        formatTotal(total);
                    }else if(disk == 0 && tmb == 0){
                        $('#total').val(temp);
                        $('#vtotal').val(temp);
                        formatTotal(temp);
                    }else{
                        total = temp + tmb - disk;
                        $('#total').val(total);
                        $('#vtotal').val(total);
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