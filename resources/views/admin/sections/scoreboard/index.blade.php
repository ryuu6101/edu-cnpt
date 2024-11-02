@extends('admin.layouts.master')

@section('title', 'Edu Cnpt')

@section('contents')

@livewire('scoreboards.scoreboard-detail', ['vnedu_file_id' => $vnedu_file_id])

@endsection