@extends('layouts.app')

@section('main')
<div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Product</li>
            </ol>
        </nav>
        <h4 class="mg-b-0 tx-spacing--1">Manage Product</h4>
    </div>
    <div class="d-none d-md-block">
        <a href="{{ route('product.download', ['time' => time()]) }}" class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5">
            <i data-feather="download" class="wd-10 mg-r-5"></i> Export
        </a>
        <button class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5" data-toggle="modal" data-target="#product-form">
            <i data-feather="file" class="wd-10 mg-r-5"></i> Add Product
        </button>
    </div>
</div>
<div>
    <product-table url="{{ route('product.data') }}"></product-table>
</div>
@include('product.from')
@endsection

@section('js')
<script>
    $('#product-form').on('shown.bs.modal', function(e) {
        $('#gtin').focus();
    })
</script>
@endsection