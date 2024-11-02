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
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-3 col-lg-6 col-sm-12 mb-2">
                                <label class="form-label">Trường</label>
                                @if (isset($list_schools) && count($list_schools) > 0)
                                <select class="custom-select" wire:model.live="school_id">
                                    <option value="">Tất cả</option>
                                    @foreach ($list_schools as $school)
                                    <option value="{{ $school->id }}">{{ $school->name }}</option>
                                    @endforeach
                                </select>
                                @else
                                <select class="custom-select" disabled></select>
                                @endif
                            </div>
                            <div class="col-xl-3 col-lg-6 col-sm-12 mb-2">
                                <label class="form-label">Khối</label>
                                @if (isset($list_grades) && count($list_grades) > 0)
                                <select class="custom-select" wire:model.live="grade">
                                    @foreach ($list_grades as $grade)
                                    <option value="{{ $grade }}">Khối {{ $grade }}</option>
                                    @endforeach
                                </select>
                                @else
                                <select class="custom-select" disabled></select>
                                @endif
                            </div>
                            <div class="col-xl-3 col-lg-6 col-sm-12 mb-2">
                                <label class="form-label">Lớp</label>
                                @if (isset($list_classes) && count($list_classes) > 0)
                                <select class="custom-select" wire:model.blur="class_id">
                                    @foreach ($list_classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                    @endforeach
                                </select>
                                @else
                                <select class="custom-select" disabled></select>
                                @endif
                            </div>
                            <div class="col-xl-3 col-lg-6 col-sm-12 mb-2">
                                <label class="form-label">Học kỳ</label>
                                @if (isset($list_semesters) && count($list_semesters) > 0)
                                <select class="custom-select" wire:model.blur="semester_id">
                                    @foreach ($list_semesters as $semester)
                                    <option value="{{ $semester->id }}">
                                        {{ "{$semester->semester} ({$semester->school_year})" }}
                                    </option>
                                    @endforeach
                                </select>
                                @else
                                <select class="custom-select" disabled></select>
                                @endif
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-3 d-flex" style="gap:.5rem">
                                <button type="submit" class="btn btn-primary" style="flex:1">
                                    <i class="icon-search4"></i>
                                    Tìm kiếm
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>