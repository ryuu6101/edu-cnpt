@extends('admin.layouts.master')

@section('title', 'Edu Cnpt')

@section('contents')

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header header-elements-inline bg-vnpt text-white">
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
                    <div class="row border-bottom mb-4">
                        <div class="col-12 text-center mb-2">
                            <strong>Nhập file CSDL</strong>
                            {{-- <i class="icon-arrow-right14 mx-2"></i> --}}
                            <span class="mx-2">/</span>
                            <a href="{{ route('vnedu-import.index') }}"><span class="text-muted">Nhập file EDU</span></a>
                        </div>
                        {{-- <div class="col-12 text-center mb-2">
                            <div class="custom-control custom-control-right custom-switch custom-control-inline">
                                <input type="checkbox" class="custom-control-input" name="redirect" id="redirect_check" checked="">
                                <label class="custom-control-label" for="redirect_check">
                                    Tự động chuyển sang bước tiếp theo
                                </label>
                            </div>
                        </div> --}}
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-4">
                            <div class="custom-file text-left w-100">
                                <input type="file" name="excel" id="excelFileInputCSDL" class="custom-file-input" 
                                accept=".xlsx" onchange="getFileName(this)">
                                <label class="custom-file-label" for="excelFileInputCSDL">
                                    <span class="d-block text-muted text-nowrap overflow-hidden" style="width:75%;text-overflow: ellipsis">
                                        Nhập file CSDL
                                    </span>
                                </label>
                                @error('excel-input')
                                <span class="text-danger mt-3">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-success">Nhập File Excel</button>
                        </div>
                    </div>
                    @livewire('coordinate-presets.coordinate-preset-select')
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function getFileName(input) {
        var filename = input.files[0].name;
        var label = $(input).parent().children("label").children("span");
        label.html(filename);
    }
</script>
@endpush