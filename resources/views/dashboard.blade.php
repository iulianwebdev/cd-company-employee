@extends('layouts.admin_lte')

@section('heading')
    <h1>
        Overall view
        <small>Admin panel</small>
    </h1>
@endsection

@section('content')
    <component :is="activeComponent"></component>
@endsection