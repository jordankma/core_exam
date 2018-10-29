@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('vne-member::language.titles.member.manage') }}@stop

{{-- page level styles --}}
@section('header_styles')
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/css/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/tables.css') }}" rel="stylesheet" type="text/css"/>
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
                        @if ($USER_LOGGED->canAccess('vne.member.member.create'))
                            <a href="{{ route('vne.member.member.create') }}" class="btn btn-sm btn-default"><span
                        class="glyphicon glyphicon-plus"></span> {{ trans('vne-member::language.buttons.create') }}</a>
                        @endif
                    </div>
                </div>
                <br/>
                <div style="margin-left:20px">
                    <div style="display: inline-block;">
                        @if ($USER_LOGGED->canAccess('vne.member.member.excel.get.import'))
                        <a href="{{route('vne.member.member.excel.get.import')}}" class="btn btn-success">
                            <i class="fa fa-picture-o"></i> Import Excel
                        </a>
                        @endif
                    </div>
                    {{-- <div style="display: inline-block;">
                        <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-success">
                            <i class="fa fa-picture-o"></i> Export Excel
                        </a>
                    </div> --}}
                </div>
                @if (count($errors)>0) 
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $loi)
                            {{$loi}}<br>
                        @endforeach   
                    </div>
                @endif
                @if (session('thongbao'))
                    <div class="alert alert-success">
                        {{session('thongbao')}}    
                    </div>   
                @endif
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table">
                            <thead>
                            <tr class="filters">
                                <th class="fit-content">#</th>
                                <th>{{ 'ID' }}</th>
                                <th>{{ trans('vne-member::language.table.member.name') }}</th>
                                <th>{{ trans('vne-member::language.table.member.u_name') }}</th>
                                <th>{{ trans('vne-member::language.table.member.email') }}</th>
                                <th>{{ trans('vne-member::language.table.member.phone') }}</th>
                                <th>{{ trans('vne-member::language.table.member.birthday') }}</th>
                                <th>{{ 'Đơn vị' }}</th>
                                <th class="fit-content">{{ trans('vne-member::language.table.action') }}</th>
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
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/js/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/js/dataTables.bootstrap.js') }}"></script>
    <script src="{{ asset('/vendor/laravel-filemanager/js/lfm.js') }}" type="text/javascript" ></script>
    <script>
        $(function () {
            var table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('vne.member.member.data') }}',
                columns: [
                    { data: 'DT_Row_Index', name: 'member_id' },
                    { data: 'member_id', name: 'member_id' },
                    { data: 'name', name: 'name' },
                    { data: 'u_name', name: 'u_name' },
                    { data: 'email', name: 'email' },
                    { data: 'phone', name: 'phone' },
                    { data: 'birthday', name: 'birthday' },
                    { data: 'don_vi', name: 'don_vi' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'fit-content'}
                ]
            });
            table.on('draw', function () {
                $('.livicon').each(function () {
                    $(this).updateLivicon();
                });
            });
            var domain = "/admin/laravel-filemanager/";
            $('#lfm').filemanager('file', {prefix: domain});
        });

    </script>

    <div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>
    <div class="modal fade" id="reset_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>
    <div class="modal fade" id="block_confirm" tabindex="-1" role="dialog" aria-labelledby="user_block_confirm_title"
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
