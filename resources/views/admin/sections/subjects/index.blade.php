@extends('admin.layouts.master')

@section('title', 'Edu Cnpt')

@section('contents')

@livewire('subjects.list-subject')
@livewire('subjects.crud-subject')

@endsection