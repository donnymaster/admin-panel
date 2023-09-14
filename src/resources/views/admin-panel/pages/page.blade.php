@extends('admin-panel.layouts.main')

@section('title', $pageName)

@section('content')
    <p>{{$pageName}}</p>
@endsection

@section('sidebar')
    <x-admin.sidebar.pages />
@endsection
