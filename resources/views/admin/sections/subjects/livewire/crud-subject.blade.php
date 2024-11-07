<div>
    <div wire:ignore.self class="modal fade" id="crudSubjectModal" tabindex="-1" aria-hidden="true">
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
                    <form wire:submit.prevent={{ $action }} id="crudSubjectForm">
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
                            <input type="text" class="form-control shadow-none" wire:model.blur="name">
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @else
                            {{-- <span class="text-danger text-justify" style="font-size: .8rem">
                                (*) Dùng để đối chiếu với tên môn học trong file excel của Sở
                            </span> --}}
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label">Tên Excel:</label>
                        <div class="col-sm-8">
                            <select class="custom-select" wire:model.blur="vnedu_subject_id">
                                <option value=null hidden></option>
                                @if (isset($list_vnedu_subjects) && $list_vnedu_subjects->count() > 0)
                                @foreach ($list_vnedu_subjects as $vnedu_subject)
                                <option value="{{ $vnedu_subject->id }}">{{ $vnedu_subject->name }}</option>
                                @endforeach
                                @endif
                            </select>
                            @error('vnedu_subject_id')
                            <span class="text-danger">{{ $message }}</span>
                            @else
                            <span class="text-danger" style="font-size: .8rem">
                                (*) Chọn tên Excel để liên kết với môn học này
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-sm-4 col-form-label">Loại điểm:</label>
                        <div class="col-sm-8 d-flex align-items-center">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="scoreType" id="scoreType1" value=1 
                                wire:model.blur="use_digit_point">
                                <label class="form-check-label" for="scoreType1">Số</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="scoreType" id="scoreType2" value=0 
                                wire:model.blur="use_digit_point">
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
                        <button type="submit" class="btn btn-danger" form="crudSubjectForm">Đồng ý</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                        @else
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary" form="crudSubjectForm">Lưu</button>
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
        $('#crudSubjectModal').on('show.bs.modal', function(e) {
            var subjectId = e.relatedTarget.getAttribute('data-subject-id') ?? 0
            @this.call('modalSetup', subjectId)
        })

        $(document).on('closeCrudSubjectModal', function() {
            $('#crudSubjectModal').modal('hide')
        })
    })
</script>
@endpush