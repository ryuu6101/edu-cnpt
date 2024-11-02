@extends('admin.layouts.master')

@section('title', 'Edu Cnpt')

@section('contents')

@livewire('classes.list-class', ['school_id' => $school_id])
@livewire('classes.crud-class', ['school_id' => $school_id])

@endsection