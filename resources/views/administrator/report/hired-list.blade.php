@extends('layouts.print-layout')

@section('content')
    <hired-list prop-data='@json($data)'></hired-list>
@endsection

