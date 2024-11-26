<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header header-elements-inline bg-vnpt text-white">
                <h6 class="card-title">
                    <i class="icon-table2 mr-2"></i>
                    Danh sách trường học
                </h6>
                <div class="header-elements"></div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <select class="form-select form-select-sm custom-select mb-3 w-auto" wire:model.live="paginate">
                            @for ($page = 5; $page <= 20; $page+=5)
                            <option value="{{ $page }}">{{ $page }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col text-right">
                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#crudSchoolModal">
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
                                        <th scope="col" class="text-center">STT</th>
                                        <th scope="col" class="text-center">Trường</th>
                                        <th scope="col" class="text-center">Cấp bậc</th>
                                        <th scope="col" class="text-center">Sở/Phòng GD-ĐT</th>
                                        <th scope="col" class="text-center"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($schools && count($schools) > 0)
                                    @php($sn = ($schools->perPage() * ($schools->currentPage() - 1)) + 1)
                                    @foreach ($schools as $key => $school)
                                    <tr>
                                        <td class="text-center">{{ $sn++ }}</td>
                                        <td class="text-center">{{ $school->name ?? '' }}</td>
                                        <td class="text-center">{{ $education_level[$school->level] }}</td>
                                        <td class="text-center">{{ $school->department->name ?? '' }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('classes.index', ['school_id' => $school->id]) }}" 
                                            class="badge badge-primary">
                                                <i class="icon-eye"></i>
                                            </a>
                                            <a href="#!" class="badge badge badge-success" data-toggle="modal" 
                                            data-target="#crudSchoolModal" data-school-id="{{ $school->id }}">
                                                <i class="icon-pencil"></i>
                                            </a>
                                            <a href="#!" class="badge badge-danger" data-toggle="modal" 
                                            data-target="#crudSchoolModal" data-school-id="{{ -$school->id }}">
                                                <i class="icon-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="5" class="text-center">(Không tìm thấy trường học)</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        @include('admin.components.livewire-table-nav', ['collection' => $schools])
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
