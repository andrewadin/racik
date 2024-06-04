@extends('layout.master')
@section('title') Data User @endsection
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
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Data User</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">Data User</li>
                            <li class="breadcrumb-item active">Data User</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>Data User</h2><hr>                  
                        </div>
                        <div class="body">
                            @if(Auth::user()->role->nama_role == 'ADMIN')
                            <button type="button" class="btn btn-primary m-b-15" data-bs-toggle="modal" data-bs-target="#buatKelas">Tambah User</button>
                            @endif
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped" cellspacing="0" id="addrowExample">
                                <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Username</th>
                                            <th>No. HP</th>
                                            <th>Role</th>
                                            <th>Edit/Hapus</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                        <th>No</th>
                                            <th>Nama</th>
                                            <th>Username</th>
                                            <th>No. HP</th>
                                            <th>Role</th>
                                            <th>Edit/Hapus</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        
                                        @php
                                        $i = 1;
                                        @endphp
                                        @foreach($users as $usr)
                                        @if($usr->role != NULL)
                                        <tr>
                                            <td>{{$i}}</td>
                                            <td>{{$usr->name}}</td>
                                            <td>{{$usr->username}}</td>
                                            <td>{{$usr->no_hp}}</td>
                                            <td>{{$usr->role->nama_role}}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-icon btn-pure btn-default on-default m-r-5 button-edit" data-bs-toggle="modal" data-bs-target="#editKelas" onclick="editKelas({{ $usr->id }}, '{{ $usr->name }}', '{{ $usr->username }}', '{{ $usr->no_hp }}', {{$usr->role->id}})">
                                                    <i class="icon-pencil" aria-hidden="true"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-icon btn-pure btn-default on-default button-remove" data-bs-toggle="modal" data-bs-target="#hapusKelas" onclick="deleteKelas({{ $usr->id }}, '{{ $usr->name }}')">
                                                    <i class="icon-trash" aria-hidden="true"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endif
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
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah User</h5>
                </div>
                <div class="modal-body">
                    <form action="{{ '/user' }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control ipt @error('nama') is-invalid @enderror" id="nama" name="nama" placeholder="Nama User">
                        @error('nama')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control ipt @error('username') is-invalid @enderror" id="username" name="username" placeholder="Username">
                        @error('username')
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
                        <label for="role">Role User</label>
                        <select class="form-control ipt paket @error('role') is-invalid @enderror" name="role" id="role">
                            <option selected disabled>Pilih Role</option>
                            @foreach($roles as $role)
                            <option value="{{$role->id}}">{{$role->nama_role}}</option>
                            @endforeach
                        </select>
                        @error('role')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control ipt @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password">
                        @error('password')
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
                    <h5 class="modal-title" id="staticBackdropLabel">Edit User</h5>
                </div>
                <div class="modal-body">
                    <form action="{{ '/user' }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="edit_nama">Nama</label>
                        <input type="text" name="edit_id" id="edit_id" hidden>
                        <input type="text" class="form-control ipt @error('edit_nama') is-invalid @enderror" id="edit_nama" name="edit_nama" placeholder="Nama User">
                        @error('edit_nama')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="edit_username">Username</label>
                        <input type="text" class="form-control ipt @error('edit_username') is-invalid @enderror" id="edit_username" name="edit_username" placeholder="Username">
                        @error('edit_username')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="edit_nohp">No. HP</label>
                        <input type="text" class="form-control ipt @error('edit_nohp') is-invalid @enderror" id="edit_nohp" name="edit_nohp" placeholder="No .HP">
                        @error('edit_nohp')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="edit_role">Role User</label>
                        <select class="form-control ipt paket @error('edit_role') is-invalid @enderror" name="edit_role" id="edit_role">
                            <option  id="opsi_kml" selected readonly>Pilih Role</option>
                            @foreach($roles as $role)
                            <option value="{{$role->id}}">{{$role->nama_role}}</option>
                            @endforeach
                        </select>
                        @error('edit_role')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="edit_password">Password</label>
                        <input type="password" class="form-control ipt @error('edit_password') is-invalid @enderror" id="edit_password" name="edit_password" placeholder="Password">
                        @error('edit_password')
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
    <!-- delete modal -->
    <div class="modal fade" id="hapusKelas" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Hapus User</h5>
                </div>
                <div class="modal-body">
                    <form action="{{ '/user' }}" method="post">
                    @csrf
                    @method('DELETE')
                    <div class="form-group">
                    <input type="hidden" id="delete_id" name="delete_id" value="">
                        <label for="">Apa anda yakin ingin menghapus user <span id="delete_nama"></span>?</label>
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
    function editKelas($id, $nama, $username, $nohp, $rlid) {
            $('#edit_id').val($id);
            $('#edit_nama').val($nama);
            $('#edit_username').val($username);
            $('#edit_nohp').val($nohp);
            $('#edit_role').val($rlid);
        }
        function deleteKelas($id, $name) {
            $('#delete_nama').html($name)
            $('#delete_id').val($id)
        }
</script>
<script>
    $(document).ready(function() {
        $('#edit_role').on('change', function(){
            console.log($('#edit_role').val());
        });
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