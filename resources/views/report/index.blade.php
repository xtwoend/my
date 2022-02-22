@extends('layouts.app')

@section('main')
<div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Rekapitulasi</li>
            </ol>
        </nav>
        <h4 class="mg-b-0 tx-spacing--1">Rekapitulasi</h4>
    </div>
    <div class="d-none d-md-block">
        <report-print url="{{ route('report.print', ['date' => $date]) }}"></report-print>
        <a href="{{ route('report.download', ['date' => $date, 'time' => time()]) }}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5"><i class="fa-solid fa-file-excel wd-10 mg-r-5"></i> Download</a>
    </div>
</div>
<div class="d-flex align-items-center justify-content-between mb-2">
    <div></div>
    <div>
        <form method="GET">
        <div class="input-group">
            <datepicker value="{{ $date }}" name="date" input-class="form-control"></datepicker>
            <div class="input-group-append">
                <button class="btn btn-outline-light" type="button"><i data-feather="calendar"></i></button>
                <button class="btn btn-outline-light" type="submit"><i data-feather="search"></i></button>
            </div>
        </div>
        </form>
    </div>
</div>
<div class="row row-xs">
    <div class="col">
        <report-table url="{{ route('report.data', ['date' => $date]) }}"></report-table>
    </div>
</div>
@endsection