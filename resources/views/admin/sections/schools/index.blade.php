@extends('admin.layouts.master')

@section('title', 'Edu Cnpt')

@section('contents')

@livewire('schools.search-school')
@livewire('schools.list-school')
@livewire('schools.crud-school')

@endsection