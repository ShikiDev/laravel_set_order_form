@extends('layout.front_layout')

@section('content')
    <main-component :tariffs="{{$tariffs}}"></main-component>
@endsection