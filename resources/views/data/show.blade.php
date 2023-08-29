@extends('layouts.app')

@section('content')
    <p>{{ $code }}</p>
    <a href="{{ url('download/' . $key) }}">download</a>
@endsection
