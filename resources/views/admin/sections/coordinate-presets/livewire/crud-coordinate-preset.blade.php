<div>
    <div wire:ignore.self class="modal fade" id="crudCoordinatePresetModal" tabindex="-1" aria-hidden="true">
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
                        Thêm mới
                        @elseif ($action == 'update')
                        Chỉnh sửa
                        @elseif ($action == 'delete')
                        Xác nhận
                        @endif
                    </h5>
                </div>

                <div class="modal-body">
                    <form wire:submit.prevent={{ $action }} id="crudCoordinatePresetForm">
                    @if ($action == 'delete')
                    <div class="row">
                        <div class="col">
                            <span class="mt-3">Bạn có chắc muốn xóa {{ $coordinate_preset->name ?? '' }}?</span>
                        </div>
                    </div>
                    @else
                    <div class="row mb-1">
                        <label class="col-sm-4 col-form-label">Tên mẫu:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" wire:model.blur="name">
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <fieldset class="border px-2 pb-1">
                        <legend class="w-auto m-0 ml-3 px-1 text-muted">Vị trí</legend>
                        <div class="row">
                            <div class="col-4 mb-1">
                                <label>Bộ GD:</label>
                                <input type="text" class="form-control" wire:model.blur="department">
                                @error('department')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-4 mb-1">
                                <label>Trường:</label>
                                <input type="text" class="form-control" wire:model.blur="school">
                                @error('school')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-4 mb-1">
                                <label>Lớp:</label>
                                <input type="text" class="form-control" wire:model.blur="class">
                                @error('class')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-4 mb-1">
                                <label>Năm học - Học kỳ:</label>
                                <input type="text" class="form-control" wire:model.blur="semester">
                                @error('semester')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-4 mb-1">
                                <label>Môn học:</label>
                                <input type="text" class="form-control" wire:model.blur="subject">
                                @error('subject')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-4 mb-1">
                                <label>Bắt đầu danh sách:</label>
                                <input type="number" class="form-control hidden-arrow" wire:model.blur="starting_row">
                                @error('starting_row')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </fieldset>

                    @endif
                    </form>
                </div>
                <div class="modal-footer">
                    @if ($action == 'delete')
                    <button type="submit" class="btn btn-danger" form="crudCoordinatePresetForm">Đồng ý</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    @else
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary" form="crudCoordinatePresetForm">Lưu</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#crudCoordinatePresetModal').on('show.bs.modal', function(e) {
            var coordinatePresetId = e.relatedTarget.getAttribute('data-coordinate-preset-id') ?? 0
            @this.call('modalSetup', coordinatePresetId)
        })

        $(document).on('closeCrudCoordinatePresetModal', function() {
            $('#crudCoordinatePresetModal').modal('hide')
        })
    })
</script>
@endpush