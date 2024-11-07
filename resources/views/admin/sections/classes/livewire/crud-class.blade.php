<div>
    <div wire:ignore.self class="modal fade" id="crudClassModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
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
                        Thêm mới lớp học
                        @elseif ($action == 'update')
                        Chỉnh sửa lớp học
                        @elseif ($action == 'delete')
                        Xác nhận
                        @endif
                    </h5>
                </div>

                <div class="modal-body">
                    <form wire:submit.prevent={{ $action }} id="crudClassForm">
                    @if ($action == 'delete')
                    <div class="row">
                        <div class="col">
                            <span class="mt-3">Bạn có chắc muốn xóa Lớp {{ $class->name ?? '' }}?</span>
                        </div>
                    </div>
                    @else
                    <div class="row mb-2">
                        <div class="col">
                            <select class="form-control custom-select" wire:model.blur="grade">
                                @foreach ($list_grades as $grade)
                                <option value="{{ $grade }}">Khối {{ $grade }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" wire:model.blur="name" placeholder="Lớp">
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div> 
                    @endif
                    </form>
                </div>
                <div class="modal-footer">
                    @if ($action == 'delete')
                    <button type="submit" class="btn btn-danger" form="crudClassForm">Đồng ý</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    @else
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary" form="crudClassForm">Lưu</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#crudClassModal').on('show.bs.modal', function(e) {
            var classId = e.relatedTarget.getAttribute('data-class-id') ?? 0
            @this.call('modalSetup', classId)
        })

        $(document).on('closeCrudClassModal', function() {
            $('#crudClassModal').modal('hide')
        })
    })
</script>
@endpush