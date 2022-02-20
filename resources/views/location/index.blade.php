@extends('layouts.app')

@section('main')
<div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Location</li>
            </ol>
        </nav>
        <h4 class="mg-b-0 tx-spacing--1">Manage Warehouse Location</h4>
    </div>
    <div class="d-none d-md-block">
        <button class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5" data-toggle="modal" data-target="#location-form">
            <i data-feather="file" class="wd-10 mg-r-5"></i> Add Location
        </button>
    </div>
</div>
<div>
    <location-table url="{{ route('location.data') }}"></location-table>
</div>
@include('location.from')
@endsection

@section('js')
<script>
    $('#location-form').on('shown.bs.modal', function(e) {
        $('#gln').focus();
    })
</script>
@endsection