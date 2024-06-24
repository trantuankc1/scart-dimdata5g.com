<style>
    .sepay {
        font-family: Arial, sans-serif;
        color: #333;
        background: #f9f9f9;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        max-width: 750px;
        margin: auto;
    }

    .sepay h3 {
        color: #d9534f;
        font-size: 20px;
    }

    .sepay .fob-qr-intro {
        font-size: 18px;
        font-weight: 600;
        color: #0275d8;
        margin-bottom: 15px;
        text-align: center;
    }

    .sepay .fob-qr-code {
        text-align: center;
        margin-bottom: 40px;
    }

    .sepay .fob-qr-code img {
        width: 250px;
        height: auto;
        margin: 0;
        padding: 0;
        border: 2px solid #0275d8;
        border-radius: 8px;
    }

    .sepay .fob-qr-code figcaption {
        margin-top: 10px;
        font-size: 14px;
        color: #666;
    }

    .sepay .fob-qr-information {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .sepay .fob-qr-information table {
        width: 100%;
        border-collapse: collapse;
    }

    .sepay .fob-qr-information td {
        padding: 10px;
        border-bottom: 1px solid #eee;
    }

    .sepay .fob-qr-information td:first-child {
        font-weight: 600;
        color: #555;
    }

    .sepay .fob-qr-information td:last-child {
        text-align: right;
    }

    .sepay .fob-qr-information a {
        color: #0275d8;
        text-decoration: none;
    }

    .sepay .fob-qr-information a:hover {
        text-decoration: underline;
    }

    .sepay .alert {
        background: #fff3cd;
        border: 1px solid #ffeeba;
        border-radius: 8px;
        padding: 15px;
        margin-top: 20px;
        font-size: 14px;
        color: #856404;
    }

    .sepay .alert p {
        margin: 0;
    }

    .sepay .alert strong {
        color: #d9534f;
    }

    .sepay .transaction-status-done {
        margin-top: 2rem;
        text-align: center;
    }

    .sepay .transaction-status-done .icon {
        width: 40px;
        height: 40px;
    }
</style>


<div id="fob-sepay-bank" class="sepay fob-container">
        @if($error)
        <h3>{{$error}}</h3>
        @endif
        <div id="sepay-bank-info">
            <div class="fob-qr-intro">
                Cách 1: Mở app ngân hàng/ Ví để <strong>quét mã QR</strong>
            </div>
            <div class="fob-qr-code">
                <figure>
                    <img src="{{ $imageUrl }}" alt="QR Code">
                </figure>
            </div>

            <div class="fob-qr-intro">
                Cách 2: Chuyển khoản <strong>thủ công</strong> theo thông tin
            </div>
            <div class="fob-qr-information">
                <table class="table table-hover table-striped">
                    <tr>
                        <td>Tên Ngân Hàng</td>
                        <td>
                            <strong>{{ $bank }}</strong>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Chủ Tài Khoản</td>
                        <td>
                            <strong>{{ $chutaikhoan }}</strong>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Số Tài Khoản</td>
                        <td>
                            <strong>{{ $acc }}</strong>
                        </td>
                        <td class="text-end" style="width: 80px;">
                            <a href="javascript:void(0);" rel="nooper" class="ms-2" type="button" data-clipboard="{{ $acc }}" data-bb-toggle="copy">
                                
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>Nội Dung Chuyển Khoản</td>
                        <td>
                            <strong>{{ $des }}</strong>
                        </td>
                        <td class="text-end" style="width: 80px;">
                            <a href="javascript:void(0);" rel="nooper" class="ms-2" type="button" data-clipboard="{{ $des }}" data-bb-toggle="copy">
                  
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td>Số Tiền Giao Dịch</td>
                        <td>
                            <strong>{{ $formattedOrderAmount = number_format($amount, 0, ',', '.') . ' ₫' }}</strong>
                        </td>
                        <td class="text-end" style="width: 80px;">
                            <a href="javascript:void(0);" rel="nooper" class="ms-2" type="button" data-clipboard="{{ $amount }}" data-bb-toggle="copy">
                              
                            </a>
                        </td>
                    </tr>
                </table>

                <div class="alert alert-warning">
                    <p>Vui lòng giữ nguyên nội dung chuyển khoản <strong class="text-danger">{{ $des }}</strong> và nhập đúng số tiền <strong class="text-danger">{{ $formattedOrderAmount }}</strong> để được xác nhận thanh toán trực tuyến.</p>
                </div>

             
            </div>
        </div>
  

   
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const copyButtons = document.querySelectorAll('[data-bb-toggle="copy"]');

        copyButtons.forEach((button) => {
            button.addEventListener('click', function (event) {
                event.preventDefault();
                event.stopPropagation();
                const textToCopy = this.getAttribute('data-clipboard');
                fobCopyToClipboard(textToCopy);
            })
        })

    })

    let interval = null

    $(document).ready(function() {
        const paymentStatus = $('[data-bb-toggle="sepay-transaction-status"]')

        //if (paymentStatus.length) {
            interval = setInterval(() => fetchPaymentStatus(paymentStatus), 3000)
        //}
    })

    function fetchPaymentStatus(elm) {
    $.ajax({
        url: "{{ route('sepay.checkorder') }}",
        method: 'POST',
        data: {
            orderId: "{{ $orderId }}"
        },
        success: function(response) {
            console.log(response); // Kiểm tra toàn bộ response trả về

            // Kiểm tra nếu response có chứa data
            if (response.status) {
                console.log(response.status); // Kiểm tra data

                // Kiểm tra nếu data có chứa status
                if (response.status === 5) {
                    var orderSuccessUrl = "{{ sc_route('order.success') }}";
                    window.location.href = orderSuccessUrl;

                    clearInterval(interval);
                }
            } else {
                console.log('No data found in response');
            }
        },
        error: function(xhr, status, error) {
            console.log('AJAX Error: ' + error);
        }
    });
}


    async function fobCopyToClipboard(textToCopy) {
        if (navigator.clipboard && window.isSecureContext) {
            await navigator.clipboard.writeText(textToCopy);
        } else {
            fobUnsecuredCopyToClipboard(textToCopy);
        }

        MainCheckout.showSuccess('Sao chép thành công!');
    }

    function fobUnsecuredCopyToClipboard(textToCopy) {
        const textArea = document.createElement('textarea');
        textArea.value = textToCopy;
        textArea.style.position = 'absolute';
        textArea.style.left = '-999999px';
        document.body.append(textArea);
        textArea.focus();
        textArea.select();

        try {
            document.execCommand('copy');
        } catch (error) {
            console.error('Unable to copy to clipboard', error);
        }

        document.body.removeChild(textArea);
    }
</script>
