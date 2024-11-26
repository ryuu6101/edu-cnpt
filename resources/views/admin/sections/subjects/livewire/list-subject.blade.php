<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header header-elements-inline bg-vnpt text-white">
                <h6 class="card-title">
                    <i class="icon-table2 mr-2"></i>
                    Danh sách môn học
                </h6>
                <div class="header-elements"></div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-auto">
                        <select class="custom-select mb-3 w-auto" wire:model.live="paginate">
                            @for ($page = 5; $page <= 20; $page+=5)
                            <option value="{{ $page }}">{{ $page }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-auto">
                        <select class="custom-select mb-3 w-auto" wire:model.live="params.grade">
                            @for ($g = 1; $g <= 12; $g++)
                            <option value="{{ $g }}">Khối {{ $g }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-auto">
                        <input type="text" class="form-control mb-3 w-auto" placeholder="Tìm kiếm" wire:model.live="params.name">
                    </div>
                    {{-- <div class="col text-right">
                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#crudSchoolModal">
                            <i class="icon-plus3 mr-2"></i>
                            Thêm mới
                        </button>
                    </div> --}}
                </div>

                <div class="row">
                    <div class="col">
                        <div class="table-responsive mb-2">
                            <table class="table table-bordered table-dark align-middle text-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">STT</th>
                                        <th scope="col" class="text-center">Môn học</th>
                                        <th scope="col" class="text-center">Tên Excel</th>
                                        <th scope="col" class="text-center"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($subjects && count($subjects) > 0)
                                    @php($sn = ($subjects->perPage() * ($subjects->currentPage() - 1)) + 1)
                                    @foreach ($subjects as $key => $subject)
                                    <tr>
                                        <td class="text-center">{{ $sn++ }}</td>
                                        <td class="text-center">{{ $subject->name ?? '' }}</td>
                                        <td class="text-center">{{ $subject->vnedu_subject->name ?? '' }}</td>
                                        <td class="text-center">
                                            <a href="#!" class="badge badge-primary" 
                                            data-toggle="modal" data-target="#crudSubjectModal" data-subject-id="{{ $subject->id }}">
                                                <i class="icon-pencil"></i>
                                            </a>
                                            {{-- <button type="button" class="btn btn-sm btn-danger shadow-none"
                                            data-toggle="modal" data-target="#crudSubjectModal" data-subject-id="{{ -$subject->id }}">
                                                <i class="fa-solid fa-trash"></i>
                                            </button> --}}
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="4" class="text-center">(Không tìm thấy môn học)</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        @include('admin.components.livewire-table-nav', ['collection' => $subjects])
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- <div>

    <div class="d-flex justify-content-between">
        <div class="input-group mb-3">
            <span class="input-group-text">Khối</span>
            @for ($grade = 6; $grade <= 12; $grade++)
            <button class="btn btn{{ $params['grade'] == $grade ? '' : '-outline' }}-secondary shadow-none" type="button"
            wire:click.prevent="switchGrade({{ $grade }})">
                {{ $grade }}
            </button>
            @endfor
        </div>
    </div>

</div> --}}
