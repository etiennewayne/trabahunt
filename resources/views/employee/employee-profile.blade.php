@extends('layouts.app-employee')

@section('content')
    <employee-profile prop-user-id='{{ $id }}'></employee-profile>
@endsection
