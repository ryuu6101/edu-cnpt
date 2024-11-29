<div>
    <div wire:ignore.self class="modal fade" id="crudVneduSubjectModal" tabindex="-1" aria-hidden="true">
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
                        <div wire:loading.remove wire:target="modalSetup">
                            @if ($action == 'create')
                            Thêm mới môn học
                            @elseif ($action == 'update')
                            Chỉnh sửa môn học
                            @elseif ($action == 'delete')
                            Xác nhận
                            @endif
                        </div>
                    </h5>
                </div>

                <div class="modal-body">
                    <form wire:submit.prevent={{ $action }} id="crudVneduSubjectForm">
                    @if ($action == 'delete')
                    <div class="row">
                        <div class="col">
                            <span class="text-danger">
                                (*) Lưu ý: Xóa môn học sẽ ảnh hưởng đến 
                                các bảng điểm đang được lưu trong hệ thống <br>
                            </span>
                            <span class="mt-3">Bạn có chắc muốn xóa môn {{ $subject->name ?? '' }}?</span>
                        </div>
                    </div>
                    @else
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label">Tên môn học:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" wire:model.blur="name">
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label">Tùy chọn tên môn:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" wire:model.blur="optional_name">
                            @error('optional_name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-sm-4 col-form-label">Loại điểm:</label>
                        <div class="col-sm-8 d-flex align-items-center">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="scoreType" id="scoreType1" value=0 
                                wire:model.blur="use_rating_point">
                                <label class="form-check-label" for="scoreType1">Số</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="scoreType" id="scoreType2" value=1 
                                wire:model.blur="use_rating_point">
                                <label class="form-check-label" for="scoreType2">Đ/CĐ</label>
                            </div>
                        </div>
                    </div>
                    @endif
                    </form>
                </div>
                <div class="modal-footer">
                    <div wire:loading.remove wire:target="modalSetup">
                        @if ($action == 'delete')
                        <button type="submit" class="btn btn-danger" form="crudVneduSubjectForm">Đồng ý</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                        @else
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary" form="crudVneduSubjectForm">Lưu</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#crudVneduSubjectModal').on('show.bs.modal', function(e) {
            var subjectId = e.relatedTarget.getAttribute('data-vnedu-subject-id') ?? 0
            @this.call('modalSetup', subjectId)
        })

        $(document).on('closeCrudVneduSubjectModal', function() {
            $('#crudVneduSubjectModal').modal('hide')
        })
    })
</script>
@endpush