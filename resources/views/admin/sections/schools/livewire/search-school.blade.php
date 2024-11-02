<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header header-elements-inline bg-secondary text-white">
                <h6 class="card-title">
                    <i class="icon-search4 mr-2"></i>
                    Tìm kiếm
                </h6>
                <div class="header-elements"></div>
            </div>

            <div class="card-body">
                <form wire:submit.prevent="search">
                    <div class="row">
                        <div class="col-4">
                            <label class="form-label">Tên trường học</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" wire:model.blur="params.name">
                            </div>
                        </div>
                        <div class="col-4">
                            <label class="form-label">Cấp bậc</label>
                            <select class="form-control custom-select" wire:model.blur="params.level">
                                <option value="">Tất cả</option>
                                <option value="1">Tiểu học</option>
                                <option value="2">Trung học cơ sở</option>
                                <option value="3">Trung học phổ thông</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <label class="form-label">Sở/Phòng GD-ĐT</label>
                            <select class="form-control custom-select" wire:model.blur="params.department_id">
                                <option value="">Tất cả</option>
                                @foreach ($list_departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row flex-row-reverse">
                        <div class="col-4 d-flex" style="gap:.5rem">
                            <button type="submit" class="btn btn-primary" style="flex:1">
                                <i class="icon-search4"></i>
                                Tìm kiếm
                            </button>
                            <button type="button" class="btn btn-secondary" style="flex:1" wire:click.prevent="resetInput()">
                                <i class="icon-sync"></i>
                                Làm mới
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>