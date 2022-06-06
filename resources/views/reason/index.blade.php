@extends('layouts.app')

@section('main')
<div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Reason</li>
            </ol>
        </nav>
        <h4 class="mg-b-0 tx-spacing--1">Manage Reason Return</h4>
    </div>
    <div class="d-none d-md-block">
        <button class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5" data-toggle="modal" data-target="#reason-form">
            <i data-feather="file" class="wd-10 mg-r-5"></i> Add Reason
        </button>
    </div>
</div>
<div>
    <reason-table url="{{ route('reason.data') }}"></reason-table>
</div>
@include('reason.form')
@endsection

@section('js')
<script>
    $('#reason-form').on('shown.bs.modal', function(e) {
        $('#reason').focus();
    })
</script>
@endsection