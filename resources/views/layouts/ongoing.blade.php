@extends('layout.master')
@section('title') Pesanan Catering @endsection
@section('css')

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="{{asset('assets/vendor/sweetalert/sweetalert.css')}}"/>

<style>
    td.details-control {
    background: url("{{asset('assets/images/details_open.png')}}") no-repeat center center;
    cursor: pointer;
}
    tr.shown td.details-control {
        background: url("{{asset('assets/images/details_close.png')}}") no-repeat center center;
    }
    .cut-words{
        width: 200px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
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
                            <li class="breadcrumb-item">Catering</li>
                            <li class="breadcrumb-item active">Pesanan Hari Ini</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                @foreach($tgls as $tgl)
                @if($tgl->pesanan != NULL)
                <div class="col-4 col-md-4 bold-brd">
                    <div class="card">
                        <div class="header">
                            @if($tgl->pesanan->waktu->waktu == 'Lunch')
                            <svg viewBox="0 0 224 224" width="50" height="50">
                                <rect width="200" height="200" fill="yellow"/>
                                <text x="100" y="100" font-size="10em" dominant-baseline="middle" text-anchor="middle">L</text>
                            </svg>
                            @else
                            <svg viewBox="0 0 224 224" width="50" height="50">
                                <rect width="200" height="200" fill="cyan"/>
                                <text x="50%" y="50%" font-size="10em"  dominant-baseline="middle" text-anchor="middle">D</text>
                            </svg>
                            @endif
                            <!-- <svg class="inln" viewBox="0 0 20 20" width="100%" height="50"><text x="50%" y="50%" font-size="1em"  dominant-baseline="middle" text-anchor="middle">{{$tgl->pesanan->konsumen->nama}}</text></svg>
                            <hr> -->
                            <h4 class="cntr">{{$tgl->pesanan->konsumen->nama}}</h4>
                            <h5 class="cntr">{{$tgl->pesanan->konsumen->no_hp}}</h5>
                        </div>
                        <div class="body">
                        <p class="cntr font-lg">{{$tgl->pesanan->konsumen->alamat}}</p>
                            <table>
                                <thead>
                                    <th></th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="font-lg">Pesanan</td>
                                        <td class="font-lg">: {{$tgl->pesanan->paket->nama_paket}}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-lg">Request</td>
                                        <td class="font-lg">: {{$tgl->pesanan->catatan}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
            <button type="button" class="btn btn-primary page-screen" onclick="printNota()">Cetak Daftar</button>
        </div>
    </div>
@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
<script src="{{asset('assets/vendor/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/vendor/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/vendor/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/vendor/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/vendor/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<script src="{{asset('assets/vendor/sweetalert/sweetalert.min.js')}}"></script> 
<script>
    function printNota(){
        var element = document.getElementById("bd");
        element.classList.add("layout-fullwidth");
        window.print();
        element.classList.remove("layout-fullwidth");
    }
</script>
<script>
    var msg = '{{Session::get('alert')}}';
    var exist = '{{Session::has('alert')}}';
    if(exist){
        alert(msg);
    }
</script>
@endpush