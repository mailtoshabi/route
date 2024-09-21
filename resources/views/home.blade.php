@extends('layouts.master-without-nav')

@section('content')
<div class="container-fluid">


    <div class="row">
        <div class="col-xl-12" align="center">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Ecommerce Backend Application</h4>

                </div><!-- end card header -->

                <div class="card-body">
                    <div class="flex-wrap gap-3 align-items-center">
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg waves-effect waves-light" fdprocessedid="nru4yr">Admin Login</a>
                        <a href="{{ route('seller.login') }}" class="btn btn-success btn-lg waves-effect waves-light" fdprocessedid="ufybkj">Seller Login</a>
                        <a href="{{ route('seller.create') }}" class="btn btn-info btn-lg waves-effect waves-light" fdprocessedid="ed05mo">Seller Register</a>
                    </div>
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div>
</div>
@endsection
