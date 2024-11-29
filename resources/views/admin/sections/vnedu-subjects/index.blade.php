@extends('admin.layouts.master')

@section('title', 'Edu Cnpt')

@section('contents')

@livewire('vnedu-subjects.list-vnedu-subject')
@livewire('vnedu-subjects.crud-vnedu-subject')

@endsection