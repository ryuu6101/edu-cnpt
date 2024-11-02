@extends('admin.layouts.master')

@section('title', 'Edu Cnpt')

@section('contents')

@livewire('students.list-student', ['class_id' => $class_id])

@endsection