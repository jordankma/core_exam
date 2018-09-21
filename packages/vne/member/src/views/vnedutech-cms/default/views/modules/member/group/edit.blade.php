@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('dhcd-member::language.titles.group.update') }}@stop

{{-- page styles --}}
@section('header_styles')
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/css/bootstrap-switch.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/blog.css') }}" rel="stylesheet" type="text/css">
@stop
<!--end of page css-->


{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>{{ $title }}</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('backend.homepage') }}">
                    <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
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
            <div class="the-box no-border">
                <!-- errors -->
                <form action="{{route('dhcd.member.group.update')}}" method="post" id="form-edit-group">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <input type="hidden" name="group_id" value="{{ $group->group_id }}"/>
                    <div class="row">
                        <div class="col-sm-4">
                            <label>{{trans('dhcd-member::language.form.title_group.name') }} <span style="color: red">(*)</span></label>
                            <div class="form-group {{ $errors->first('name', 'has-error') }}">
                                <input type="text" name="name" class="form-control" value="{{$group->name}}">
                                <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                            </div>
                            <div class="form-group">
                                <label>{{trans('dhcd-member::language.form.title_group.desc')}} <span style="color: red">(*)</span></label><br>
                                <textarea rows="5" cols="101" name="desc" class="form-control" placeholder="{{trans('dhcd-member::language.placeholder.group.desc')}}">{{ $group->desc }}</textarea>
                            </div>
                            <div class="form-group">
                                <input type="radio" id="hot" name="type" value="1" @if($group->type==1) checked @endif>
                                <label for="hot">{{trans('dhcd-member::language.form.title_group.hot')}}    </label>
                                <input type="radio" id="normal" name="type" value="2" @if($group->type==2) checked @endif>
                                <label for="normal">{{trans('dhcd-member::language.form.title_group.normal')}}</label>
                            </div>
                            <label>{{trans('dhcd-member::language.form.title_group.image')}} <span style="color: red">(*)</span></label>
                            <div class="form-group">
                                <div class="input-group">
                                   <span class="input-group-btn">
                                     <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                       <i class="fa fa-picture-o"></i> {{trans('dhcd-member::language.form.title_group.choise_image_display')}}
                                     </a>
                                   </span>
                                   <input type="text" disabled="" value="{{ $group->image }}" name="image" id="thumbnail" class="form-control">
                                 </div>
                                 <img id="holder" src="{{ $group->image }}" style="margin-top:15px;max-height:100px;">
                            </div>
                        </div>
                        <!-- /.col-sm-8 -->
                        <div class="col-sm-4">
                            <div class="form-group col-xs-12">
                                <label for="blog_category" class="">Actions</label>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">{{ trans('dhcd-member::language.buttons.update') }}</button>
                                    <a href="{!! route('dhcd.member.group.manage') !!}"
                                       class="btn btn-danger">{{ trans('dhcd-member::language.buttons.discard') }}</a>
                                </div>
                            </div>
                        </div>
                        <!-- /.col-sm-4 -->
                    </div>
                </form>
            </div>
        </div>
        <!--main content ends-->
    </section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <!-- begining of page js -->
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/js/bootstrap-switch.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/vendor/laravel-filemanager/js/lfm.js') }}" type="text/javascript" ></script>
    <!--end of page js-->
    <script>
        $(document).ready(function() {
            $("#lfm").filemanager('image');
            $('#form-edit-group').bootstrapValidator({
                feedbackIcons: {
                    // validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    name: {
                        validators: {
                            notEmpty: {
                                message: 'Trường này không được bỏ trống'
                            },
                            stringLength: {
                                min: 1,
                                max: 200,
                                message: 'Tên không được quá dài'
                            },
                        }
                    }
                }
            });
        });
    </script>
@stop
