@push('styles')
<style>
    .nav-tabs {
        overflow-x: auto !important;
        overflow-y: hidden !important;
        flex-wrap: nowrap !important;
    }
    .nav-tabs, .nav-tabs>li {
        transform: rotateX(180deg);
    }
</style>
@endpush

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header header-elements-inline bg-secondary text-white">
                <h6 class="card-title">
                    <i class="icon-table2 mr-2"></i>
                    Chi tiết bảng điểm
                </h6>
                <div class="header-elements"></div>
            </div>

            <div class="card-body">
                <div class="row mb-2">
                    <div class="col text-right">
                        @if ($allow_export)
                        <a type="button" class="btn btn-success" href="{{ route('excel.export', ['file_id' => $vnedu_file->id]) }}">
                            <i class="icon-file-excel mr-2"></i>
                            Xuất file Excel
                        </a>
                        @else
                        <button type="button" class="btn btn-success" disabled>
                            <i class="icon-file-excel mr-2"></i>
                            Xuất file Excel
                        </button>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <ul class="nav nav-tabs nav-tabs-highlight pb-2">
                            @foreach ($vnedu_sheets as $vnedu_sheet)
                            @php($subject_id = $vnedu_sheet->vnedu_subject->subject_id ?? 0)
                            <li class="nav-item">
                                <a href="#sheet_tab_{{ $vnedu_sheet->id }}" data-toggle="tab" wire:ignore.self
                                class="nav-link {{ $loop->first ? 'active' : '' }} text-nowrap">
                                    @if ($subject_id > 0)
                                    <span>{{ $vnedu_sheet->sheet_name }}</span>
                                    @else
                                    <span class="text-danger">
                                        {{ $vnedu_sheet->sheet_name }}
                                        <i class="icon-warning22 ml-2"></i>
                                    </span>
                                    @endif
                                </a>
                            </li>
                            @endforeach
                        </ul>

                        <div class="tab-content">
                            @foreach ($vnedu_sheets as $vnedu_sheet)
                            <div class="tab-pane fade {{ $loop->first ? 'active show' : '' }}" 
                            id="sheet_tab_{{ $vnedu_sheet->id }}" wire:ignore.self>
                                <div class="table-responsive">
                                    @php($subject = $vnedu_sheet->vnedu_subject->subject)
                                    @php($subject_id = $vnedu_sheet->vnedu_subject->subject_id ?? 0)
                                    @if ($subject_id > 0)
                                    <table class="table table-dark table-sm table-bordered table-hoverable text-nowrap align-middle">
                                        <thead class="align-middle">
                                            <tr>
                                                <th scope="col" class="text-center" rowspan="2">STT</th>
                                                <th scope="col" class="text-center" rowspan="2">Mã học sinh</th>
                                                <th scope="col" class="text-center" rowspan="2" colspan="2">Họ và tên</th>
                                                <th scope="col" class="text-center" colspan="4">ĐĐGtx</th>
                                                <th scope="col" class="text-center" rowspan="2"></th>
                                            </tr>
                                            <tr>
                                                <th scope="col" class="text-center">TX1</th>
                                                <th scope="col" class="text-center">TX2</th>
                                                <th scope="col" class="text-center">TX3</th>
                                                <th scope="col" class="text-center">TX4</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($scoreboards->where('subject_id', $subject_id) as $record)
                                            @php($fullname = $record->student->fullname ?? '')
                                            @php($splited_name = get_first_and_last_name($fullname))
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                @if ($record->id == $edit_record_id)
                                                <td class="text-center">
                                                    <input type="text" class="form-control text-center" 
                                                    wire:model.lazy="edit_student_fields.student_code">
                                                </td>
                                                <td class="text-start" colspan="2">
                                                    <input type="text" class="form-control" 
                                                    wire:model.lazy="edit_student_fields.fullname">
                                                </td>
                                                @if ($subject->use_digit_point)
                                                <td class="text-center">
                                                    <input type="number" class="form-control text-center hidden-arrow" 
                                                    wire:model.lazy="edit_record_fields.tx1" oninput="checkRange(this)">
                                                </td>
                                                <td class="text-center">
                                                    <input type="number" class="form-control text-center hidden-arrow" 
                                                    wire:model.lazy="edit_record_fields.tx2" oninput="checkRange(this)">
                                                </td>
                                                <td class="text-center">
                                                    <input type="number" class="form-control text-center hidden-arrow" 
                                                    wire:model.lazy="edit_record_fields.tx3" oninput="checkRange(this)">
                                                </td>
                                                <td class="text-center">
                                                    <input type="number" class="form-control text-center hidden-arrow" 
                                                    wire:model.lazy="edit_record_fields.tx4" oninput="checkRange(this)">
                                                </td>
                                                @else
                                                <td class="text-center">
                                                    <select type="number" class="form-control" 
                                                    wire:model.lazy="edit_record_fields.tx1">
                                                        <option value=""></option>
                                                        <option value="Đ">Đ</option>
                                                        <option value="CĐ">CĐ</option>
                                                    </select>
                                                </td>
                                                <td class="text-center">
                                                    <select type="number" class="form-control" 
                                                    wire:model.lazy="edit_record_fields.tx2">
                                                        <option value=""></option>
                                                        <option value="Đ">Đ</option>
                                                        <option value="CĐ">CĐ</option>
                                                    </select>
                                                </td>
                                                <td class="text-center">
                                                    <select type="number" class="form-control" 
                                                    wire:model.lazy="edit_record_fields.tx3">
                                                        <option value=""></option>
                                                        <option value="Đ">Đ</option>
                                                        <option value="CĐ">CĐ</option>
                                                    </select>
                                                </td>
                                                <td class="text-center">
                                                    <select type="number" class="form-control text-center" 
                                                    wire:model.lazy="edit_record_fields.tx4">
                                                        <option value=""></option>
                                                        <option value="Đ">Đ</option>
                                                        <option value="CĐ">CĐ</option>
                                                    </select>
                                                </td>
                                                @endif
                                                <td class="text-center">
                                                    <a href="#!" class="badge badge-success" 
                                                    wire:click.prevent="updateRecord()">
                                                        <i class="icon-floppy-disk"></i>
                                                    </a>
                                                    <a href="#!" class="badge badge-danger" 
                                                    wire:click.prevent="$set('edit_record_id', 0)">
                                                        <i class="icon-cross3"></i>
                                                    </a>
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
                                                    <a href="#!" class="badge badge-primary" 
                                                    wire:click.prevent="editRecord({{ $record->id }})">
                                                        <i class="icon-pencil"></i>
                                                    </a>
                                                </td>
                                                @endif
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @else
                                    <div class="w-100 text-center">
                                        <h2 class="text-danger">
                                            <i class="icon-warning mr-2"></i> <br> 
                                            Vui lòng liên kết môn học <br>
                                            Môn: {{ $vnedu_sheet->vnedu_subject->name }}
                                        </h2>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function checkRange(input) {
        let value = input.value
        if (value < 0) input.value = 0
        if (value > 10) input.value = 10
    }

    function copyToClipboard(value) {
        event.preventDefault();
        navigator.clipboard.writeText(value);
        alert("Đã lưu vào bộ nhớ đệm");
    }
</script>
@endpush