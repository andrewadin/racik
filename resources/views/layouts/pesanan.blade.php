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
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Pesanan Catering</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">Catering</li>
                            <li class="breadcrumb-item active">Pesanan</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            @if(session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                            @endif
                            <h2>Data Pesanan Catering</h2><hr>                  
                        </div>
                        <div class="body">
                            @if(Auth::user()->role->nama_role == 'ADMIN')
                            <a class="btn btn-primary m-b-15" href="{{ '/pesanan/baru' }}">Pesanan Baru</a>
                            @endif
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped" cellspacing="0" id="addrowExample">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No Nota</th>
                                            <th>Nama Konsumen</th>
                                            <th>Nama Paket</th>
                                            <th>Waktu Makan</th>
                                            <th>Alamat</th>
                                            <th>Catatan</th>
                                            <th>Diskon</th>
                                            <th>Harga Tambahan</th>
                                            <th>Total Harga</th>
                                            <th>Edit/Hapus</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>No Nota</th>
                                            <th>Nama Konsumen</th>
                                            <th>Nama Paket</th>
                                            <th>Waktu Makan</th>
                                            <th>Alamat</th>
                                            <th>Catatan</th>
                                            <th>Diskon</th>
                                            <th>Harga Tambahan</th>
                                            <th>Total Harga</th>
                                            <th>Edit/Hapus</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php
                                        $i = 1;
                                        @endphp
                                        @foreach($pesanan as $pes)
                                        <tr>
                                            <td>{{$i}}</td>
                                            <td>{{$pes->no_nota}}</td>
                                            <td>{{$pes->konsumen->nama}}</td>
                                            <td>{{$pes->paket->nama_paket}}</td>
                                            <td>{{$pes->waktu->waktu}}</td>
                                            <td>
                                                <div class="cut-words">
                                                    {{$pes->konsumen->alamat}}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="cut-words">
                                                    @if($pes->catatan == NULL)
                                                    -
                                                    @else
                                                    {{$pes->catatan}}
                                                    @endif
                                                </div>
                                            </td>
                                            <td>Rp. </span>{{number_format($pes->diskon), 3, '.'}}</td>
                                            <td><span>Rp. </span>{{number_format($pes->harga_tambahan), 3, '.'}}</td>
                                            <td><span>Rp. </span>{{number_format($pes->total), 3, '.'}}</td>
                                            <td>
                                                <a href="{{'/nota/'. $pes->no_nota}}" class="btn btn-sm btn-icon btn-pure btn-default"><i class="icon-eye" aria-hidden="true"></i></a>
                                                <a href="{{'/pesanan/'. $pes->no_nota}}" class="btn btn-sm btn-icon btn-pure btn-default"><i class="icon-pencil" aria-hidden="true"></i></a>                                              
                                                <button type="button" class="btn btn-sm btn-icon btn-pure btn-default on-default button-remove" data-bs-toggle="modal" data-bs-target="#hapusKelas" onclick="deleteKelas({{$i}}, {{ $pes->id }}, '{{ $pes->konsumen->nama }}')">
                                                    <i class="icon-trash" aria-hidden="true"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @php
                                        $i++;
                                        @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- delete modal -->
    <div class="modal fade" id="hapusKelas" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Hapus Paket</h5>
                </div>
                <div class="modal-body">
                    <form action="{{ '/pesanan' }}" method="post">
                    @csrf
                    @method('DELETE')
                    <div class="form-group">
                    <input type="hidden" id="delete_id" name="delete_id" value="">
                        <label for="">Apa anda yakin ingin menghapus pesanan nomor <span id="delete_no"></span>, atas nama <span id="delete_nama"></span>?</label>
                        @error('delete_nama')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </form>
                </div>
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
    function deleteKelas($x, $id, $name) {
        $('#delete_no').html($x)
        $('#delete_nama').html($name)
        $('#delete_id').val($id)
    }
</script>
<script>
    $(document).ready(function() {
        var table = $('#addrowExample').DataTable( {
        dom: 'lBfrtip',
        buttons: [
            {
                extend: 'copy',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            },
            {
                extend: 'csv',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            },
            {
                extend: 'excel',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            },
            {
                extend: 'pdf',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            },
        ]
    } );
    });
</script>
<script>
    var msg = '{{Session::get('alert')}}';
    var exist = '{{Session::has('alert')}}';
    if(exist){
        alert(msg);
    }
</script>
@endpush