@extends('dashboard_agency.layout.app')
@section('content')
    <div class="container">
        <h2 class="text-capitalize text-center">tạo mới đơn hàng</h2>
        <form id="orderForm" action="{{ route('agency_user.process_order_sim') }}" method="post">
            @csrf
            @method('POST')

            <select class="form-select text-capitalize" aria-label="Default select example" name="sim_type">
                <option selected>chọn loại sim</option>
                <option value="sim_thuong">sim thường</option>
                <option value="esim">eSim</option>
            </select>

            <div class="form-floating mt-3">
                <input type="number" class="form-control" id="quantity" placeholder="nhập số lượng sim ở đây"
                       name="quantity">
                <label for="quantity">số lượng sim</label>
            </div>

            <div class="form-floating mt-2">
                <textarea class="form-control" name="delivery_address" placeholder="nhập địa chỉ ở đây"
                          id="delivery_address" style="height: 100px"></textarea>
                <label for="delivery_address">địa chỉ giao hàng ở đây</label>
            </div>

            <div class="form-floating mt-3">
                <input type="text" class="form-control" id="contact_email" placeholder="nhập số email ở đây"
                       name="contact_email">
                <label for="contact_email">email</label>
            </div>

            <div class="form-floating mt-3">
                <input type="number" class="form-control" id="phone" placeholder="nhập số điện thoại ở đây ở đây"
                       name="phone">
                <label for="phone">số điện thoại</label>
            </div>

            <button class="btn btn-info text-capitalize text-center mt-2"  type="submit">tạo đơn hàng</button>
        </form>
@endsection
