@extends('layouts.app-employer')

@section('content')
    <employer-job-post :prop-job-types='@json($jobtypes)' :prop-categories='@json($categories)'
        prop-company-id="{{ $companyId }}">
    </employer-job-post>
@endsection
