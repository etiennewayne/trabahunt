@extends('layouts.user')

@section('content')
    <welcome-page prop-categories='@json($categories)'
                  prop-job-types='@json($jobTypes)'></welcome-page>
@endsection
