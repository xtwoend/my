@extends('layouts.app')

@section('main')
<div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Shift</li>
            </ol>
        </nav>
        <h4 class="mg-b-0 tx-spacing--1">Shift Time</h4>
    </div>
    <div class="d-none d-md-block">
        <button class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5" data-toggle="modal" data-target="#shift-form">
            <i data-feather="file" class="wd-10 mg-r-5"></i> Add Shift
        </button>
    </div>
</div>
<div>
    <shift-table url="{{ route('shift.data') }}" ref="table"></shift-table>
    <shift-form ref="shiftModal" id="shift-form" url="{{ route('shift.store') }}" @reload="$refs.table.$refs.vuetable.reload()"></shift-form>
</div>
@endsection

@section('js')

@endsection