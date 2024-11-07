<div>
    <div wire:ignore.self class="modal fade" id="crudSchoolModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" wire:loading wire:target="modalSetup">
                <div class="modal-body">
                    <div class="row py-3">
                        <div class="col text-center">
                            <span class="spinner-border spinner-border-sm mr-2"></span>
                            <span class="ms-2">Vui lòng đợi</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-content" wire:loading.remove wire:target="modalSetup">
                <div class="modal-header">
                    <h5 class="modal-title">
                        @if ($action == 'create')
                        Thêm mới trường học
                        @elseif ($action == 'update')
                        Chỉnh sửa trường học
                        @elseif ($action == 'delete')
                        Xác nhận
                        @endif
                    </h5>
                </div>

                <div class="modal-body">
                    <form wire:submit.prevent={{ $action }} id="crudSchoolForm">
                    @if ($action == 'delete')
                    <div class="row">
                        <div class="col">
                            <span class="mt-3">Bạn có chắc muốn xóa {{ $school->name ?? '' }}?</span>
                        </div>
                    </div>
                    @else
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label">Tên trường:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" wire:model.lazy="name">
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label">Tên trường (Vnedu):</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" wire:model.blur="export_name">
                            @error('export_name')
                            <span class="text-danger">{{ $message }}</span>
                            @else
                            <span class="text-danger" style="font-size: .8rem">
                                (*) Có thể bỏ trống nếu tên trường học trong file CSDL và Vnedu trùng khớp với nhau
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label">Cấp bậc:</label>
                        <div class="col-sm-8">
                            <select class="form-control custom-select" wire:model.blur="level">
                                <option value="1">Tiểu học</option>
                                <option value="2">THCS</option>
                                <option value="3">THPT</option>
                            </select>
                            @error('level')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label">Sở/Phòng GD-ĐT:</label>
                        <div class="col-sm-8">
                            @if (isset($list_departments) && $list_departments->count() > 0)
                            <select class="form-control custom-select" wire:model.blur="department_id">
                                @foreach ($list_departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                            @else
                            <select class="form-control custom-select disabled" disabled></select>
                            @endif
                            @error('department_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div> 
                    @endif
                    </form>
                </div>
                <div class="modal-footer">
                    @if ($action == 'delete')
                    <button type="submit" class="btn btn-danger" form="crudSchoolForm">Đồng ý</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    @else
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary" form="crudSchoolForm">Lưu</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#crudSchoolModal').on('show.bs.modal', function(e) {
            var schoolId = e.relatedTarget.getAttribute('data-school-id') ?? 0
            @this.call('modalSetup', schoolId)
        })

        $(document).on('closeCrudSchoolModal', function() {
            $('#crudSchoolModal').modal('hide')
        })
    })
</script>
@endpush