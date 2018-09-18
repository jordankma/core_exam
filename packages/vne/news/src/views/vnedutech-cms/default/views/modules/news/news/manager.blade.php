@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('vne-news::language.titles.news.list') }} @stop
{{-- page styles --}}
@section('header_styles')
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/select2/css/select2-bootstrap.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin .'/vendors/daterangepicker/css/daterangepicker.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css"/>
     <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/tables.css') }}" rel="stylesheet" type="text/css"/>
     <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/css/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css"/>
     <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vne/news/css/news/list.css') }}" rel="stylesheet" type="text/css"/>
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
   <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!--lg-6 starts-->
                <!--basic form starts-->
                <div class="panel panel-primary" id="hidepanel1">
                <div class="panel-heading clearfix">
                    {{ $title}}
                    <div class="pull-right">
                        @if ($USER_LOGGED->canAccess('vne.news.news.create'))
                            <a href="{{ route('vne.news.news.create') }}" class="btn btn-sm btn-default">
                                <span class="glyphicon glyphicon-plus"></span> {{ trans('adtech-core::buttons.create') }}</a>
                        @endif
                    </div>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" name='search-form' id='search-form' action="{{route('vne.news.news.manager')}}" method="get">
                        {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}"/> --}}
                        <input type="hidden" name="visible" value="1"/>
                        <fieldset>
                            <div class='col-md-6'>
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="name">{{ trans('vne-news::language.table.list_news.title') }}</label>
                                    <div class="col-md-8">
                                        <input id="name" name="name" type="text"  value="{{isset($request->name)?$request->name:null}}" class="form-control">
                                    </div>                                  
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label" >{{ trans('vne-news::language.table.list_news.category') }}</label>
                                    <div class="col-md-8">
                                        <select class="form-control" name="news_cat">
                                            <option></option>
                                            @if(!empty($list_news_cat))
                                            @foreach($list_news_cat as $news_cat)
                                                <option value="{{$news_cat->news_cat_id}}">{{$news_cat->name}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label class="col-md-2 control-label" >{{ trans('vne-news::language.table.list_news.box') }}</label>
                                    <div class="col-md-8">
                                        <select class="form-control" name="news_box">
                                            <option></option>
                                            @if(!empty($list_news_box))
                                            @foreach($list_news_box as $news_box)
                                                <option value="{{$news_box->news_box_id}}">{{$news_box->name}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>            
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-2 control-label" >{{ "Time" }}</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="news_time" id="news_time" placeholder="Thời gian">
                                    </div>
                                </div>
                                <div class="form-group" style="margin-left: 42px;">
                                    <input type="radio" name="is_hot" value="1" id="newshot">
                                    <label for="newshot">Tin hot</label>
                                    <input type="radio" name="is_hot" value="2" id="newsnormal">
                                    <label for="newsnormal">Tin thường</label>
                                </div>
                            </div>
                            <div class="col-md-12 col-md-offset-5">
                                <button type='submit' class="btn btn-success" name="search_news" id="but-search-news">Tìm kiếm</button>
                            </div>
                        </fieldset>
                    </form>
                    <hr>
                </div>
                <div id='reload-spe-sub'>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="table">
                                <thead >
                                    <tr>                                             
                                        <th class="fit-content">#</th>
                                        <th>{{ trans('vne-news::language.table.list_news.title') }}</th>
                                        <th>{{ trans('vne-news::language.table.list_news.image') }}</th>
                                        <th>{{ trans('vne-news::language.table.list_news.author') }}</th>
                                        <th>{{ trans('vne-news::language.table.list_news.category') }}</th>
                                        <th class="fit-content">{{ trans('vne-news::language.table.action') }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col col-xs-8">                             
                                
                            </div>                            
                        </div>
                    </div>
                </div>    
            </div>

        </div>
    </div>
</section>
    <!-- End main content -->
@stop
{{-- page level scripts --}}
@section('footer_scripts')
    <!-- begining of page js -->
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/select2/js/select2.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/moment/js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin .'/vendors/datatables/js/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin .'/vendors/datatables/js/dataTables.bootstrap.js') }}"></script>
    <!--end of page js-->
    <script type="text/javascript">
        // $(document).ready(function() {
        //     $('#table').DataTable();
        //     $('#news_time').datetimepicker({
        //         format: 'D-M-YYYY',
        //     });
        // });

    </script>
    <script>
        $(document).ready(function() {
            $('#news_time').datetimepicker({
                format: 'YYYY-M-D',
            });
            var table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('vne.news.news.data', ['name' => $params['name'],'news_time'=>$params['news_time'],'news_cat'=>$params['news_cat'],'is_hot'=>$params['is_hot'],'news_box'=>$params['news_box']]) !!}',
                columns: [
                    { data: 'DT_Row_Index', name: 'news_id' },
                    { data: 'title', name: 'title' },
                    { data: 'image', name: 'image' },
                    { data: 'create_by', name: 'create_by' },
                    { data: 'news_cat', name: 'news_cat' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false}
                ],
                language: $.parseJSON('{!! $DATATABLE_TRANS !!}')
            });
            table.on('draw', function () {
                $('.livicon').each(function () {
                    $(this).updateLivicon();
                });
            });
        });

    </script>

    <div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>
    <div class="modal fade" id="log" tabindex="-1" role="dialog" aria-labelledby="user_log_title"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>
    <script>
        $(function () {
            $('body').on('hidden.bs.modal', '.modal', function () {
                $(this).removeData('bs.modal');
            });
        });
    </script>
@stop
