@extends('layouts.app')

@section('headcode')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}" />
@endsection

@section('content')
    @include('_partials.search_form')
    <div class="content-header">
        <div class="callout callout-info pt-2">
            <small><span class="text-danger">Disclaimer :</span> This app is intended to serve only as a way to quickly find vaccine availability information. User will have to book their vaccination slots via the official channels like Aarogya Setu app, CoWin portal/app etc. Data is fetched in real time from <a href="https://apisetu.gov.in/public/marketplace/api/cowin">CoWin Public APIs</a>.</small>
        </div>
    </div>
@endsection

@section('scriptcode')
    <!-- Select2 -->
<script src="{{asset('assets/plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-validation/additional-methods.min.js')}}"></script>
<script>
    let hospitalImg = '{{asset('assets/dist/img/hospital.ico')}}';
</script>
<script src="{{asset('assets/dist/js/app.js')}}"></script>

    
@endsection