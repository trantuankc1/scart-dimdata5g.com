@extends($templatePathAdmin.'layout')

@section('main')
@php
    $id = empty($id) ? 0 : $id;
@endphp
<div class="row">

  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">{!! $title_action !!}</h3>
        @if ($layout == 'edit')
        <div class="btn-group float-right" style="margin-right: 5px">
            <a href="{{ sc_route_admin('admin_supplier.index') }}" class="btn  btn-flat btn-default" title="List"><i class="fa fa-list"></i><span class="hidden-xs"> {{ sc_language_render('admin.back_list') }}</span></a>
        </div>
      @endif
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form action="{{ $url_action }}" method="post" accept-charset="UTF-8" class="form-horizontal" id="form-main">
        <div class="card-body">

          <div class="form-group row {{ $errors->has('name') ? ' text-red' : '' }}">
            <label for="name" class="col-sm-2 col-form-label">{{ sc_language_render('admin.supplier.name') }}</label>
            <div class="col-sm-10 ">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                </div>
                <input type="text" id="name" name="name" value="{{ old()?old('name'):$supplier['name']??'' }}" class="form-control name {{ $errors->has('name') ? ' is-invalid' : '' }}">
              </div>

              @if ($errors->has('name'))
              <span class="text-sm">
                <i class="fa fa-info-circle"></i> {{ $errors->first('name') }}
              </span>
              @endif

            </div>
          </div>

          <div class="form-group row {{ $errors->has('alias') ? ' text-red' : '' }}">
            <label for="alias" class="col-sm-2 col-form-label">{!! sc_language_render('admin.supplier.alias') !!}</label>
            <div class="col-sm-10 ">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                </div>
                <input type="text" id="alias" name="alias" value="{{ old()?old('alias'):$supplier['alias']??'' }}" class="form-control alias {{ $errors->has('alias') ? ' is-invalid' : '' }}">
              </div>

              @if ($errors->has('alias'))
              <span class="text-sm">
                <i class="fa fa-info-circle"></i> {{ $errors->first('alias') }}
              </span>
              @endif

            </div>
          </div>

          <div class="form-group row {{ $errors->has('phone') ? ' text-red' : '' }}">
            <label for="phone" class="col-sm-2 col-form-label">{!! sc_language_render('admin.supplier.phone') !!}</label>
            <div class="col-sm-10 ">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                </div>
                <input type="phone" id="phone" name="phone" value="{{ old()?old('phone'):$supplier['phone']??'' }}" class="form-control phone {{ $errors->has('phone') ? ' is-invalid' : '' }}">
              </div>

              @if ($errors->has('phone'))
              <span class="text-sm">
                <i class="fa fa-info-circle"></i> {{ $errors->first('phone') }}
              </span>
              @endif

            </div>
          </div>

          <div class="form-group row {{ $errors->has('url') ? ' text-red' : '' }}">
            <label for="url" class="col-sm-2 col-form-label">{!! sc_language_render('admin.supplier.url') !!}</label>
            <div class="col-sm-10 ">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                </div>
                <input type="text" id="url" name="url" value="{{ old()?old('url'):$supplier['url']??'' }}" class="form-control url {{ $errors->has('url') ? ' is-invalid' : '' }}">
              </div>

              @if ($errors->has('url'))
              <span class="text-sm">
                <i class="fa fa-info-circle"></i> {{ $errors->first('url') }}
              </span>
              @endif

            </div>
          </div>

          <div class="form-group row {{ $errors->has('email') ? ' text-red' : '' }}">
            <label for="email" class="col-sm-2 col-form-label">{!! sc_language_render('admin.supplier.email') !!}</label>
            <div class="col-sm-10 ">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                </div>
                <input type="email" id="email" name="email" value="{{ old()?old('email'):$supplier['email']??'' }}" class="form-control email {{ $errors->has('email') ? ' is-invalid' : '' }}">
              </div>

              @if ($errors->has('email'))
              <span class="text-sm">
                <i class="fa fa-info-circle"></i> {{ $errors->first('email') }}
              </span>
              @endif

            </div>
          </div>

          <div class="form-group row {{ $errors->has('address') ? ' text-red' : '' }}">
            <label for="address" class="col-sm-2 col-form-label">{!! sc_language_render('admin.supplier.address') !!}</label>
            <div class="col-sm-10 ">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                </div>
                <input type="text" id="address" name="address" value="{{ old()?old('address'):$supplier['address']??'' }}" class="form-control address {{ $errors->has('address') ? ' is-invalid' : '' }}">
              </div>

              @if ($errors->has('address'))
              <span class="text-sm">
                <i class="fa fa-info-circle"></i> {{ $errors->first('address') }}
              </span>
              @endif

            </div>
          </div>

          <div class="form-group row {{ $errors->has('image') ? ' text-red' : '' }}">
            <label for="image" class="col-sm-2 col-form-label">{!! sc_language_render('admin.supplier.image') !!}</label>
            <div class="col-sm-10 ">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                </div>
                <input type="text" id="image" name="image" value="{{ old()?old('image'):$supplier['image']??'' }}" class="form-control image {{ $errors->has('image') ? ' is-invalid' : '' }}">
                <div class="input-group-append">
                  <span data-input="image" data-preview="preview_image" data-type="supplier"
                      class="btn btn-primary lfm"><i class="fa fa-image"></i>  {{sc_language_render('product.admin.choose_image')}}</span>
                </div>
              </div>
              <div id="preview_image" class="img_holder"><img
                src="{{ sc_file(old('image',$supplier['image']??'images/no-image.jpg')) }}">
              </div>
              @if ($errors->has('image'))
              <span class="text-sm">
                <i class="fa fa-info-circle"></i> {{ $errors->first('image') }}
              </span>
              @endif

            </div>
          </div>

          <div class="form-group row {{ $errors->has('sort') ? ' text-red' : '' }}">
            <label for="sort" class="col-sm-2 col-form-label">{!! sc_language_render('admin.supplier.sort') !!}</label>
            <div class="col-sm-10 ">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                </div>
                <input type="number" id="sort" name="sort" min=0 value="{{ old()?old('sort'):$supplier['sort']??0 }}" class="form-control sort {{ $errors->has('sort') ? ' is-invalid' : '' }}">
              </div>

              @if ($errors->has('sort'))
              <span class="text-sm">
                <i class="fa fa-info-circle"></i> {{ $errors->first('sort') }}
              </span>
              @endif

            </div>
          </div>

        {{-- Custom fields --}}
        @php
            $customFields = isset($customFields) ? $customFields : [];
            $fields = !empty($supplier) ? $supplier->getCustomFields() : [];
        @endphp
        @includeIf($templatePathAdmin.'component.render_form_custom_field', ['customFields' => $customFields, 'fields' => $fields])
        {{-- //Custom fields --}}

        </div>
        <!-- /.card-body -->
        @csrf
        <div class="card-footer">
          <button type="reset" class="btn btn-warning">{{ sc_language_render('action.reset') }}</button>
          <button type="submit" class="btn btn-primary float-right">{{ sc_language_render('action.submit') }}</button>
        </div>
        <!-- /.card-footer -->
      </form>
    </div>
  </div>


  <div class="col-md-6">

    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-th-list"></i> {!! $title ?? '' !!}</h3>
      </div>

      <div class="card-body p-0">
            <section id="pjax-container" class="table-list">
              <div class="box-body table-responsivep-0" >
                 <table class="table table-hover box-body text-wrap table-bordered">
                    <thead>
                       <tr>
                        @if (!empty($removeList))
                        <th></th>
                        @endif
                        @foreach ($listTh as $key => $th)
                            <th>{!! $th !!}</th>
                        @endforeach
                       </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataTr as $keyRow => $tr)
                            <tr class="{{ (request('id') == $keyRow) ? 'active': '' }}">
                                @if (!empty($removeList))
                                <td>
                                  <input class="checkbox" type="checkbox" class="grid-row-checkbox" data-id="{{ $keyRow }}">
                                </td>
                                @endif
                                @foreach ($tr as $key => $trtd)
                                    <td>{!! $trtd !!}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                 </table>
                 <div class="block-pagination clearfix m-10">
                  <div class="ml-3 float-left">
                    {!! $resultItems??'' !!}
                  </div>
                  <div class="pagination pagination-sm mr-3 float-right">
                    {!! $pagination??'' !!}
                  </div>
                </div>
              </div>
             </section>
    </div>



    </div>
  </div>

</div>
</div>
@endsection


@push('styles')
{!! $css ?? '' !!}
@endpush

@push('scripts')
    {{-- //Pjax --}}
   <script src="{{ sc_file('admin/plugin/jquery.pjax.js')}}"></script>

  <script type="text/javascript">

    $('.grid-refresh').click(function(){
      $.pjax.reload({container:'#pjax-container'});
    });

      $(document).on('submit', '#button_search', function(event) {
        $.pjax.submit(event, '#pjax-container')
      })

    $(document).on('pjax:send', function() {
      $('#loading').show()
    })
    $(document).on('pjax:complete', function() {
      $('#loading').hide()
    })

    // tag a
    $(function(){
     $(document).pjax('a.page-link', '#pjax-container')
    })


    $(document).ready(function(){
    // does current browser support PJAX
      if ($.support.pjax) {
        $.pjax.defaults.timeout = 2000; // time in milliseconds
      }
    });

    @if ($buttonSort)
      $('#button_sort').click(function(event) {
        var url = '{{ $urlSort??'' }}?sort_shipping='+$('#shipping_sort option:selected').val();
        $.pjax({url: url, container: '#pjax-container'})
      });
    @endif
    
  </script>
    {{-- //End pjax --}}


<script type="text/javascript">
{{-- sweetalert2 --}}
var selectedRows = function () {
    var selected = [];
    $('.grid-row-checkbox:checked').each(function(){
        selected.push($(this).data('id'));
    });

    return selected;
}

$('.grid-trash').on('click', function() {
  var ids = selectedRows().join();
  deleteItem(ids);
});

  function deleteItem(ids){
  Swal.mixin({
    customClass: {
      confirmButton: 'btn btn-success',
      cancelButton: 'btn btn-danger'
    },
    buttonsStyling: true,
  }).fire({
    title: '{{ sc_language_render('action.delete_confirm') }}',
    text: "",
    type: 'warning',
    showCancelButton: true,
    confirmButtonText: '{{ sc_language_render('action.confirm_yes') }}',
    confirmButtonColor: "#DD6B55",
    cancelButtonText: '{{ sc_language_render('action.confirm_no') }}',
    reverseButtons: true,

    preConfirm: function() {
        return new Promise(function(resolve) {
            $.ajax({
                method: 'post',
                url: '{{ $urlDeleteItem ?? '' }}',
                data: {
                  ids:ids,
                    _token: '{{ csrf_token() }}',
                },
                success: function (data) {
                    if(data.error == 1){
                      alertMsg('error', data.msg, '{{ sc_language_render('action.warning') }}');
                      $.pjax.reload('#pjax-container');
                      return;
                    }else{
                      alertMsg('success', data.msg);
                      window.location.replace('{{ sc_route_admin('admin_supplier.index') }}');
                    }

                }
            });
        });
    }

  }).then((result) => {
    if (result.value) {
      alertMsg('success', '{{ sc_language_render('action.delete_confirm_deleted_msg') }}', '{{ sc_language_render('action.delete_confirm_deleted') }}');
    } else if (
      // Read more about handling dismissals
      result.dismiss === Swal.DismissReason.cancel
    ) {
      // swalWithBootstrapButtons.fire(
      //   'Cancelled',
      //   'Your imaginary file is safe :)',
      //   'error'
      // )
    }
  })
}
{{--/ sweetalert2 --}}


</script>

{!! $js ?? '' !!}
@endpush
