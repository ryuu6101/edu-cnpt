@extends('admin.layouts.master')

@section('title', 'Edu Cnpt')

@section('contents')

@livewire('coordinate-presets.list-coordinate-preset')
@livewire('coordinate-presets.crud-coordinate-preset')

@endsection