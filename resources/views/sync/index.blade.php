@extends('layouts.app')

@section('main')
<div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Sync Logger</li>
            </ol>
        </nav>
        <h4 class="mg-b-0 tx-spacing--1">Synchronize System</h4>
    </div>
    {{-- <div class="d-none d-md-block">
        <button class="btn btn-sm pd-x-15 btn-white btn-uppercase"><i data-feather="mail" class="wd-10 mg-r-5"></i> Email</button>
        <button class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5"><i data-feather="printer" class="wd-10 mg-r-5"></i> Print</button>
        <button class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5"><i data-feather="file" class="wd-10 mg-r-5"></i> Generate Report</button>
    </div> --}}
</div>

<div class="row row-xs">
    <div class="col-12">
        <div class="alert alert-warning">
            Sinkronisasi sistem ke SAP akan secara otomatis tersinkron jam 07.00 WIB, anda bisa melihat status sinkron pada tabel di bawah ini, jika status FAILED anda bisa melakunan RESYNC pada tombol di bawah.
            <br> Anda juga bisa mesinkron secara manual dengan tombol di bawah ini, dengan menentukan tanggal data yang akan di sinkron.
        </div>
    </div>
    <div class="col-12">
        <sync-log url="{{ route('sync.log') }}"></sync-log>
    </div>
</div><!-- row -->
@endsection