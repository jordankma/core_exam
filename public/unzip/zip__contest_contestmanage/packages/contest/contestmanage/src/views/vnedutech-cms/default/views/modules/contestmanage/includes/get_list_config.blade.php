<link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/css/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/tables.css') }}" rel="stylesheet" type="text/css"/>
<div class="row">
    <div class="panel panel-primary ">
        <div class="panel-heading clearfix">
            <h4 class="panel-title pull-left"><i class="livicon" data-name="users" data-size="16"
                                                 data-loop="true" data-c="#fff" data-hc="white"></i>
Danh sách {{$title}}
</h4>
</div>
<br/>
<div class="panel-body">
    <div class="table-responsive">
        <table class="table table-bordered" id="table_item">
            <thead>
            <tr class="filters">
                <th class="fit-content">{{ trans('contest-contestmanage::language.table.id') }}</th>
                <th>{{ trans('contest-contestmanage::language.table.contest_config.name') }}</th>
                <th>{{ trans('contest-contestmanage::language.table.contest_config.environment') }}</th>
                <th>{{ trans('contest-contestmanage::language.table.contest_config.option') }}</th>
                <th>{{ trans('contest-contestmanage::language.table.contest_config.description') }}</th>
                <th>{{ trans('contest-contestmanage::language.table.action') }}</th>
            </tr>
            </thead>
        </table>
    </div>
</div>
</div>
</div>

<script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/js/jquery.dataTables.js') }}"></script>
<script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/js/dataTables.bootstrap.js') }}"></script>
<script>
    var table = $('#table_item').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            "url":'{{ route('contest.contestmanage.contest_config.data') }}',
            "data":{
                "type": '{!! $type !!}'
            }
        },
        columns: [
            { data: 'config_id', name: 'config_id' },
            { data: 'name', name: 'name' },
            { data: 'environment', name: 'environment' },
//            { data: 'config_option', name: 'config_option' },
            { data: 'config_option', name: 'config_option', "render": function (data) {
                var option = @json($option);
                return option[data];
            } },
            { data: 'description', name: 'description' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'fit-content'}
        ]
    });
    table.on('draw', function () {
        $('.livicon').each(function () {
            $(this).updateLivicon();
        });
    });
    table.on( 'order.dt search.dt', function () {
        table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
</script>

