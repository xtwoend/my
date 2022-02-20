@extends('layouts.app')

@section('main')
<div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Schedule</li>
            </ol>
        </nav>
        <h4 class="mg-b-0 tx-spacing--1">Schedule</h4>
    </div>
    <div class="d-none d-md-block">
        <button class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5" data-toggle="modal" data-target="#shift-form">
            <i data-feather="file" class="wd-10 mg-r-5"></i>Generate
        </button>
    </div>
</div>
<div>
    <schedule-table url="{{ route('schedule.data') }}" ref="table"></schedule-table>
    {{-- <shift-modal ref="shiftModal" id="shift-form" url="{{ route('shift.store') }}" @reload="$refs.table.$refs.vuetable.reload()"></shift-modal> --}}
</div>
@endsection

@section('js')

@endsection