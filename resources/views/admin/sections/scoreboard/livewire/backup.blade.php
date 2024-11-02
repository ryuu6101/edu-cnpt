@if (isset($records_by_subject) && count($records_by_subject) > 0)
<div class="row justify-content-between">
    <div class="col-md col-12 d-flex align-items-center">
        <span class="text-nowrap me-2">Môn học: </span>
        <div>
            <select class="form-control" wire:model.live="selected_subject_id">
                @if (isset($list_subjects) && count($list_subjects) > 0)
                @foreach ($list_subjects as $subject)
                <option value="{{ $subject->id ?? 0 }}" {{ isset($subject->vnedu_subject->id) ? '' : 'disabled' }}>
                    {{ $subject->name }}
                </option>
                @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="col-md col-12 d-flex align-items-center justify-content-end">
        @if ($allow_export)
        <a type="button" class="btn btn-success" href="{{ route('admin.excel.export', $export_params) }}">
            <i class="fa-solid fa-file-excel"></i>
            Xuất file Excel
        </a>
        @else
        <span class="text-danger me-2">
            (!) Vui lòng cấu hình môn học trước khi xuất Excel
        </span>
        <button type="button" class="btn btn-success" disabled>
            <i class="fa-solid fa-file-excel"></i>
            Xuất file Excel
        </button>
        @endif
    </div>
</div>
<div class="row mt-2">
    @php($error_students = $class->students->where('is_error', true))
    @if ($error_students->count() > 0)
    <div class="col drop-down">
        <span class="text-danger" type="button" wire:ignore.self
        data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
            <i class="fa-solid fa-caret-down"></i>
            Có {{ $error_students->count() }} học sinh nhập lỗi!
        </span>
        <div class="dropdown-menu p-1" wire:ignore.self>
            <div class="table-responsive">
                <table class="table table-secondary table-bordered text-nowrap align-middle">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">Mã học sinh</th>
                            <th scope="col" class="text-center">Họ và tên</th>
                            <th scope="col" class="text-center">
                                <button type="button" class="btn btn-sm btn-secondary"
                                wire:click.prevent="deleteErrorStudent()">
                                    Xóa tất cả
                                </button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($error_students as $error_student)
                        <tr>
                            <td>
                                <div class="d-flex justify-content-between">
                                    <span class="me-2">
                                        {{ $error_student->student_code }}
                                    </span>
                                    <span class="text-primary" type="button"
                                    onclick="copyToClipboard('{{ $error_student->student_code }}')">
                                        <i class="fa-regular fa-copy"></i>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex justify-content-between">
                                    <span class="me-2">
                                        {{ $error_student->fullname }}
                                    </span>
                                    <span class="text-primary" type="button"
                                    onclick="copyToClipboard('{{ $error_student->fullname }}')">
                                        <i class="fa-regular fa-copy"></i>
                                    </span>
                                </div>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-secondary"
                                wire:click.prevent="deleteErrorStudent({{ $error_student->id }})">
                                    <i class="fa-solid fa-eraser"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>
<div class="row mt-2">
    <div class="table-responsive">
        <table class="table table-dark table-bordered table-hoverable text-nowrap align-middle">
            <thead class="align-middle">
                <tr>
                    <th scope="col" class="text-center" rowspan="2">STT</th>
                    <th scope="col" class="text-center" rowspan="2">Mã học sinh</th>
                    <th scope="col" class="text-center" rowspan="2" colspan="2">Họ và tên</th>
                    <th scope="col" class="text-center" colspan="4">ĐĐGtx</th>
                    <th scope="col" class="text-center" rowspan="2">Chỉnh sửa</th>
                </tr>
                <tr>
                    <th scope="col" class="text-center">TX1</th>
                    <th scope="col" class="text-center">TX2</th>
                    <th scope="col" class="text-center">TX3</th>
                    <th scope="col" class="text-center">TX4</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($records_by_subject as $record)
                @php($fullname = $record->student->fullname ?? '')
                @php($splited_name = get_first_and_last_name($fullname))
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    @if ($record->id == $edit_record_id)
                    <td class="text-center">
                        <input type="text" class="form-control form-control-sm text-center" 
                        wire:model.lazy="edit_student_fields.student_code">
                    </td>
                    <td class="text-start" colspan="2">
                        <input type="text" class="form-control form-control-sm" 
                        wire:model.lazy="edit_student_fields.fullname">
                    </td>
                    @if ($list_subjects->find($selected_subject_id)->use_digit_point)
                    <td class="text-center">
                        <input type="number" class="form-control form-control-sm text-center" 
                        wire:model.lazy="edit_record_fields.tx1" oninput="checkRange(this)">
                    </td>
                    <td class="text-center">
                        <input type="number" class="form-control form-control-sm text-center" 
                        wire:model.lazy="edit_record_fields.tx2" oninput="checkRange(this)">
                    </td>
                    <td class="text-center">
                        <input type="number" class="form-control form-control-sm text-center" 
                        wire:model.lazy="edit_record_fields.tx3" oninput="checkRange(this)">
                    </td>
                    <td class="text-center">
                        <input type="number" class="form-control form-control-sm text-center" 
                        wire:model.lazy="edit_record_fields.tx4" oninput="checkRange(this)">
                    </td>
                    @else
                    <td class="text-center">
                        <select type="number" class="form-control form-control-sm" 
                        wire:model.lazy="edit_record_fields.tx1">
                            <option value=""></option>
                            <option value="Đ">Đ</option>
                            <option value="CĐ">CĐ</option>
                        </select>
                    </td>
                    <td class="text-center">
                        <select type="number" class="form-control form-control-sm" 
                        wire:model.lazy="edit_record_fields.tx2">
                            <option value=""></option>
                            <option value="Đ">Đ</option>
                            <option value="CĐ">CĐ</option>
                        </select>
                    </td>
                    <td class="text-center">
                        <select type="number" class="form-control form-control-sm" 
                        wire:model.lazy="edit_record_fields.tx3">
                            <option value=""></option>
                            <option value="Đ">Đ</option>
                            <option value="CĐ">CĐ</option>
                        </select>
                    </td>
                    <td class="text-center">
                        <select type="number" class="form-control form-control-sm text-center" 
                        wire:model.lazy="edit_record_fields.tx4">
                            <option value=""></option>
                            <option value="Đ">Đ</option>
                            <option value="CĐ">CĐ</option>
                        </select>
                    </td>
                    @endif
                    <td class="text-center">
                        <button type="button" class="btn btn-success btn-sm" 
                        wire:click.prevent="updateRecord()">
                            <i class="fa-solid fa-floppy-disk"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" 
                        wire:click.prevent="$set('edit_record_id', 0)">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </td>
                    @else
                    <td class="text-center">{{ $record->student->student_code ?? '' }}</td>
                    <td class="text-start">{{ $splited_name['first'] }}</td>
                    <td class="text-start">{{ $splited_name['last'] }}</td>
                    <td class="text-center">{{ $record->tx1 ?? '' }}</td>
                    <td class="text-center">{{ $record->tx2 ?? '' }}</td>
                    <td class="text-center">{{ $record->tx3 ?? '' }}</td>
                    <td class="text-center">{{ $record->tx4 ?? '' }}</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-primary btn-sm" 
                        wire:click.prevent="editRecord({{ $record->id }})">
                            <i class="fa-solid fa-pen"></i>
                        </button>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif