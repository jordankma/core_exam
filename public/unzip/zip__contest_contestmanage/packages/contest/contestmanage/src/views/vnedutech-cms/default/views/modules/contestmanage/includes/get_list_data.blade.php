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
                @if($type == 'season')
                    <th class="fit-content">{{ trans('contest-contestmanage::language.table.id') }}</th>
                    <th>{{ trans('contest-contestmanage::language.table.contest_season.name') }}</th>
                    <th>{{ trans('contest-contestmanage::language.table.contest_season.number') }}</th>
                    <th>{{ trans('contest-contestmanage::language.table.contest_season.description') }}</th>
                    <th>{{ trans('contest-contestmanage::language.table.contest_season.start') }}</th>
                    <th>{{ trans('contest-contestmanage::language.table.contest_season.end') }}</th>
                    <th>{{ trans('contest-contestmanage::language.table.action') }}</th>
                @elseif($type == 'round')
                    <th class="fit-content">{{ trans('contest-contestmanage::language.table.id') }}</th>
                    <th>{{ trans('contest-contestmanage::language.table.contest_round.name') }}</th>
                    <th>{{ trans('contest-contestmanage::language.table.contest_round.description') }}</th>
                    <th>{{ trans('contest-contestmanage::language.table.action') }}</th>
                @elseif($type == 'topic')
                    <th class="fit-content">{{ trans('contest-contestmanage::language.table.id') }}</th>
                    <th>{{ trans('contest-contestmanage::language.table.contest_topic.name') }}</th>
                    <th>{{ trans('contest-contestmanage::language.table.contest_topic.description') }}</th>
                    <th>{{ trans('contest-contestmanage::language.table.action') }}</th>
                @else
                    <th class="fit-content">{{ trans('contest-contestmanage::language.table.id') }}</th>
                    <th>{{ trans('contest-contestmanage::language.table.topic_round.name') }}</th>
                    <th>{{ trans('contest-contestmanage::language.table.topic_round.description') }}</th>
                    <th>{{ trans('contest-contestmanage::language.table.action') }}</th>
                @endif
            </tr>
            </thead>
        </table>
    </div>
</div>
</div>
</div>

<script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/js/jquery.dataTables.js') }}"></script>
<script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/js/dataTables.bootstrap.js') }}"></script>
@if($type == 'season')
    <script>
        var table = $('#table_item').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                "url":'{{ route('api.contest.data') }}',
                "data":{
                    "type": '{!! $type !!}'
                }
            },
            columns: [
                { data: 'season_id', name: 'season_id' },
                { data: 'name', name: 'name' },
                { data: 'number', name: 'number' },
                { data: 'description', name: 'description' },
                { data: 'start_date', name: 'start_date',defaultContent:"","render":function (data) {

                } },
                { data: 'end_date', name: 'end_date',defaultContent:"","render":function (data) {

                } },
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
@elseif($type == 'round')
    <script>
        var table = $('#table_item').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                "url":'{{ route('api.contest.data') }}',
                "data":{
                    "type": '{!! $type !!}'
                }
            },
            columns: [
                { data: 'round_id', name: 'round_id' },
                { data: 'display_name', name: 'display_name' },
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
@elseif($type == 'topic')
    <script>
        var table = $('#table_item').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                "url":'{{ route('api.contest.data') }}',
                "data":{
                    "type": '{!! $type !!}'
                }
            },
            columns: [
                { data: 'topic_id', name: 'topic_id' },
                { data: 'display_name', name: 'display_name' },
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
@else
    <script>
        var table = $('#table_item').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                "url":'{{ route('api.contest.data') }}',
                "data":{
                    "type": '{!! $type !!}'
                }
            },
            columns: [
                { data: 'topic_round_id', name: 'topic_round_id' },
                { data: 'display_name', name: 'display_name' },
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
@endif

