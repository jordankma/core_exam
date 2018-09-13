@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('vne-news::language.titles.news_tag.list') }} @stop
{{-- page styles --}}
@section('header_styles')
     <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/css/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css"/>
     <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/tables.css') }}" rel="stylesheet" type="text/css"/>
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
    @if (Session::has('success'))
        <div class="alert alert-success">{{Session::get('success')}}</div>
    @endif
    @if (Session::has('error'))
        <div class="alert alert-error">{{Session::get('error')}}</div>
    @endif
   <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!--lg-6 starts-->
                <!--basic form starts-->
                <div class="panel panel-primary" id="hidepanel1">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title pull-left">{{ $title }}</h4>
                        <div class="pull-right">
                            @if ($USER_LOGGED->canAccess('vne.news.tag.create'))
                                <a href="{{ route('vne.news.tag.create') }}" class="btn btn-sm btn-default"><span
                                        class="glyphicon glyphicon-plus"></span> {{ trans('adtech-core::buttons.create') }}</a>
                            @endif
                        </div>
                    </div>
                    <hr>
                <div id='reload-spe-sub'>
                    <div class="panel-body ">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="table">
                                <thead>
                                    <tr>                                             
                                        <th class="fit-content">#</th>
                                        <th>{{ trans('vne-news::language.table.list_news.title') }}</th>
                                        {{-- <th style="width: 120px">{{ trans('vne-news::language.table.created_at') }}</th> --}}
                                        {{-- <th style="width: 120px">{{ trans('vne-news::language.table.updated_at') }}</th> --}}
                                        <th class="fit-content" style="width: 100px">{{ trans('vne-news::language.table.action') }}</th>
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
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin .'/vendors/datatables/js/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin .'/vendors/datatables/js/dataTables.bootstrap.js') }}"></script>
    <!--end of page js-->
    {{-- <script type="text/javascript">
        $(document).ready(function() {
            $('#table').DataTable();
        });
    </script> --}}
    <script>
        $(function () {
            var table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('vne.news.tag.data') }}',
                columns: [
                    { data: 'DT_Row_Index', name: 'news_tag_id' },
                    { data: 'name', name: 'name' },
                    // { data: 'created_at', name: 'created_at'},
                    // { data: 'updated_at', name: 'updated_at'},
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
