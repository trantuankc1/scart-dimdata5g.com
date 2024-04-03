<script type="text/javascript">
    $('#coupon-button').click(function() {
        var coupon = $('#coupon-value').val();
           if(coupon==''){
               $('#coupon-group').addClass('has-error');
               $('.coupon-msg').html('{{ sc_language_render('cart.coupon_empty') }}').addClass('text-danger').show();
           }else{
           $('#coupon-button').prop('disabled', true);
           setTimeout(function() {
               $.ajax({
                   url: '{{ sc_route('discount.process') }}',
                   type: 'POST',
                   dataType: 'json',
                   data: {
                       code: coupon,
                       uID: {{ session('customer')->id ?? 0 }},
                       _token: "{{ csrf_token() }}",
                   },
               })
               .done(function(result) {
                       $('#coupon-value').val('');
                       $('.coupon-msg').removeClass('text-danger');
                       $('.coupon-msg').removeClass('text-success');
                       $('#coupon-group').removeClass('has-error');
                       $('.coupon-msg').hide();
                   if(result.error ==1){
                       $('#coupon-group').addClass('has-error');
                       $('.coupon-msg').html(result.msg).addClass('text-danger').show();
                   }else{
                       $('#removeCoupon').show();
                       $('.coupon-msg').html(result.msg).addClass('text-success').show();
                       $('.sc_showTotal').remove();
                       $('#sc_showTotal').prepend(result.html);
                   }
               })
               .fail(function() {
                   console.log("error");
               })
              $('#coupon-button').prop('disabled', false);
          }, 2000);
           }
    
       });
       $('#removeCoupon').click(function() {
               $.ajax({
                   url: '{{ sc_route('discount.remove') }}',
                   type: 'POST',
                   dataType: 'json',
                   data: {
                       _token: "{{ csrf_token() }}",
                   },
               })
               .done(function(result) {
                       $('#removeCoupon').hide();
                       $('#coupon-value').val('');
                       $('.coupon-msg').removeClass('text-danger');
                       $('.coupon-msg').removeClass('text-success');
                       $('.coupon-msg').hide();
                       $('.sc_showTotal').remove();
                       $('#sc_showTotal').prepend(result.html);
               })
               .fail(function() {
                   console.log("error");
               })
       });
       </script>