<style>
    .sepay .fob-qr-code {
        text-align: center;
        margin-bottom: 40px;
    }

    .sepay .fob-qr-code img {
        width: 250px;
        height: auto;
        margin: 0;
        padding: 0;
    }

    .sepay .fob-qr-code figcaption {
        margin-top: 10px;
        font-size: 14px;
        color: #666;
    }

    .sepay .fob-qr-intro {
        margin-bottom: 10px;
        font-size: 16px;
    }

    .sepay .transaction-status-done {
        margin-top: 2rem;
    }

    .sepay .transaction-status-done .icon {
        width: 40px;
        height: 40px;
    }
</style>

<div id="fob-sepay-bank" class="sepay fob-container">
    
        <div id="sepay-bank-info">
            <div class="fob-qr-intro">
                Cách 1: Mở app ngân hàng/ Ví để <strong>quét mã QR</strong>
            </div>
            <div class="fob-qr-code">
                <figure>
                    <img src="{{ $imageUrl }}" alt="QR Code">
                </figure>
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
