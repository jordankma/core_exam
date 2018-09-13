@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('vne-news::language.titles.news.edit') }} @stop
{{-- page styles --}}
@section('header_styles')
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin .'/vendors/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/css/bootstrap-switch.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin .'/vendors/bootstrap-tagsinput/css/bootstrap-tagsinput.css') }}" rel="stylesheet" />
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/blog.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{ asset('/vendor/' . $group_name . '/' . $skin .'/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/vendor/' . $group_name . '/' . $skin .'/vendors/bootstrap-multiselect/css/bootstrap-multiselect.css') }}">
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin .'/vendors/ckeditor/js/ckeditor.js') }}" type="text/javascript"></script>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vne/news/css/news/add.css') }}" rel="stylesheet" type="text/css"/>
    <style type="text/css">
        .multiselect-container .active a{
            background-color: lightblue !important;
        }
        #cate .btn-group{
            width: 100% !important;
        }
        .bootstrap-tagsinput{
            width: 100% !important;
        }
    </style>
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
                <form role="form" action="{{route('vne.news.news.update',$news->news_id)}}" method="post" enctype="multipart/form-data" id="form-edit-news">
                    <input type='hidden' id='control_upload' name='type_upload' value="add_news">
                    <input type='hidden' id='type_control' name='type_control' value="">
                    <input type='hidden' id='mutil' name='mutil' value="remove">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="col-md-8 col-sm-8">
                            @if(count($errors))
                                @foreach($errors -> all() as $error)
                                    <div class="alert alert-danger">{{$error}}</div>
                                @endforeach
                            @endif
                            <div class="form-group">
                                <label>{{trans('vne-news::language.form.text.title')}}<span style="color: red">(*)</span></label>
                                <input type="text" required name="title" value="{{$news->title}}" class="form-control" placeholder="{{trans('vne-news::language.form.title_placeholder')}}">
                            </div>
                            <div class="form-group">
                                <label>{{trans('vne-news::language.form.text.desc')}}</label><br>
                                <textarea rows="5" cols="101" name="desc"  class="form-control" placeholder="{{trans('vne-news::language.form.desc_placeholder')}}">{{$news->desc}}</textarea>
                            </div>
                            {{-- <div class="form-group" style="display: none;visibility: hidden;">
                                <label for="news-text">
                                    <input type="radio" id="news-text" name="type" value="1" @if($news->type==1) checked="checked" @endif class="type_news">
                                    {{trans('vne-news::language.form.text.news_text')}}
                                </label> 
                                <label for="news-image">
                                    <input type="radio" id="news-image" name="type" value="2" @if($news->type==2) checked="checked" @endif class="type_news">
                                    {{trans('vne-news::language.form.text.news_image')}}
                                </label>
                            </div> --}}
                            <div class="area-new-text" {{-- @if($news->type==1) style="display: block;" @else style="display: none;" @endif --}}>
                                <div class="form-group" >
                                    <label>{{trans('vne-news::language.form.text.content')}} </label><br>
                                    <div class='box-body pad form-group'>
                                        <textarea name="content" id="ckeditor" placeholder="{{trans('vne-news::language.form.content_placeholder')}}">{{$news->content}}</textarea>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="area-new-image" @if($news->type==2) style="display: block;" @else style="display: none;" @endif>
                                <div class="form-group" id="list-item" >
                                    <a id="lfm1" data-input="thumbnail1" data-preview="holder1" class="btn btn-primary">
                                        <i class="fa fa-picture-o"></i> {{trans('vne-news::language.label.choise_image')}}
                                    </a>
                                    <div class="table-responsive col-md-10" >
                                        <table class="grid table table-bordered table-sortable" style='font-size: 12px;'>
                                            <thead>
                                            <th>{{trans('vne-news::language.table.news.image')}}</th>
                                            <th>{{trans('vne-news::language.table.news.url')}}</th>
                                            <th>{{trans('vne-news::language.table.news.actions')}}</th>
                                            </thead>
                                            <tbody id="list-file">
                                                @if(!empty($list_gallery))
                                                @foreach ($list_gallery as $gallery)
                                                <tr class="/files/{{$gallery['name']}}">
                                                    <td>
                                                        <img src="{{$gallery['link']}}" width="75px">
                                                    </td>
                                                    <td>{{$gallery['name']}}</td>
                                                    <td>
                                                        <a href="javascrip::void(0,0)" class="btn btn-danger del-media"><span style="margin:0px;" class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                                                    </td>
                                                    <input type="hidden" name="file_names[]" value="{{$gallery['name']}}">
                                                    <input type="hidden" name="file_links[]" value="{{$gallery['link']}}">
                                                    <input type="hidden" name="file_types[]" value="{{$gallery['type']}}">
                                                </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                        <!-- /.col-sm-8 -->
                        <!-- /.col-sm-4 -->
                        <div class="col-md-4 col-sm-4">
                            <div class="form-group">
                                <label>{{trans('vne-news::language.form.text.cat')}} <span style="color: red">(*)</span></label><br>
                                <select id="cate" class="form-control" name="news_cat[]" required multiple="multiple">
                                    @if(!empty($list_news_cat))
                                    @foreach($list_news_cat as $news_cat)
                                        @if(in_array($news_cat->news_cat_id, $list_id_cat))
                                            <option value="{{$news_cat->news_cat_id}}"  selected >{{str_repeat('+', $news_cat->level) .$news_cat->name}}</option>
                                        @else
                                            <option value="{{$news_cat->news_cat_id}}">{{str_repeat('+', $news_cat->level) .$news_cat->name}}</option>    
                                        @endif
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <label>{{trans('vne-news::language.form.text.box')}}</label>
                            <select id="box" class="form-control" name="news_box[]" multiple="multiple">
                                @if(!empty($list_news_box))
                                @foreach($list_news_box as $box)
                                    <option value="{{$box->news_box_id}}" @if(in_array($box->news_box_id, $list_id_box)) selected="" @endif>{{$box->name}}</option>
                                @endforeach
                                @endif
                            </select>
                            <div class="form-group area-tag">
                                <label>{{trans('Thêm tag')}}</label><br>
                                <div class="input-group">
                                    <input type="text" name="news_tag_add" value="" class="form-control" placeholder="{{trans('vne-news::language.form.tags_placeholder')}}" id="text-tag">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" id="add-tag">Thêm</button> <br>
                                    </span>
                                 </div>
                                <p style="color: red"> Các tag cách nhau bằng dấu phẩy</p>
                                <label>{{trans('Chọn tag')}}</label>
                                <select id="tag" class="form-control" name="news_tag[]" multiple="multiple">
                                    @if(!empty($list_news_tag))
                                    @foreach($list_news_tag as $nt)
                                        <option value="{{$nt->news_tag_id}}" @if(in_array($nt->news_tag_id, $list_id_tag)) selected="" @endif>{{$nt->name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <label>{{trans('vne-news::language.form.text.image')}}</label>
                            <div class="input-group">
                               <span class="input-group-btn">
                                 <a id="lfm2" data-input="thumbnail2" data-preview="holder2" class="btn btn-primary">
                                   <i class="fa fa-picture-o"></i> Choose 
                                 </a>
                               </span>
                               <input id="thumbnail2" class="form-control" type="text" value="{{$news->image}}" name="image">
                             </div>
                             <img id="holder2" src="{{$news->image}}" style="margin-top:15px;max-height:100px;">
                            <div class="form-group">
                                <input type="radio" id="hot" @if($news->is_hot==1) checked @endif name="is_hot" value="1">
                                <label for="hot">{{trans('vne-news::language.form.text.news_hot')}}    </label>
                                <input type="radio" @if($news->is_hot==2) checked @endif id="normal" name="is_hot" value="2">
                                <label for="normal">    {{trans('vne-news::language.form.text.news_normal')}}</label>
                            </div>
                            <div class="form-group">
                                <label>{{trans('vne-news::language.form.text.priority')}}</label>
                                <input class="form-control" type="number" name="priority" value="{{$news->priority}}" placeholder="{{trans('vne-news::language.form.priority_placeholder')}}">
                            </div>
                            <div class="form-group">
                                <label>{{trans('vne-news::language.form.text.key_seo')}}</label> <br>
                                <input type="text" name="key_word_seo[]" value="{{$list_key_word_seo_string}}" class="form-control" data-role="tagsinput" placeholder="{{trans('vne-news::language.form.seo_key_word_placeholder')}}">
                            </div>
                            <div class="form-group">
                                <label>{{trans('vne-news::language.form.text.desc_seo')}}</label>
                                <textarea rows="5" cols="101" name="desc_seo" class="form-control" placeholder="{{trans('vne-news::language.form.desc_seo_placeholder')}}">{{$news->desc_seo}}</textarea>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-success">{{trans('vne-news::language.buttons.update')}}</button>
                            <a href="" class="btn btn-danger">{{trans('vne-news::language.buttons.discard')}}</a>
                        </div>
                        <!-- /.col-sm-8 -->
                    </div>
                    <!-- /.row -->
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
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin .'/vendors/bootstrap-tagsinput/js/bootstrap-tagsinput.js') }}" type="text/javascript" ></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin .'/vendors/select2/js/select2.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin .'/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin .'/vendors/bootstrap-multiselect/js/bootstrap-multiselect.js') }}"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin .'/vne/news/js/news/add.js') }}" type="text/javascript" ></script>
    <script src="{{ asset('/vendor/laravel-filemanager/js/lfm.js') }}" type="text/javascript" ></script>
    <script src="{{ asset('/vendor/laravel-filemanager/js/lfm2.js') }}" type="text/javascript" ></script>
    <!--end of page js-->
    <script>
      var options = {
        filebrowserImageBrowseUrl: '/admin/laravel-filemanager?type=Images',
        filebrowserImageUploadUrl: '/admin/laravel-filemanager/upload?type=Images&_token=',
        filebrowserBrowseUrl: '/admin/laravel-filemanager?type=Files',
        filebrowserUploadUrl: '/admin/laravel-filemanager/upload?type=Files&_token='
      };
        CKEDITOR.replace('ckeditor',options);
        var domain = "/admin/laravel-filemanager/";
        $("#lfm1").filemanager2('image', {prefix: domain});
        $('#lfm2').filemanager('image', {prefix: domain});
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#cate').multiselect({
                buttonWidth: '100%',
                nonSelectedText: 'Chọn danh mục',
                enableFiltering: true,
            });
            $('#box').multiselect({
                buttonWidth: '100%',
                nonSelectedText: 'Chọn box',
                enableFiltering: true,
            });
            $('#tag').multiselect({
                buttonWidth: '100%',
                nonSelectedText: 'Chọn tag',
                enableFiltering: true,
            });
            $('#form-edit-news').bootstrapValidator({
                feedbackIcons: {
                    // validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    title: {
                        validators: {
                            notEmpty: {
                                message: 'Bạn chưa nhập tiêu đề'
                            },
                            stringLength: {
                                max: 250,
                                message: 'Tiêu đề không được quá dài'
                            }
                        }
                    },
                    desc_seo: {
                        validators: {
                            stringLength: {
                                max: 500,
                                message: 'Mô tả không được quá dài'
                            }
                        }
                    },
                    image: {
                        trigger: 'change keyup',
                        validators: {
                            notEmpty: {
                                message: 'Trường này không được bỏ trống'
                            }
                        }
                    }
                }
            });  
            
            // $('body').on('click','.type_news',function(e){
            //     var type = $(this).val();
            //     if(type==1) {
            //         $(".area-new-image").css("display", "none");
            //         $(".area-new-text").css("display", "block");
            //     }
            //     else if(type==2) {
            //         $(".area-new-image").css("display", "block");
            //         $(".area-new-text").css("display", "none");
            //     }
            // });

            $('body').on('click','#add-tag',function(e){
                e.preventDefault();
                var list_tag = $('#text-tag').val();
                var i;
                if(list_tag!=''){
                    $.ajax({
                        url: "{{route('vne.news.tag.ajax.add')}}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name=csrf-token]').prop('content')
                        },
                        type: 'POST',
                        cache: false,
                        data: {
                            'list_tag': list_tag
                        },
                        success: function (response) {
                            var text = '';
                            var data = JSON.parse(response);
                            for( i in data){
                                text += '<option value="'+data[i].news_tag_id+'" selected="">'+data[i].name+'</option>';
                            }
                            $('#tag').prepend(text);
                            $('#tag').multiselect('rebuild');
                        }
                    }, 'json');
                }
            });  
        });
        function setData(data) {
            $("#list-item").css('display', 'block');
            $("#type_control").val(data.type_file);
            var html = '';
            html += '<tr class="/files/' + data.title + '">';    
            html += '<td>';
            if(data.type_file ==='img')
            {
                html += '<img src="' + data.src + '" width="75px">'
            }else{
                html += '<i class="fa fa-file fa-5x"></i>';
            }
            html +='</td>';
            html += '<td>' + data.title + '</td>';
            html += '<td><a href="javascrip::void(0,0)"  class="btn btn-danger del-media" >';
            html += '<span style="margin:0px;" class="glyphicon glyphicon-trash" aria-hidden="true"></span>';
            html += '</a></td>'
            html += '<input type="hidden" name="file_names[]"  value="' + data.title + '">';
            html += '<input type="hidden" name="file_links[]"  value="' + data.src + '">';
            html += '<input type="hidden" name="file_types[]"  value="' + data.type + '">';
            html += '</tr>';
            if ($("tr").hasClass('/files/'+data.title)) {
                
            } else
            {         
                 $("#list-file").append(html);
            }       
        }
        function reSetData() {
            $("#icon_file").html('<i class="fa fa-file fa-5x"></i>');
            $("#list-item").css('display', 'none');   
            $("#icon_file").append('');
        }
        $('body').on('click', '.del-media', function () {
                $(this).parent().parent().remove();
        });
        $('body').on('change','.choice-type',function(){
            $("#list-file").html('');
        }); 
        //sort table
        var fixHelperModified = function (e, tr) {
        var $originals = tr.children();
        var $helper = tr.clone();
        $helper.children().each(function (index) {
            $(this).width($originals.eq(index).width());
        });
            return $helper;
        };

        $("tbody.sortable").sortable({
            stop: function (event, ui) {
                $(this).find('tr').each(function (i) {
                    $(this).find('td:first').text(i + 1);
                });
            }
        });


        $(".table-sortable tbody").sortable({
            helper: fixHelperModified
        }).disableSelection();

        $(".table-sortable thead").disableSelection();
    </script>
@stop
