@push('styles')
<style>
    .validate-error-only .form-control:invalid {
        border-color: #ef5350;
        padding-right: calc(1.5715em + 1rem);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23ef5350' viewBox='0 0 12 12'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23ef5350' stroke='none'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(.39287em + .25rem) center;
        background-size: calc(.78575em + .5rem) calc(.78575em + .5rem)
    }
</style>
@endpush

<div class="row justify-content-center mt-2">
    <div class="col-6">
        <fieldset class="border px-2 pb-1 validate-error-only">
            <legend class="w-auto m-0 ml-3 px-1 text-muted">Nhập vị trí</legend>
            <div class="row">
                <div class="col-4 mb-1">
                    <label>Bộ GD:</label>
                    <input type="text" class="form-control" name="department_cell" 
                    wire:model.blur="department" required pattern="^[A-Z]{1}[0-9]+$">
                </div>
                <div class="col-4 mb-1">
                    <label>Trường:</label>
                    <input type="text" class="form-control" name="school_cell" 
                    wire:model.blur="school" required pattern="^[A-Z]{1}[0-9]+$">
                </div>
                <div class="col-4 mb-1">
                    <label>Lớp:</label>
                    <input type="text" class="form-control" name="class_cell" 
                    wire:model.blur="class" required pattern="^[A-Z]{1}[0-9]+$">
                </div>
                <div class="col-4 mb-1">
                    <label>Năm học - Học kỳ:</label>
                    <input type="text" class="form-control" name="semester_cell" 
                    wire:model.blur="semester" required pattern="^[A-Z]{1}[0-9]+$">
                </div>
                <div class="col-4 mb-1">
                    <label>Môn học:</label>
                    <input type="text" class="form-control" name="subject_cell" 
                    wire:model.blur="subject" required pattern="^[A-Z]{1}[0-9]+$">
                </div>
                <div class="col-4 mb-1">
                    <label>Bắt đầu danh sách:</label>
                    <input type="number" class="form-control hidden-arrow" name="starting_row" 
                    wire:model.blur="starting_row" required min=1>
                </div>
                @if ($coordinate_presets->count() > 0)
                <div class="col-12 mb-1 mt-2 text-center">
                    <span class="text-primary cursor-pointer" data-toggle="dropdown">
                        Sử dụng mẫu soạn sẵn
                        <i class="icon-pencil3 ml-2"></i>
                    </span>
                    <div class="dropdown-menu">
                        @foreach ($coordinate_presets as $preset)
                        <div class="dropdown-submenu dropup">
                            <a href="#" class="dropdown-item" wire:click.prevent="selectPreset({{ $preset->id }})">
                                {{ $preset->name }}
                            </a>
                            <div class="dropdown-menu px-2">
                                <table>
                                    <tr>
                                        <td>Bộ GD:</td>
                                        <th>{{ $preset->department }}</th>
                                    </tr>
                                    <tr>
                                        <td>Trường:</td>
                                        <th>{{ $preset->school }}</th>
                                    </tr>
                                    <tr>
                                        <td>Lớp:</td>
                                        <th>{{ $preset->class }}</th>
                                    </tr>
                                    <tr>
                                        <td>NH - HK:</td>
                                        <th>{{ $preset->semester }}</th>
                                    </tr>
                                    <tr>
                                        <td>Môn học:</td>
                                        <th>{{ $preset->subject }}</th>
                                    </tr>
                                    <tr>
                                        <td>Bắt đầu DS:</td>
                                        <th>{{ $preset->starting_row }}</th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        @endforeach
                        <a href="{{ route('coordinate-presets.index') }}" class="dropdown-item text-primary">+ Thêm mới</a>
                    </div>
                </div>
                @endif
            </div>
        </fieldset>
    </div>
</div>