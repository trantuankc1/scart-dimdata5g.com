@extends('dashboard_agency.layout.app')
@section('content')

    <div class="container text-center page-breadcrumb text-capitalize">
        <h3>Thống Kê</h3>

        <div class="row">
            <div class="col box-total">
                <h3 class="fw-bold">tổng kết doanh thu</h3>
                <div class="total">
                    <span class="fw-bold"><i class="mdi mdi-cash"></i>  doanh số </span>
                    <p>{{ optional($agencyUserEarning)->total_profit ? number_format($agencyUserEarning->total_profit) : 'N/A' }}</p>
                </div>
                <div class="total">
                    <span class="fw-bold"><i class="mdi mdi-cash"></i>  lợi nhuận</span>
                    <p>{{ optional($agencyUserEarning)->total_profit ? number_format($agencyUserEarning->total_profit) : 'N/A' }}</p>


                </div>
            </div>
            <div class="col box-total-money-by-month">
                <h3 class="fw-bold">doanh thu tháng này</h3>
                <p class="fw-bold"><i class="mdi mdi-cash"></i> tổng doanh thu theo tháng này</p>
                <p>{{ optional($agencyUserEarning)->total_profit ? number_format($agencyUserEarning->total_profit) : 'N/A' }}</p>
            </div>
        </div>
        <div class="link mt-5">
            <a class="btn btn-info" id="copyLink"
               href="{{ route('redirect.from.agency', ['agencyUuid' => $agencyUsers->id]) }}"><i
                        class="mdi mdi-content-copy"></i> Link bán hàng của bạn</a>
        </div>
    </div>
    <style>
        .box-total {
            background-color: white;
        }

        .box-total-money-by-month {
            margin-left: 10px;
            background-color: white;
        }
    </style>
    <script>
        document.getElementById('copyLink').addEventListener('click', function (event) {
            // Ngăn chặn hành động mặc định của thẻ <a> (mở liên kết)
            event.preventDefault();

            // Tạo một thẻ input tạm thời để chứa đường link
            var tempInput = document.createElement("input");
            tempInput.style = "position: absolute; left: -1000px; top: -1000px";
            tempInput.value = this.href;
            document.body.appendChild(tempInput);

            // Chọn nội dung của thẻ input và sao chép nó
            tempInput.select();
            document.execCommand("copy");

            // Loại bỏ thẻ input tạm thời
            document.body.removeChild(tempInput);

            // Thông báo đã sao chép thành công
            alert("Đã sao chép liên kết: " + this.href);
        });
    </script>
@endsection

