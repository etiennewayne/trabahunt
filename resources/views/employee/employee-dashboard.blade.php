@extends('layouts.app')

@section('content')
    <employee-dashboard prop-user='@json($user)'></employee-dashboard>
@endsection
