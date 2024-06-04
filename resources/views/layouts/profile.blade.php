@extends('layout.master')
@section('title') Profile @endsection
@section('css')
<link rel="stylesheet" href="{{asset('assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}">
@endsection
@section('content')
<div id="main-content" class="profilepage_2 blog-page">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> User Profile</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item">Pages</li>
                            <li class="breadcrumb-item active">User Profile</li>
                        </ul>
                    </div>   
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-lg-4 col-md-12">
                    <div class="card profile-header">
                        <div class="body">
                            <div>
                                <h4 class="m-b-0"><strong>{{ Auth::user()->name }}</strong></h4>
                                <span>{{ Auth::user()->role->nama_role }}</span>
                            </div>                          
                        </div>
                    </div>
                    <div class="card">
                        <div class="header">
                            <h2>Info</h2>
                        </div>
                        <div class="body">
                            <small class="text-muted">Username: </small>
                            <p>{{ Auth::user()->username }}</p>                            
                            <hr>
                            <small class="text-muted">No HP: </small>
                            <p>{{ Auth::user()->no_hp }}</p>                            
                            <hr>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-12">
                    <div class="tab-content padding-0">
                            <div class="card">
                                <div class="body">
                                    <h6>Edit Data</h6>
                                    <div class="row clearfix">
                                        <div class="col-lg-12 col-md-12">
                                            <form action="{{ '/profile' }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group">
                                                <label for="">Nama</label>                                               
                                                <input type="text" class="form-control" id="edit_name" name="edit_name" placeholder="Nama Lengkap" value="{{ old('name', Auth::user()->name) }}">
                                            </div>
                                            <div class="form-group"> 
                                                <label for="">Username</label>                                               
                                                <input type="text" class="form-control" id="edit_username" name="edit_username" placeholder="Username" value="{{ old('email', Auth::user()->username) }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="">No HP</label>                                                
                                                <input type="text" class="form-control" id="edit_nohp" name="edit_nohp" placeholder="No HP" value="{{ old('email', Auth::user()->no_hp) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    </form>
                                </div>
                            </div>
                            <div class="card">
                                <div class="body">
                                    <div class="row clearfix">
                                        <div class="col-lg-12 col-md-12">
                                            <h6>Ganti Password</h6>
                                            <form action="{{ '/profile/ganti-password' }}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group">
                                                <input id="password_lama" name="password_lama" type="password" class="form-control" placeholder="Password Lama">
                                            </div>
                                            <div class="form-group">
                                                <input id="password_baru" name="password_baru" type="password" class="form-control" placeholder="Password Baru">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    </form>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script src="{{asset('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script>
    var msg = '{{Session::get('alert')}}';
    var exist = '{{Session::has('alert')}}';
    if(exist){
        alert(msg);
    }
</script>
@endpush