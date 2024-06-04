@extends('layout.master')
@section('title') Nota Pesanan {{$nama}} Nomor {{$no_nota}}@endsection
@section('css')
<link rel="stylesheet" href="{{asset('assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}">
@endsection
@section('content')
<div id="main-content">
    <div class="container-fluidpage-screen">
        <div class="block-header page-screen">
            <div class="row">
                <div class="col-lg-6 col-md-8 col-sm-12">
                <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Pesanan Catering</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="icon-home"></i></a></li>                            
                        <li class="breadcrumb-item">Data Pesanan</li>
                        <li class="breadcrumb-item active">Pesanan {{$no_nota}}</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12">
                @foreach($pesanan as $pes)
                <div class="card page-print ftsz">
                    <div class="header">
                        <span><img src="{{asset('assets/images/logo_racik.jpg')}}" alt="Pesanan Catering {{$no_nota}}" style="width:15%;height:15%;"></span>
                        <h3 style="text-align:center;" class="ftsz">Nota Pemesanan</h3>                       
                    </div>
                    <div class="body">
                        <table>
                            <thead>
                                <th></th>
                                <th></th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Nomor Nota</td>
                                    <td>: {{$pes->no_nota}}</td>
                                </tr>
                                <tr>
                                    <td>Nama</td>
                                    <td>: {{$pes->konsumen->nama}}</td>
                                </tr>
                                <tr>
                                    <td>Nomor HP</td>
                                    <td>: {{$pes->konsumen->no_hp}}</td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td>: {{$pes->konsumen->alamat}}</td>
                                </tr>
                                <tr>
                                    <td>Paket yang dipesan</td>
                                    <td>: {{$pes->paket->nama_paket}}</td>
                                </tr>
                                <tr>
                                    <td>Pengirimian</td>
                                    @if($tipe != 'Bulanan')
                                    <td><table id="tbl" class="table table-bordered brdr" style="text-align:center;">
                                        <thead>
                                            <th>Senin</th>
                                            <th>Selasa</th>
                                            <th>Rabu</th>
                                            <th>Kamis</th>
                                            <th>Jum'at</th>
                                            <th>Sabtu</th>
                                        </thead>
                                        <tbody>
                                            <tr>
                                            @foreach($arr_pes as $aps)
                                                <td>
                                                    {{$aps}}
                                                </td>
                                            @endforeach
                                            </tr>
                                        </tbody>
                                    </table></td>
                                    @else
                                    <td>: Bulan {{$pes->tgl_kirim[0]["tgl_kirim"]->isoFormat('MMMM')}} (1 Bulan)</td>
                                    @endif
                                </tr>
                                <tr>
                                    <td>Waktu Pengiriman</td>
                                    <td>: {{$pes->waktu->waktu}}</td>
                                </tr>
                                <tr>
                                    <td>Catatan</td>
                                    <td>: 
                                        @if($pes->catatan != NULL)
                                        {{$pes->catatan}}
                                        @else
                                        -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Biaya</td>
                                    @if($tipe != 'Bulanan')
                                    <td>: <span>Rp. </span>{{number_format($pes->paket->harga, 0, ',', '.')}} x {{count($pes->tgl_kirim)}}</td>
                                    @else
                                    <td>: <span>Rp. </span>{{number_format($pes->total, 0, ',', '.')}}<span> (1 Bulan)</span></td>
                                    @endif
                                </tr>
                                <tr>
                                    <td>Tambahan</td>
                                    <td>: <span>Rp. </span>{{number_format($pes->harga_tambahan, 0, ',', '.')}}</td>
                                </tr>
                                <tr>
                                    <td>Diskon</td>
                                    <td>: {{$pes->diskon}}<span>%</span></td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td>: <span>Rp. </span>{{number_format($pes->total, 0, ',', '.')}}</td>
                                </tr>
                                <tr>
                                    <td>Nomor Admin</td>
                                    <td>: {{$no_admin}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="form-group col-lg-12 page-screen">
                    @if($tipe != 'Bulanan')
                    <button type="button" class="btn btn-primary " onclick="printNota()">Cetak Nota</button>
                    @else
                    <button type="button" class="btn btn-primary " onclick="printNt()">Cetak Nota</button>
                    @endif
                    <a href="{{'/pesanan'}}" class="btn btn-secondary ">Kembali</a>
                </div>
                @endforeach
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
<script>
    function printNota(){
        var element = document.getElementById("bd");
        var table = document.getElementById("tbl");
        table.classList.remove("table-bordered");
        element.classList.add("layout-fullwidth");
        window.print();
        element.classList.remove("layout-fullwidth");
        table.classList.add("table-bordered");
    }
    function printNt(){
        var element = document.getElementById("bd");
        element.classList.add("layout-fullwidth");
        window.print();
        element.classList.remove("layout-fullwidth");
    }
</script>

@endpush