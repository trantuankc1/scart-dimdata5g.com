@php
/*
$layout_page = shop_order_success
**Variables:**
- $orderInfo
*/
@endphp

@extends($sc_templatePath.'.layout')

@section('block_main_content_center')
<h6 class="aside-title">{{ $title }}</h6>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="title-page">{{ $title }}</h2>
        </div>
        <div class="col-md-12 text-success">
            <h2>{{ sc_language_render('checkout.order_success_msg') }}</h2>
            <h3>{{ sc_language_render('checkout.order_success_order_info', ['order_id'=>session('orderID')]) }}</h3>
        </div>
        <div class="mt-2">
            <h3>Qr Code</h3>
            <img src="{{ asset('storage/' . $qr->image_qr_code) }}" alt="">
        </div>
       
    </div>
</div>
@endsection


@push('styles')
{{-- Your css style --}}
@endpush

@push('scripts')
{{-- //script here --}}
@endpush
