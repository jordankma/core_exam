@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('card-cardmanage::language.titles.card_product.update') }}@stop

{{-- page styles --}}
@section('header_styles')
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/css/bootstrap-switch.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/blog.css') }}" rel="stylesheet" type="text/css">
    <!--end of page css-->
@stop


{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>{{ $title }}</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('backend.homepage') }}"> <i class="livicon" data-name="home" data-size="16"
                                                                         data-color="#000"></i>
                    {{ trans('adtech-core::labels.home') }}
                </a>
            </li>
            <li class="active"><a href="#">{{ $title }}</a></li>
        </ol>
    </section>
    <!--section ends-->
    <section class="content paddingleft_right15">
        <!--main content-->
        <div class="row">
            <div class="col-sm-6">
                <label>Tên sản phẩm</label>
                <div class="form-group {{ $errors->first('name', 'has-error') }}">
                    {!! Form::text('name', $product->product_name, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('card-cardmanage::language.placeholder.card_product.name_here'))) !!}
                    <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                </div>
                <label>Mã sản phẩm</label>
                <div class="form-group {{ $errors->first('code', 'has-error') }}">
                    {!! Form::text('code', $product->product_code, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('card-cardmanage::language.placeholder.card_product.code'))) !!}
                    <span class="help-block">{{ $errors->first('code', ':message') }}</span>
                </div>
                <div class="col-md-6">
                    <label>Độ dài kí tự trong serial</label>
                    <div class="form-group {{ $errors->first('serial_length', 'has-error') }}">
                        {!! Form::number('serial_length', $product->serial_length, array('class' => 'form-control','disabled'=>'disabled')) !!}
                        <span class="help-block">{{ $errors->first('serial_length', ':message') }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <label>Độ dài kí tự trong mã thẻ</label>
                    <div class="form-group {{ $errors->first('code_length', 'has-error') }}">
                        {!! Form::number('code_length', $product->code_length, array('class' => 'form-control','disabled'=>'disabled')) !!}
                        <span class="help-block">{{ $errors->first('code_length', ':message') }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <label>Mô tả</label>
                <div class="form-group {{ $errors->first('description', 'has-error') }}">
                    {!! Form::textarea('description', $product->description, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('card-cardmanage::language.placeholder.card_product.description'))) !!}
                    <span class="help-block">{{ $errors->first('description', ':message') }}</span>
                </div>
            </div>
        </div>
        <!-- /.col-sm-8 -->
        <div class="row">
            <div class="form-group col-xs-12">

                <div class="form-group">
                    <button type="submit" class="btn btn-success">{{ trans('adtech-core::buttons.create') }}</button>
                    <a href="{!! route('card.cardmanage.card_product.create') !!}"
                       class="btn btn-danger">{{ trans('card-cardmanage::language.buttons.discard') }}</a>
                </div>
            </div>
        </div>
        <!-- /.col-sm-4 -->
        </div>
                {!! Form::close() !!}
            </div>
            @if ( $errors->any() )
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
        <!--main content ends-->
    </section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <!-- begining of page js -->
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/js/bootstrap-switch.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}" type="text/javascript"></script>
    <script>
        $(function () {
            $("[name='permission_locked'], [name='status']").bootstrapSwitch();
        })
    </script>
@stop
