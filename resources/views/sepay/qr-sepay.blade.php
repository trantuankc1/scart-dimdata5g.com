@extends($sc_templatePath.'.layout')
@section('block_main')
    <div class="container">
        <div class="qr-code">
            <div class="mt-1">
                <p>Cách 1: Mở app ngân hàng/ Ví để <span class="fw-bold" style="font-weight: bold">quét mã QR</span></p>
                <img src="{{ $qrUrl }}" alt="QR Code for Payment" width="150">
            </div>
            <div class="mt-2">
                <p>Cách 2: Chuyển khoản thủ công theo thông tin</p>
                <ul style="text-align: center">
                    <li>Tên Ngân Hàng: MB Bank</li>
                    <li>Chủ Tài Khoản: TRAN MINH TUAN</li>
                    <li>Số Tài Khoản: <span style="font-weight: bold">0369197931</span></li>
                    <li>Số Tiền Giao Dịch: {{ number_format($dataOrder['total']) }}</li>
                    <li>Nội Dung Chuyển Khoản: {{ $orderID }}</li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const data = {
                gateway: "MBBank",
                transactionDate: new Date().toISOString(),
                accountNumber: "0369197931",
                subAccount: null,
                code: null,
                content: "Nội dung giao dịch động",
                transferType: "in",
                description: "Nội dung thông báo động",
                transferAmount: {{ $dataOrder['total'] }},
                referenceCode: "FT" + new Date().getTime(),
                accumulated: 0,
                id: {{ $orderID }}
            };

            fetch('{{ route('sepay.webhook') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(data)
            })
                .then(response => {
                    console.log('Response Status:', response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('Response Data:', data);
                    if (data.success) {
                        if (data.redirect) {
                            window.location.href = data.redirect;
                        } else {
                            console.log('Payment processed successfully');
                        }
                    } else {
                        console.log(data.message || 'Payment failed');
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    </script>
@endpush
