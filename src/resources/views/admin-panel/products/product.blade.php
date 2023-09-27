@extends('admin-panel.layouts.main')

@section('title', $product->name)

@section('content')
    {{$product->name}}
@endsection

@section('sidebar')
    <x-admin.sidebar.categories item_show="products" />
@endsection
