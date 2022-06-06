@extends('layouts.app')

@section('main')
<div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="#">Inventory</a></li>
                <li class="breadcrumb-item active" aria-current="page">Manual Rekapitulasi</li>
            </ol>
        </nav>
        <h4 class="mg-b-0 tx-spacing--1">Manual Rekapitulasi</h4>
    </div>
    <div class="d-none d-md-block">
        {{-- <button class="btn btn-sm pd-x-15 btn-white btn-uppercase"><i data-feather="mail" class="wd-10 mg-r-5"></i> Email</button> --}}
        {{-- <button class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5"><i data-feather="printer" class="wd-10 mg-r-5"></i> Print</button> --}}
        {{-- <button class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5"><i data-feather="file" class="wd-10 mg-r-5"></i> Report</button> --}}
    </div>
</div>

{{ Form::open() }}
<recap></recap>
{{ Form::close() }}
@endsection