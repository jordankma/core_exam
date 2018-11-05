@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('vne-essay::language.titles.essay.manage') }}@stop

{{-- page level styles --}}
@section('header_styles')
    <link href="{{ config('site.url_static') . '/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/css/dataTables.bootstrap.css' }}" rel="stylesheet" type="text/css"/>
    <link href="{{ config('site.url_static') . '/vendor/' . $group_name . '/' . $skin . '/css/pages/tables.css' }}" rel="stylesheet" type="text/css"/>
@stop


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

    <!-- Main content -->
    <section class="content paddingleft_right15">
        <div class="row">
            <div class="panel panel-primary ">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title pull-left">
                        <i class="livicon" data-name="users" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        {{ $title }}
                    </h4>
                    <div class="pull-right">
                        @if ($USER_LOGGED->canAccess('vne.essay.essay.create'))
                        <a href="{{ route('vne.essay.essay.create') }}" class="btn btn-sm btn-default">
                            <span class="glyphicon glyphicon-plus"></span> {{ trans('vne-essay::language.buttons.create') }}
                        </a>
                        @endif
                    </div>
                </div>
                <br/>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table">
                            <thead>
                            <tr class="filters">
                                <th class="fit-content">{{ trans('adtech-core::common.sequence') }}</th>
                                <th>{{ trans('vne-essay::language.table.essay.name') }}</th>
                                <th>{{ trans('vne-essay::language.table.essay.name_topic') }}</th>
                                <th>{{ trans('vne-essay::language.table.essay.name_member_exam') }}</th>
                                <th style="width: 120px">{{ trans('vne-essay::language.table.created_at') }}</th>
                                <th style="width: 120px">{{ trans('vne-essay::language.table.updated_at') }}</th>
                                <th>{{ trans('vne-essay::language.table.action') }}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>    <!-- row-->
    </section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script type="text/javascript" src="{{ config('site.url_static') . '/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/js/jquery.dataTables.js' }}"></script>
    <script type="text/javascript" src="{{ config('site.url_static') . '/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/js/dataTables.bootstrap.js' }}"></script>

    <script>
        $(function () {
            var table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('vne.essay.essay.data') }}',
                columns: [
                    { data: 'DT_Row_Index', name: 'essay_id' },
                    { data: 'name', name: 'name' },
                    { data: 'essay_topic', name: 'essay_topic' },
                    { data: 'member', name: 'member' },
                    { data: 'created_at', name: 'created_at'},
                    { data: 'updated_at', name: 'updated_at'},
                    { data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'fit-content'}
                ]
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
