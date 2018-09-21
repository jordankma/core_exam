@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('dhcd-topic::language.titles.topic.add_member') }}@stop

{{-- page styles --}}
@section('header_styles')
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/css/bootstrap-switch.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/blog.css') }}" rel="stylesheet" type="text/css">
@stop
<!--end of page css-->
<style type="text/css">
    #content-right .twitter-typeahead{
        width: 100%;
    }
    #list_members{
        max-height: 500px;
        overflow: auto;
    }
</style>

{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>{{ $title }}</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('backend.homepage') }}">
                    <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                    {{ trans('dhcd-topic::language.labels.home') }}
                </a>
            </li>
            <li class="active"><a href="#">{{ $title }}</a></li>
        </ol>
    </section>
    <!--section ends-->
    <section class="content paddingleft_right15">
        <!--main content-->
        <div class="row">
            <div class="col-md-12">
                <!--lg-6 starts-->
                <!--basic form starts-->
                <div class="panel panel-primary" id="hidepanel1">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Add User Topic    
                        </h3>
                    </div>
                    <div id="btnToolbarMember" style=" padding-left: 50%; padding-top: 10px; ">
                        
                    </div>
                    <div class="panel-body"> 
                        <div class="row">
                            <div class="col-md-6">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="table">
                                        <thead>
                                        <tr class="filters">
                                            <th class="fit-content">#</th>
                                            <th>{{ trans('dhcd-member::language.table.group.name') }}</th>
                                            {{-- <th>{{ trans('dhcd-member::language.table.group.position') }}</th> --}}
                                            <th class="fit-content" style="width: 100px">{{ trans('dhcd-topic::language.table.delete') }}</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-6" id="content-right">
                                <div id="typeaheadmulti">
                                    
                                <input type="text" id="searchProduct" name="keyword" class="typeahead form-control" placeholder="Nhập tên người cần thêm" required="">
                                </div>
                                <div id="resultSearch">
                                    <form action="{{route('dhcd.member.group.add.member',['group_id'=>$group_id])}}" method="post">
                                        <input type='hidden' name="_token" value="{!! csrf_token() !!}">
                                        <ul class="list-group" id="list_members">
                                        </ul>
                                        <button type="submit" class="btn btn-primary">Thêm</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                    </div>   
                </div>
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
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/js/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/js/dataTables.bootstrap.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/typeahead/js/bloodhound.min.js') }}"></script><script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/typeahead/js/typeahead.bundle.min.js') }}"></script>
    <!--end of page js-->
    <script>
        $(function () {
            $("[name='permission_locked']").bootstrapSwitch();
        })
    </script>
    <script type="text/javascript">
        var table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('dhcd.member.group.data.member',['group_id' => $group_id]) }}',
            columns: [
                { data: 'DT_Row_Index', name: 'DT_Row_Index' },
                { data: 'name', name: 'name' },
                // { data: 'position_id', name: 'position_id' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'fit-content'}
            ]
        });
        table.on('draw', function () {
            $('.livicon').each(function () {
                $(this).updateLivicon();
            });
        }); 
        // delete member
        var selected = 0;
        var selectedArr = [];
        var routeDelete = '{{ route('dhcd.member.group.confirm-delete.member') }}';
        var group_id = '{{$group_id}}';
        var htmlBtnToolbar = document.getElementById('btnToolbarMember').innerHTML;
        $('#table tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Open this row
                row.child(format(row.data())).show();
                tr.addClass('shown');
            }

            $('input[type="checkbox"].square').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
                increaseArea: '20%'
            });
        }).on( 'click', '.select-member', function () {
            var id = this.id;
            var index = $.inArray(id, selectedArr);
            if ( index === -1 ) {
                selectedArr.push( id );
            } else {
                selectedArr.splice( index, 1 );
            }
            $(this).toggleClass('selected');
            var moreHtml = '<a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete_member_topic_confirm" href="' + routeDelete + '?member=' + selectedArr + '&group_id='+group_id+'">\n' +
            '                            <span class="glyphicon glyphicon-trash"></span>\n Delete member\n' +
            '                        </a>';
            document.getElementById('btnToolbarMember').innerHTML = moreHtml + htmlBtnToolbar;
        });

        /* Formatting function for row details - modify as you need */
        function format ( d ) {
            // `d` is the original data object for the row
            return d.methods;
        }
        //end delete member
        //add member
        var delay = (function(){
          var timer = 0;
          return function(callback, ms){
            clearTimeout (timer);
            timer = setTimeout(callback, ms);
          };
        })();
        $("input.typeahead").keyup(function(){
            delay(function(){
                var keyword = $('.typeahead').val();
                var url = '/admin/dhcd/member/group/search/member?keyword='+keyword+'&group_id='+group_id;
                $.get(url, function(data){
                    var i,text = '';
                    var obj_data = JSON.parse(data);
                    if(obj_data.length>0){
                        for (i in obj_data) {
                            text += '<li class="list-group-item"><input id="m-del-' + obj_data[i].member_id + '" type="checkbox" name="list_members[]" value="'+obj_data[i].member_id+'">  <label for="m-del-' + obj_data[i].member_id + '">' + '  ' + escapeHtml(obj_data[i].name) + ' - ' + obj_data[i].position_current + '</label></li>';
                        }
                        $('#list_members').html('');
                        $('#list_members').append(text);
                    }
                    else{
                        $('#list_members').html('<span class="red"> Không tìm thấy người dùng thỏa mãn </span>');        
                    }
                });
            }, 500 );
        });
        function escapeHtml(text) {
            var map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return text.replace(/[&<>"']/g, function(m) { return map[m]; });
        }
        //end add member
    </script>
    <div class="modal fade" id="delete_member_topic_confirm" tabindex="-1" role="dialog" aria-labelledby="delete_member_topic_confirm"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>
@stop
