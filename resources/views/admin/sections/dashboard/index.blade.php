@extends('admin.layouts.master')

@section('title', 'Edu Cnpt')

@section('contents')

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header header-elements-inline bg-secondary text-white">
                <h6 class="card-title">
                    <i class="icon-table2 mr-2"></i>
                    Import file excel
                </h6>
                <div class="header-elements"></div>
            </div>

            <div class="card-body">
                <form action="{{ route('excel.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="row justify-content-center">
                        <div class="col-6 text-center">
                            {{-- <div class="custom-file text-left w-auto">
                                <input type="file" name="excel" id="excelFileInput" class="custom-file-input" accept=".xlsx,.xls">
                                <label class="custom-file-label" for="excelFileInput">Choose file</label>
                            </div> --}}
                            <input type="file" name="excel" class="form-control h-100" accept=".xlsx,.xls">
                        </div>
                        <button type="submit" class="btn btn-success">Nhập File Excel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection