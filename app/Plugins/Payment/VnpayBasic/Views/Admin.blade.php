@extends($templatePathAdmin.'layout')

@section('main')

<div class="row">

  <div class="col-md-12">

    <div class="box box-primary">
      <div class="box-header with-border">
        <h2 class="box-title">{{ $title_description??'' }}</h2>
      </div>

      <div class="box-body table-responsive no-padding box-primary">
       <table class="table table-hover table-bordered">
         <thead>
           <tr>
            <th>{{ sc_language_render('Plugins/Payment/VnpayBasic::lang.config_field') }}</th>
            <th>{{ sc_language_render('Plugins/Payment/VnpayBasic::lang.config_value') }}</th>
           </tr>
         </thead>
         <tbody>

      <tr>
            <th width="40%">{{ sc_language_render('Plugins/Payment/VnpayBasic::lang.vnpay_urlApi') }}</th>
            <td><a href="#" class="updateData_can_empty editable editable-click" data-name="vnpay_urlApi" data-type="text" data-pk="vnpay_urlApi" data-url="{{ route('admin_config_global.update') }}" data-value="{{ sc_config('vnpay_urlApi') }}" data-title="{{ sc_language_render('Plugins/Payment/VnpayBasic::lang.vnpay_urlApi') }}"></a></td>
      </tr>

          <tr>
            <th width="40%">{{ sc_language_render('Plugins/Payment/VnpayBasic::lang.vnpay_secretKey') }}</th>
            <td><a href="#" class="updateData_can_empty editable editable-click" data-name="vnpay_secretKey" data-type="password" data-pk="vnpay_secretKey" data-url="{{ route('admin_config_global.update') }}" data-value="{{ (sc_admin_can_config()) ? sc_config('vnpay_secretKey'): 'hidden' }}" data-title="{{ sc_language_render('Plugins/Payment/VnpayBasic::lang.vnpay_secretKey') }}"></a></td>
          </tr>
          <tr>
            <th width="40%">{{ sc_language_render('Plugins/Payment/VnpayBasic::lang.vnpay_partnerCode') }}</th>
            <td><a href="#" class="updateData_can_empty editable editable-click" data-name="vnpay_partnerCode" data-type="text" data-pk="vnpay_partnerCode" data-url="{{ route('admin_config_global.update') }}" data-value="{{ sc_config('vnpay_partnerCode') }}" data-title="{{ sc_language_render('Plugins/Payment/VnpayBasic::lang.vnpay_partnerCode') }}"></a></td>
          </tr>

          <tr>
            <th width="40%">{{ sc_language_render('Plugins/Payment/VnpayBasic::lang.vnpay_order_status_success') }}</th>
            <td><a href="#" class="fied-required editable editable-click" data-name="vnpay_order_status_success" data-type="select" data-pk="vnpay_order_status_success" data-source="{{ $jsonStatusOrder }}" data-value="{{ sc_config('vnpay_order_status_success') }}" data-url="{{ route('admin_config_global.update') }}" data-title="{{ sc_language_render('Plugins/Payment/VnpayBasic::lang.vnpay_order_status_success') }}"></a></td>
          </tr>
          <tr>
            <th width="40%">{{ sc_language_render('Plugins/Payment/VnpayBasic::lang.vnpay_order_status_faild') }}</th>
            <td><a href="#" class="fied-required editable editable-click" data-name="vnpay_order_status_faild" data-type="select" data-pk="vnpay_order_status_faild" data-source="{{ $jsonStatusOrder }}" data-value="{{ sc_config('vnpay_order_status_faild') }}" data-url="{{ route('admin_config_global.update') }}" data-title="{{ sc_language_render('Plugins/Payment/VnpayBasic::lang.vnpay_order_status_faild') }}"></a></td>
          </tr>
          <tr>
            <th width="40%">{{ sc_language_render('Plugins/Payment/VnpayBasic::lang.vnpay_payment_status') }}</th>
            <td><a href="#" class="fied-required editable editable-click" data-name="vnpay_payment_status" data-type="select" data-pk="vnpay_payment_status" data-source="{{ $jsonPaymentStatus }}" data-value="{{ sc_config('vnpay_payment_status') }}" data-url="{{ route('admin_config_global.update') }}" data-title="{{ sc_language_render('Plugins/Payment/VnpayBasic::lang.vnpay_payment_status') }}"></a></td>
          </tr>              
    </td>
  </tr>


    </tbody>
       </table>
      </div>
    </div>
  </div>

</div>


@endsection


@push('styles')
<!-- Ediable -->
<link rel="stylesheet" href="{{ asset('admin/plugin/bootstrap-editable.css')}}">
<style type="text/css">
  #maintain_content img{
    max-width: 100%;
  }
</style>
@endpush

@push('scripts')
<!-- Ediable -->
<script src="{{ asset('admin/plugin/bootstrap-editable.min.js')}}"></script>

<script type="text/javascript">
  // Editable
$(document).ready(function() {

      $.fn.editable.defaults.params = function (params) {
        params._token = "{{ csrf_token() }}";
        return params;
      };
        $('.fied-required').editable({
        validate: function(value) {
            if (value == '') {
                return '{{  sc_language_render('admin.not_empty') }}';
            }
        },
        success: function(data) {
          if(data.error == 0){
            alertJs('success', '{{ sc_language_render('admin.msg_change_success') }}');
          } else {
            alertJs('error', data.msg);
          }
      }
    });

    $('.updateData_can_empty').editable({
        success: function(data) {
          console.log(data);
          if(data.error == 0){
            alertJs('success', '{{ sc_language_render('admin.msg_change_success') }}');
          } else {
            alertJs('error', data.msg);
          }
      }
    });

});
</script>
@endpush
