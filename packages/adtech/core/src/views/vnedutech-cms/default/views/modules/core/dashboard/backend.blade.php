@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('adtech-core::titles.role.create') }}@stop

{{-- page styles --}}
@section('header_styles')
@stop


{{-- Page content --}}
@section('content')
    <h1 style="margin: 100px auto; text-align: center">BACKEND PAGE</h1>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <!-- begining of page js -->
    <!--end of page js-->
@stop
