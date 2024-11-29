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
                <form action="{{ route('vnedu.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="row border-bottom mb-4">
                        <div class="col-12 text-center mb-2">
                            <a href="{{ route('excel-import.index') }}"><span class="text-muted">Nhập file CSDL</span></a>
                            {{-- <i class="icon-arrow-right14 mx-2"></i> --}}
                            <span class="mx-2">/</span>
                            <strong>Nhập file EDU</strong>
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
                    <div class="row justify-content-center mt-2">
                        <div class="col-5">
                            <div class="custom-file text-left w-100">
                                <input type="file" name="excel" id="excelFileInputEDU" class="custom-file-input" 
                                accept=".xls" onchange="getFileName(this)">
                                <label class="custom-file-label text-muted" for="excelFileInputEDU">Nhập file EDU</label>
                                @error('excel-input')
                                <span class="text-danger mt-3">{{ $message }}</span>
                                @enderror
                            </div>
                            {{-- <input type="file" name="excel" class="form-control" accept=".xlsx,.xls"> --}}
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-success">Nhập File Excel</button>
                        </div>
                    </div>
                </form>

                @if (session('student_error'))
                <div class="row justify-content-center mt-3">
                    <div class="col-auto">
                        <div class="table-responsive mb-2">
                            <table class="table table-sm table-bordered table-dark align-middle text-nowrap">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center"></th>
                                        <th scope="col" class="text-center">Có bên EDU không có bên CSDL</th>
                                        <th scope="col" class="text-center"></th>
                                        <th scope="col" class="text-center">Có bên CSDL không có bên EDU</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php($students = session('student_error')['students'])
                                    @php($vnedu_students = session('student_error')['vnedu_students'])
                                    @for ($index = 0; true; $index++)
                                    <tr>
                                        @break(!(isset($students[$index]) || isset($vnedu_students[$index])))
                                        @php($student = $students[$index] ?? '')
                                        @php($vnedu_student = $vnedu_students[$index] ?? '')
                                        @if (($student == '') || in_array($student, $vnedu_students))
                                        <td class="text-left">{{ $student }}</td>
                                        @else
                                        <td class="text-left bg-danger">{{ $student }}</td>
                                        @endif
                                        @if (($vnedu_student == '') || in_array($vnedu_student, $students))
                                        <td class="text-left">{{ $vnedu_student }}</td>
                                        <td class="text-left">{{ $vnedu_student }}</td>
                                        @else
                                        <td class="text-left bg-primary">{{ $vnedu_student }}</td>
                                        <td class="text-center bg-primary">N/A</td>
                                        @endif
                                        @if (($student == '') || in_array($student, $vnedu_students))
                                        <td class="text-left">{{ $student }}</td>
                                        @else
                                        <td class="text-center bg-danger">N/A</td>
                                        @endif
                                    </tr>
                                    @endfor
                                </tbody>
                            </table>
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
        var label = $(input).parent().children("label");
        label.html(filename);
    }
</script>
@endpush