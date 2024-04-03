@extends($templatePathAdmin.'layout')

@section('main')

<div class="row">

  <div class="col-md-12">

    <div class="card">
      <div class="card-header with-border">
        <h2 class="card-title">{{ $title_description??'' }}</h2>
      </div>

      <div class="card-body table-responsivep-0">
      <table class="table table-hover">
         <tbody>

          <tr>
            <th width="40%">{{ trans($pathPlugin.'::lang.paypal_mode') }}</th>
            <td><a href="#" class="fied-required editable editable-click" data-name="PaypalExpress_mode" data-type="select" data-pk="PaypalExpress_mode" data-url="{{ sc_route_admin('admin_config_global.update') }}" data-title="{{ trans($pathPlugin.'::lang.paypal_mode') }}" data-value="{{ sc_config('PaypalExpress_mode') }}" data-source ='[{"value":"sandbox","text":"Sandbox"},{"value":"live","text":"Live"}]'></a></td>
          </tr>

          <tr>
            <th width="40%">{{ trans($pathPlugin.'::lang.paypal_client_id') }}</th>
            <td><a href="#" class="updateData_can_empty editable editable-click" data-name="PaypalExpress_client_id" data-type="text" data-pk="PaypalExpress_client_id" data-url="{{ sc_route_admin('admin_config_global.update') }}" data-value="{{ sc_config('PaypalExpress_client_id') }}" data-title="{{ trans($pathPlugin.'::lang.paypal_client_id') }}"></a></td>
          </tr>
          <tr>
            <th width="40%">{{ trans($pathPlugin.'::lang.paypal_secrect') }}</th>
            <td><a href="#" class="updateData_can_empty editable editable-click" data-name="PaypalExpress_secrect" data-type="password" data-pk="PaypalExpress_secrect" data-url="{{ sc_route_admin('admin_config_global.update') }}" data-value="{{ (sc_admin_can_config()) ? sc_config('PaypalExpress_secrect'): 'hidden' }}" data-title="{{ trans($pathPlugin.'::lang.paypal_secrect') }}"></a></td>
          </tr>

          <tr>
            <th width="40%">{{ trans($pathPlugin.'::lang.paypal_order_status_success') }}</th>
            <td><a href="#" class="fied-required editable editable-click" data-name="PaypalExpress_order_status_success" data-type="select" data-pk="PaypalExpress_order_status_success" data-source="{{ $jsonStatusOrder }}" data-value="{{ sc_config('PaypalExpress_order_status_success') }}" data-url="{{ sc_route_admin('admin_config_global.update') }}" data-title="{{ trans($pathPlugin.'::lang.paypal_order_status_success') }}"></a></td>
          </tr>
          <tr>
            <th width="40%">{{ trans($pathPlugin.'::lang.paypal_order_status_faild') }}</th>
            <td><a href="#" class="fied-required editable editable-click" data-name="PaypalExpress_order_status_faild" data-type="select" data-pk="PaypalExpress_order_status_faild" data-source="{{ $jsonStatusOrder }}" data-value="{{ sc_config('PaypalExpress_order_status_faild') }}" data-url="{{ sc_route_admin('admin_config_global.update') }}" data-title="{{ trans($pathPlugin.'::lang.paypal_order_status_faild') }}"></a></td>
          </tr>
          <tr>
            <th width="40%">{{ trans($pathPlugin.'::lang.paypal_payment_status') }}</th>
            <td><a href="#" class="fied-required editable editable-click" data-name="PaypalExpress_payment_status" data-type="select" data-pk="PaypalExpress_payment_status" data-source="{{ $jsonPaymentStatus }}" data-value="{{ sc_config('PaypalExpress_payment_status') }}" data-url="{{ sc_route_admin('admin_config_global.update') }}" data-title="{{ trans($pathPlugin.'::lang.paypal_payment_status') }}"></a></td>
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
