@extends('layout.master')
@section('title') Data Konsumen @endsection
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
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Data Konsumen</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">Data Konsumen</li>
                            <li class="breadcrumb-item active">Data Konsumen</li>
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
                            <h2>Data Konsumen</h2><hr>                  
                        </div>
                        <div class="body">
                            @if(Auth::user()->role->nama_role == 'ADMIN')
                            <button type="button" class="btn btn-primary m-b-15" data-bs-toggle="modal" data-bs-target="#buatKelas">Tambah Konsumen</button>
                            @endif
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped" cellspacing="0" id="addrowExample">
                                <thead>
                                        <tr>
                                        <th>No</th>
                                            <th>Nama</th>
                                            <th>No. HP</th>
                                            <th>Alamat</th>
                                            <th>Edit/Hapus</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>No. HP</th>
                                            <th>Alamat</th>
                                            <th>Edit/Hapus</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php
                                        $i = 1;
                                        @endphp
                                        @foreach($konsumens as $kons)
                                        <tr>
                                            <td>{{$i}}</td>
                                            <td>{{$kons->nama}}</td>
                                            <td>{{$kons->no_hp}}</td>
                                            <td>
                                                <div class="cut-words">
                                                    {{$kons->alamat}}
                                                </div>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-icon btn-pure btn-default on-default m-r-5 button-edit" data-bs-toggle="modal" data-bs-target="#editKelas" onclick="editKelas({{ $kons->id }}, '{{ $kons->nama }}', '{{ $kons->no_hp }}',  '{{$kons->alamat}}')">
                                                    <i class="icon-pencil" aria-hidden="true"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-icon btn-pure btn-default on-default button-remove" data-bs-toggle="modal" data-bs-target="#hapusKelas" onclick="deleteKelas({{ $kons->id }}, '{{ $kons->nama }}')">
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
    <!-- input modal -->
    <div class="modal fade" id="buatKelas" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Konsumen</h5>
                </div>
                <div class="modal-body">
                    <h5 class="font-semibold text-xl text-gray-800 leading-tight">Masukkan Konsumen Baru</h5>
                    <form action="{{ '/konsumen' }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control ipt @error('nama') is-invalid @enderror" id="nama" name="nama" placeholder="Nama Konsumen">
                        @error('nama')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="no_hp">No. HP</label>
                        <input type="text" class="form-control ipt @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp" placeholder="No .HP">
                        @error('no_hp')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea name="summernote" id="summernote" class="form-control @error('summernote') is-invalid @enderror" placeholder="Alamat" style="height:200px;"></textarea>
                        @error('summernote')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- edit modal -->
    <div class="modal fade" id="editKelas" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Data Konsumen</h5>
                </div>
                <div class="modal-body">
                    <form action="{{ '/konsumen' }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                    <input type="text" class="form-control" id="edit_konsumen_id" name="edit_konsumen_id" value="" hidden>
                        <label for="edit_nama">Nama</label>
                        <input type="text" class="form-control ipt @error('edit_nama') is-invalid @enderror" id="edit_nama" name="edit_nama" value="">
                        @error('edit_nama')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="edit_nohp">No. HP</label>
                        <input type="text" class="form-control ipt @error('edit_nohp') is-invalid @enderror" id="edit_nohp" name="edit_nohp" value="">
                        @error('edit_nohp')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="edit_lingkar">Alamat</label>
                        <textarea name="edit_summernote" id="edit_summernote" class="form-control @error('edit_summernote') is-invalid @enderror" style="height:200px;" value=""></textarea>
                        @error('edit_summernote')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-success">Perbarui</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- delete modal -->
    <div class="modal fade" id="hapusKelas" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Hapus Konsumen</h5>
                </div>
                <div class="modal-body">
                    <form action="{{ '/konsumen' }}" method="post">
                    @csrf
                    @method('DELETE')
                    <div class="form-group">
                    <input type="hidden" id="delete_id" name="delete_id" value="">
                        <label for="">Apa anda yakin ingin menghapus konsumen <span id="delete_nama"></span>?</label>
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
    function editKelas($id, $nama, $nohp, $alamat) {
            $('#edit_nama').val($nama)
            $('#edit_konsumen_id').val($id)
            $('#edit_nohp').val($nohp)
            $('#edit_summernote').val($alamat)
        }
        function deleteKelas($id, $name) {
            $('#delete_nama').html($name)
            $('#delete_id').val($id)
        }
</script>
<script>
    $(document).ready(function() {
        var table = $('#addrowExample').DataTable( {
        dom: 'lBfrtip',
        "bDestroy": true,
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