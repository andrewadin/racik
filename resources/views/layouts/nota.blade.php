@extends('layout.master')
@section('title') Nota Pesanan {{$nama}} Nomor {{$no_nota}}@endsection
@section('css')
<link rel="stylesheet" href="{{asset('assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}">
@endsection
@section('content')
<div id="main-content">
    <div class="container-fluid">
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
                                    <td>: {{$no_nota}}</td>
                                </tr>
                                <tr>
                                    <td>Nama</td>
                                    <td>: {{$nama}}</td>
                                </tr>
                                <tr>
                                    <td>Nomor HP</td>
                                    <td>: {{$no_hp}}</td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td>: {{$alamat}}</td>
                                </tr>
                                @for($i = 0; $i< count($pnm); $i++)
                                <tr>
                                    <td>Paket yang dipesan</td>
                                    <td>: {{$pnm[$i]}}</td>
                                </tr>
                                <tr>
                                    <td>Pengirimian</td>
                                    @if($ptp[$i] == 'Harian')
                                        <td><table id="tbl1" class="tbl table table-bordered brdr" style="text-align:center;">
                                            <thead>
                                                <th>Senin</th>
                                                <th>Selasa</th>
                                                <th>Rabu</th>
                                                <th>Kamis</th>
                                                <th>Jum'at</th>
                                                <th>Sabtu</th>
                                            </thead>
                                            <tbody>
                                                @if($pjl[$i] <= 6)
                                                <tr>
                                                    @for($j = 0; $j < count($arr_ps[$i]); $j++)
                                                        <td>
                                                            {{$arr_ps[$i][$j]}}
                                                        </td>
                                                    @endfor
                                                </tr>
                                                @else
                                                    @for($j = 0; $j < count($arr_ps[$i]); $j++)
                                                        <tr>
                                                            @for($k = 0; $k < count($arr_ps[$i][$j]); $k++)
                                                            <td>
                                                                {{$arr_ps[$i][$j][$k]}}
                                                            </td>
                                                            @endfor
                                                        </tr>
                                                    @endfor
                                                @endif
                                            </tbody>
                                        </table></td>
                                    @elseif($ptp[$i] == 'Mingguan')
                                    <td><table id="tbl1" class="tbl table table-bordered brdr" style="text-align:center;">
                                            <thead>
                                                <th>Senin</th>
                                                <th>Selasa</th>
                                                <th>Rabu</th>
                                                <th>Kamis</th>
                                                <th>Jum'at</th>
                                                <th>Sabtu</th>
                                            </thead>
                                            <tbody>
                                                @for($j = 0; $j < count($arr_ps[$i]); $j++)
                                                    <tr>
                                                        @for($k = 0; $k < count($arr_ps[$i][$j]); $k++)
                                                        <td>
                                                            {{$arr_ps[$i][$j][$k]}}
                                                        </td>
                                                        @endfor
                                                    </tr>
                                                @endfor
                                            </tbody>
                                        </table></td>
                                    @else
                                    <td>: {{$bln_jml}} Bulan</td>
                                    @endif
                                </tr>
                                <tr>
                                    <td>Waktu Pengiriman</td>
                                    <td>: {{$pwt[$i]}}</td>
                                </tr>
                                @if($arr_ct != [[]])
                                    @if($ptp[$i] == 'Harian')
                                    <tr>
                                        <td>Catatan</td>
                                        <td>
                                            <table id="tbl2" class="tbl table table-bordered brdr" style="text-align:center;">
                                                <thead>
                                                    <th>Senin</th>
                                                    <th>Selasa</th>
                                                    <th>Rabu</th>
                                                    <th>Kamis</th>
                                                    <th>Jum'at</th>
                                                    <th>Sabtu</th>
                                                </thead>
                                                <tbody>
                                                    @if($pjl[$i] <= 6)
                                                    <tr>
                                                        @for($j = 0; $j < count($arr_ps[$i]); $j++)
                                                            <td>
                                                                {{$arr_ct[$i][$j]}}
                                                            </td>
                                                        @endfor
                                                    </tr>
                                                    @else
                                                        @for($j = 0; $j < count($arr_ps[$i]); $j++)
                                                            <tr>
                                                                @for($k = 0; $k < count($arr_ps[$i][$j]); $k++)
                                                                <td>
                                                                    {{$arr_ct[$i][$j][$k]}}
                                                                </td>
                                                                @endfor
                                                            </tr>
                                                        @endfor
                                                    @endif
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    @elseif($ptp[$i] == 'Mingguan')
                                    <tr>
                                        <td>Catatan</td>
                                    <td><table id="tbl1" class="tbl table table-bordered brdr" style="text-align:center;">
                                        <thead>
                                            <th>Senin</th>
                                            <th>Selasa</th>
                                            <th>Rabu</th>
                                            <th>Kamis</th>
                                            <th>Jum'at</th>
                                            <th>Sabtu</th>
                                        </thead>
                                        <tbody>
                                            @for($j = 0; $j < count($arr_ct[$i]); $j++)
                                                <tr>
                                                    @for($k = 0; $k < count($arr_ct[$i][$j]); $k++)
                                                    <td>
                                                        {{$arr_ct[$i][$j][$k]}}
                                                    </td>
                                                    @endfor
                                                </tr>
                                            @endfor
                                        </tbody>
                                    </table></td>
                                    </tr>
                                    @endif
                                @endif
                                <tr>
                                    <td>Biaya</td>
                                    @if($ptp[$i] == 'Harian')
                                    <td>: <span>Rp. </span>{{number_format($phr[$i], 0, ',', '.')}} x {{$pjl[$i]}}</td>
                                    @elseif($ptp[$i] == 'Mingguan')
                                    <td>: <span>Rp. </span>{{number_format($phr[$i], 0, ',', '.')}} x {{$pjl[$i]/6}}</td>
                                    @else
                                    <td>: <span>Rp. </span>{{number_format($phr[$i], 0, ',', '.')}} x {{$bln_jml}}</td>
                                    @endif
                                </tr>
                                @endfor
                                <tr>
                                    <td>Tambahan</td>
                                    <td>: <span>Rp. </span>{{number_format($hrg_tmb, 0, ',', '.')}}</td>
                                </tr>
                                <tr>
                                    <td>Diskon</td>
                                    <td>: <span>Rp. </span>{{number_format($diskon, 0, ',', '.')}}</td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td>: <span>Rp. </span>{{number_format($total, 0, ',', '.')}}</td>
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
                    <button type="button" class="btn btn-primary " onclick="printNota()">Cetak Nota</button>
                    <a href="{{'/pesanan'}}" class="btn btn-secondary ">Kembali</a>
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
<script>
    function printNota(){
        var element = document.getElementById("bd");
        var table = document.getElementsByClassName("tbl");
        for (let i = 0; i < table.length; i++) {
            table[i].classList.remove("table-bordered");
            
        }
        element.classList.add("layout-fullwidth");
        window.print();
        element.classList.remove("layout-fullwidth");
        for (let i = 0; i < table.length; i++) {
            table[i].classList.add("table-bordered");
        }
    }
    // function printNt(){
    //     var element = document.getElementById("bd");
    //     element.classList.add("layout-fullwidth");
    //     window.print();
    //     element.classList.remove("layout-fullwidth");
    // }
</script>

@endpush