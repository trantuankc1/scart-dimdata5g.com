@extends($templatePathAdmin.'layout')

@section('main')
<div class="row">
      <div class="col-md-12">
          <div class="card">
            <div class="card-header with-border">
                <div class="btn-group pull-right">
                    <a href="{{sc_route_admin('admin_product.index') }}" class="btn btn-sm btn-flat btn-default"><i class="fa fa-list"></i>&nbsp;{{ sc_language_render('product.admin.list') }}</a>
                </div>
              </div>
              <div class="card-body">

              <form action="{{sc_route_admin('admin_import_product.process_import') }}" method="post" accept-charset="UTF-8" class="form-horizontal" id="import-product" enctype="multipart/form-data">
                  @csrf
                  <h1>{!! trans($pathPlugin.'::lang.admin.step1') !!} : {!! trans($pathPlugin.'::lang.admin.step1_note') !!}</h1>
                  <br>
                  <h2>{!! trans($pathPlugin.'::lang.admin.download_format', ['path' => asset($pathPlugin.'/product.xls')]) !!}</h2>
                  <div class="card-body">
                      <div class="fields-group">
                          <div class="form-group">
                              <label for="image" class="col-sm-2 col-form-label">
                              </label>
                              <div class="col-sm-6">
                                  <div class="input-group">
                                    <span class=" {{ $errors->has('file') ? ' invalid' : '' }}">
                                        <input accept="application/vnd.ms-excel" type="file" required="required" name="file" class="form-control rounded-0 " placeholder="" >
                                    </span>
                                      <div class="btn btn-flat input-group-addon button-upload">
                                          <i class="fa fa-floppy-o" aria-hidden="true"></i> {{ $import_submit }}
                                      </div>
                                  </div>
                                  <div class="{{ $errors->has('file') ? ' invalid' : '' }}">
                                      @if ($errors->has('file'))
                                      <span class="help-block">
                                          <i class="fa fa-info-circle"></i> {{ $errors->first('file') }}
                                      </span>
                                      @else
                                      <span class="help-block">
                                          <i class="fa fa-info-circle"></i> {!! $import_note !!}
                                      </span>
                                      @endif
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </form>  

            <div class="product">
                @if (!empty(session('step')) && session('step') =='product')
                    @if (!empty(session('arraySuccess')))
                        <div class="success">
                            <span class="title">{{ trans($pathPlugin.'::lang.admin.import_success') }}</span>: {{ implode(',', session('arraySuccess')) }}
                        </div>
                    @endif
                    @if (!empty(session('arrayError')))
                    <div class="error">
                        <span class="title">{{ trans($pathPlugin.'::lang.admin.import_error') }}</span>
                        <ul>
                            @foreach (session('arrayError') as $msg)
                            <li>{{ json_encode($msg) }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @endif
            </div>



<hr>

              <form action="{{sc_route_admin('admin_import_product.process_import_info') }}" method="post" accept-charset="UTF-8" class="form-horizontal" id="import-product-des" enctype="multipart/form-data">
                @csrf
                <h1>{!! trans($pathPlugin.'::lang.admin.step2') !!} : {!! trans($pathPlugin.'::lang.admin.step2_note') !!}</h1>
                <br>
                <h2>{!! trans($pathPlugin.'::lang.admin.download_format', ['path' => asset($pathPlugin.'/product-info.xls')]) !!}</h2>
                <div class="card-body">
                    <div class="fields-group">
                        <div class="form-group">
                            <label for="image" class="col-sm-2 col-form-label">
                            </label>
                            <div class="col-sm-6">
                                <div class="input-group">
                                  <span class=" {{ $errors->has('file_info') ? ' invalid' : '' }}">
                                      <input accept="application/vnd.ms-excel" type="file" required="required" name="file_info" class="form-control rounded-0 " placeholder="" >
                                  </span>
                                    <div class="btn btn-flat input-group-addon button-upload-des">
                                        <i class="fa fa-floppy-o" aria-hidden="true"></i> {{ $import_submit }}
                                    </div>
                                </div>
                                <div class="{{ $errors->has('file_info') ? ' invalid' : '' }}">
                                    @if ($errors->has('file_info'))
                                    <span class="help-block">
                                        <i class="fa fa-info-circle"></i> {{ $errors->first('file_info') }}
                                    </span>
                                    @else
                                    <span class="help-block">
                                        <i class="fa fa-info-circle"></i> {!! $import_note !!}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </form>  
            <div class="product-info">
                @if (!empty(session('step')) && session('step') =='product-info')
                    @if (!empty(session('arraySuccess')))
                        <div class="success">
                            <span class="title">{{ trans($pathPlugin.'::lang.admin.import_success') }}</span>: {{ implode(',', session('arraySuccess')) }}
                        </div>
                    @endif
                    @if (!empty(session('arrayError')))
                    <div class="error">
                        <span class="title">{{ trans($pathPlugin.'::lang.admin.import_error') }}</span>
                        <ul>
                            @foreach (session('arrayError') as $msg)
                                <li>{{ json_encode($msg) }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @endif
            </div>



            <hr>

            <form action="{{sc_route_admin('admin_import_product.process_import_promotion') }}" method="post" accept-charset="UTF-8" class="form-horizontal" id="import-product-promotion" enctype="multipart/form-data">
              @csrf
              <h1>{!! trans($pathPlugin.'::lang.admin.step3') !!} : {!! trans($pathPlugin.'::lang.admin.step3_note') !!}</h1>
              <br>
              <h2>{!! trans($pathPlugin.'::lang.admin.download_format', ['path' => asset($pathPlugin.'/product-promotion.xls')]) !!}</h2>
              <div class="card-body">
                  <div class="fields-group">
                      <div class="form-group">
                          <label for="image" class="col-sm-2 col-form-label">
                          </label>
                          <div class="col-sm-6">
                              <div class="input-group">
                                <span class=" {{ $errors->has('file_promotion') ? ' invalid' : '' }}">
                                    <input accept="application/vnd.ms-excel" type="file" required="required" name="file_promotion" class="form-control rounded-0 " placeholder="" >
                                </span>
                                  <div class="btn btn-flat input-group-addon button-upload-promotion">
                                      <i class="fa fa-floppy-o" aria-hidden="true"></i> {{ $import_submit }}
                                  </div>
                              </div>
                              <div class="{{ $errors->has('file_promotion') ? ' invalid' : '' }}">
                                  @if ($errors->has('file_promotion'))
                                  <span class="help-block">
                                      <i class="fa fa-info-circle"></i> {{ $errors->first('file_promotion') }}
                                  </span>
                                  @else
                                  <span class="help-block">
                                      <i class="fa fa-info-circle"></i> {!! $import_note !!}
                                  </span>
                                  @endif
                              </div>
                          </div>
                      </div>
                      
                  </div>
              </div>
          </form>  
          <div class="product-promotion">
              @if (!empty(session('step')) && session('step') =='product-promotion')
                  @if (!empty(session('arraySuccess')))
                      <div class="success">
                          <span class="title">{{ trans($pathPlugin.'::lang.admin.import_success') }}</span>: {{ implode(',', session('arraySuccess')) }}
                      </div>
                  @endif
                  @if (!empty(session('arrayError')))
                  <div class="error">
                      <span class="title">{{ trans($pathPlugin.'::lang.admin.import_error') }}</span>
                      <ul>
                          @foreach (session('arrayError') as $msg)
                              <li>{{ json_encode($msg) }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif
              @endif
          </div>

          <hr>

          <form action="{{sc_route_admin('admin_import_product.process_import_build') }}" method="post" accept-charset="UTF-8" class="form-horizontal" id="import-product-build" enctype="multipart/form-data">
            @csrf
            <h1>{!! trans($pathPlugin.'::lang.admin.step4') !!} : {!! trans($pathPlugin.'::lang.admin.step4_note') !!}</h1>
            <br>
            <h2>{!! trans($pathPlugin.'::lang.admin.download_format', ['path' => asset($pathPlugin.'/product-build.xls')]) !!}</h2>
            <div class="card-body">
                <div class="fields-group">
                    <div class="form-group">
                        <label for="image" class="col-sm-2 col-form-label">
                        </label>
                        <div class="col-sm-6">
                            <div class="input-group">
                              <span class=" {{ $errors->has('file_build') ? ' invalid' : '' }}">
                                  <input accept="application/vnd.ms-excel" type="file" required="required" name="file_build" class="form-control rounded-0 " placeholder="" >
                              </span>
                                <div class="btn btn-flat input-group-addon button-upload-build">
                                    <i class="fa fa-floppy-o" aria-hidden="true"></i> {{ $import_submit }}
                                </div>
                            </div>
                            <div class="{{ $errors->has('file_build') ? ' invalid' : '' }}">
                                @if ($errors->has('file_build'))
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('file_build') }}
                                </span>
                                @else
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i> {!! $import_note !!}
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </form>  
        <div class="product-build">
            @if (!empty(session('step')) && session('step') =='product-build')
                @if (!empty(session('arraySuccess')))
                    <div class="success">
                        <span class="title">{{ trans($pathPlugin.'::lang.admin.import_success') }}</span>: {{ implode(',', session('arraySuccess')) }}
                    </div>
                @endif
                @if (!empty(session('arrayError')))
                <div class="error">
                    <span class="title">{{ trans($pathPlugin.'::lang.admin.import_error') }}</span>
                    <ul>
                        @foreach (session('arrayError') as $msg)
                            <li>{{ json_encode($msg) }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @endif
        </div>

            </div>
          </div>
      </div>
  </div>
@endsection

@push('styles')
<style>
    .button-upload, .button-upload:hover,
    .button-upload-des, .button-upload-des:hover,
    .button-upload-build, .button-upload-build:hover,
    .button-upload-promotion, .button-upload-promotion:hover{
        background: #3c8dbc !important;
        color: #fff;
    }
    .success, .error{
        font-size: 20px;
    }
    .success .title{
        color: green;
        font-weight: bold;
    }
    .error .title{
        color: red;
        font-weight: bold;
    }
</style>
@endpush

@push('scripts')
    <script>
        $('.button-upload').click(function(){
            $('#loading').show();
            $('#import-product').submit();
        });
        $('.button-upload-des').click(function(){
            $('#loading').show();
            $('#import-product-des').submit();
        });
        $('.button-upload-promotion').click(function(){
            $('#loading').show();
            $('#import-product-promotion').submit();
        });
        $('.button-upload-build').click(function(){
            $('#loading').show();
            $('#import-product-build').submit();
        });
    </script>
@endpush
