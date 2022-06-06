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
        <a data-toggle="modal" data-target="#ng-form" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5"><i class="fa-solid fa-file-excel wd-10 mg-r-5"></i> Add Rejected Product</a>
    </div>
</div>
<div class="row row-xs">
    <div class="col">
        <div class="d-flex align-items-center justify-content-between">
            <div class="product-info row half">
                <div class="col-12 search-form ">
                    <div class="form-group w-full mb-0">
                        <label class="d-block h-40">Barcode (SKU)</label>
                        <div class="input-group mg-b-10">
                            <input type="text" ref="gtin" class="form-control" name="gtin" value="{{ $report->product->gtin }}" readonly>
                            <div class="input-group-append">
                                <button class="btn btn-outline-light" type="button"><i class="fa-solid fa-barcode"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group w-full mb-2">
                        <!-- <label class="d-block h-40">Product Name</label> -->
                        <input type="text" class="form-control"  value="{{ $report->product->name }} ({{ $report->product->varian_pack }})" readonly>
                    </div>
                </div>
                <div class="col-12">
                    <div class="input-group mg-b-10">
                        <div class="input-group-prepend">
                            <span class="input-group-text w-150">TOTAL SCAN PACK</span>
                        </div>
                        <input type="text" class="form-control" readonly value="{{ $report->qty }}" name="date">
                    </div>
                </div>
            </div>
            <div class="rpp half">
                <div class="input-group mg-b-10 mt-4">
                    <div class="input-group-prepend">
                        <span class="input-group-text w-120">DATE</span>
                    </div>
                    <input type="text" class="form-control" readonly value="{{ $report->schedule->from->format('d M Y') }}" name="date">
                </div>
                <div class="input-group mg-b-10">
                    <div class="input-group-prepend">
                        <span class="input-group-text w-120">SHIFT</span>
                    </div>
                    <input type="text" class="form-control" readonly value="{{ $report->schedule->shift->name }}" name="date">
                </div>
                <div class="input-group mg-b-10">
                    <div class="input-group-prepend">
                        <span class="input-group-text w-150">TOTAL FINISED GOODS</span>
                    </div>
                    <input type="text" class="form-control" readonly value="{{ $report->total }}" name="date">
                </div>
            </div>
        </div>
    </div>
</div><!-- row -->
<div>
    <recap-table :rows="{{ json_encode($pallets) }}"></recap-table>
</div>

@include('ng.form')
@endsection

@section('js')
<script>
    $('#ng-form').on('shown.bs.modal', function(e) {
        $('#qty').focus();
    })
</script>
@endsection