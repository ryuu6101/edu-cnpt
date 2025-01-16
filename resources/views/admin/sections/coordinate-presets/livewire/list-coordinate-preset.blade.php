<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header header-elements-inline bg-vnpt text-white">
                <h6 class="card-title">
                    <i class="icon-table2 mr-2"></i>
                    Danh sách
                </h6>
                <div class="header-elements"></div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-auto">
                        <select class="form-select form-select-sm custom-select mb-3 w-auto" wire:model.live="paginate">
                            @for ($page = 5; $page <= 20; $page+=5)
                            <option value="{{ $page }}">{{ $page }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-auto">
                        <input type="text" class="form-control mb-3 w-auto" placeholder="Tìm kiếm" wire:model.live="params.name">
                    </div>
                    <div class="col text-right">
                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#crudCoordinatePresetModal">
                            <i class="icon-plus3 mr-2"></i>
                            Thêm mới
                        </button>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="table-responsive mb-2">
                            <table class="table table-bordered table-dark align-middle text-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center" style="width:10%">STT</th>
                                        <th scope="col" class="text-center">Tên mẫu</th>
                                        <th scope="col" class="text-center" style="width:15%">Mặc định</th>
                                        <th scope="col" class="text-center" style="width:15%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($coordinate_presets && count($coordinate_presets) > 0)
                                    @php($sn = ($coordinate_presets->perPage() * ($coordinate_presets->currentPage() - 1)) + 1)
                                    @foreach ($coordinate_presets as $key => $preset)
                                    <tr>
                                        <td class="text-center">{{ $sn++ }}</td>
                                        <td class="text-center">{{ $preset->name ?? '' }}</td>
                                        <td class="text-center">
                                            @if ($preset->is_default)
                                            <span class="text-primary"><i class="icon-checkbox-checked2"></i></span>
                                            @else
                                            <span class="text-primary cursor-pointer" wire:click.prevent="setDefault({{ $preset->id }})">
                                                <i class="icon-checkbox-unchecked2"></i>
                                            </span>
                                            @endif
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="#!" class="badge badge badge-success" data-toggle="modal" 
                                            data-target="#crudCoordinatePresetModal" data-coordinate-preset-id="{{ $preset->id }}">
                                                <i class="icon-pencil"></i>
                                            </a>
                                            <a href="#!" class="badge badge-danger" data-toggle="modal" 
                                            data-target="#crudCoordinatePresetModal" data-coordinate-preset-id="{{ -$preset->id }}">
                                                <i class="icon-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="5" class="text-center">(Trống)</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        @include('admin.components.livewire-table-nav', ['collection' => $coordinate_presets])
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
