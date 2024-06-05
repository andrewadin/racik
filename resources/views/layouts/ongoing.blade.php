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
                <br>
                <button type="button" class="btn btn-primary page-screen" onclick="printNota()">Cetak Daftar</button>
            </div>
            <div class="row">
                @for($i = 0;$i < count($tgls); $i++)
                @if($tgls[$i]->pesanan != NULL)
                <div class="col-4 col-sm-4 bold-brd crd">
                    <div id="crd">
                        <div class="body">
                        <div class="parent">
                            <div class="left">
                                @if($tgls[$i]->pesanan->waktu->waktu == 'Lunch')
                                <svg viewBox="0 0 10 10" class="inln" width="25" height="25">
                                    <rect width="50" height="50" fill="yellow"/>
                                    <text x="50%" y="50%" font-size=".5em" dominant-baseline="middle" text-anchor="middle">L</text>
                                </svg>
                                @else
                                <svg x="0" y="0" viewBox="0 0 10 10" class="inln" width="25" height="25">
                                    <rect width="50" height="50" fill="cyan"/>
                                    <text x="50%" y="50%" font-size=".5em"  dominant-baseline="middle" text-anchor="middle">D</text>
                                </svg>
                                @endif
                            </div>
                            <div class="center"><h5>{{$tgls[$i]->pesanan->konsumen->nama}}</h5></div>
                            <div class="right"></div>
                        </div>
                            <h5 class="cntr">{{$tgls[$i]->pesanan->konsumen->no_hp}}</h5>
                            <p class="cntr font-lg">{{$tgls[$i]->pesanan->konsumen->alamat}}</p>
                            <p class="font-lg">Pesanan : {{$tgls[$i]->pesanan->paket->nama_paket}}</p>
                            <p class="font-lg">Request : {{$tgls[$i]->pesanan->catatan}}</p>
                        </div>
                    </div>
                </div>
                @endif
                @endfor
            </div>
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