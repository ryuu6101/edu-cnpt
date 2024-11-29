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

                    <input type="hidden" name="vnedu_file_id" value="{{ $vnedu_file_id }}">

                    <div class="row">
                        <div class="col-4">
                            <label>File excel:</label>
                            <div class="custom-file text-left w-100">
                                <input type="file" name="excel" id="excelFileInputCSDL" class="custom-file-input" 
                                accept=".xlsx" onchange="getFileName(this)">
                                <label class="custom-file-label" for="excelFileInputCSDL">
                                    <span class="d-block text-muted text-nowrap overflow-hidden" style="width:75%;text-overflow: ellipsis">
                                        Nhập file CSDL
                                    </span>
                                </label>
                            </div>
                            @error('excel_input')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-2">
                            <label>Vị trí môn học:</label>
                            <input type="text" class="form-control" name="subject_cell" 
                            value="{{ old('subject_cell') ?? 'F4' }}">
                            @error('subject_cell')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-2">
                            <label>Bắt đầu danh sách:</label>
                            <input type="number" class="form-control hidden-arrow" name="starting_row" 
                            value="{{ old('starting_row') ?? '8' }}">
                            @error('starting_row')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-2">
                            <label>‎</label>
                            <button type="submit" class="btn btn-success btn-block">Nhập File Excel</button>
                        </div>
                        <div class="col-2">
                            <label>‎</label>
                            <a href="{{ route('scoreboard.index', ['file_id' => $vnedu_file_id]) }}" class="btn btn-primary btn-block">
                                <strong><i class="icon-eye mr-1"></i>Xem bảng điểm</strong>
                            </a>
                        </div>
                    </div>
                </form>



                @if(($error_reports = session('error_reports')) != [])
                <div class="row border-top mt-2">
                    <div class="col mt-2">
                        <div class="border rounded p-1">
                            @foreach ($error_reports as $sheet => $reports)
                            <strong>{{ $sheet }}</strong> <br>
                            @foreach ($reports as $report)
                            <span class="text-danger">- (Lỗi) {{ $report }}</span> <br>
                            @endforeach
                            <br>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
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