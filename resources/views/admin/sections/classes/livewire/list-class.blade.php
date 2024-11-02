<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header header-elements-inline bg-secondary text-white">
                <h6 class="card-title">
                    <i class="icon-table2 mr-2"></i>
                    Danh sách lớp học {{ $school->name }}
                </h6>
                <div class="header-elements"></div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col text-right">
                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#crudClassModal">
                            <i class="icon-plus3 mr-2"></i>
                            Thêm mới
                        </button>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <ul class="nav nav-tabs nav-tabs-highlight">
                            @foreach ($list_grades as $grade)
                            <li class="nav-item">
                                <a href="#grade_tab_{{ $grade }}" class="nav-link {{ $loop->first ? 'active' : '' }}" 
                                data-toggle="tab" wire:ignore.self>
                                    Khối {{ $grade }}
                                </a>
                            </li>
                            @endforeach
                        </ul>

                        <div class="tab-content">
                            @foreach ($list_grades as $grade)
                            <div class="tab-pane fade {{ $loop->first ? 'active show' : '' }}" 
                            id="grade_tab_{{ $grade }}" wire:ignore.self>
                                <div class="row">
                                    @if ($classes && $classes->where('grade', $grade)->count() > 0)
                                    @foreach ($classes->where('grade', $grade) as $key => $class)
                                    <div class="col-3 p-2">
                                        <div class="card">
                                            <div class="card-header text-center text-uppercase bg-info text-white">
                                                <strong>Lớp {{ $class->name }}</strong>
                                            </div>
                                            <div class="card-body">
                                                <p class="card-text text-center">
                                                    <i class="fa-regular fa-user"></i>
                                                    Sĩ số: {{ $class->students->count() }}
                                                </p>
                                            </div>
                                            <div class="card-footer text-center">
                                                <a href="{{ route('students.index', ['class_id' => $class->id]) }}" 
                                                class="badge badge-primary mr-2">
                                                    <i class="icon-eye"></i>
                                                </a>
                                                <a  href="#!" class="badge badge-success mr-2" data-toggle="modal" 
                                                data-target="#crudClassModal" data-class-id="{{ $class->id }}">
                                                    <i class="icon-pencil"></i>
                                                </a>
                                                <a  href="#!" class="badge badge-danger" data-toggle="modal" 
                                                data-target="#crudClassModal" data-class-id="{{ -$class->id }}">
                                                    <i class="icon-trash"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    @else
                                    <div class="col">
                                        <h5 class="text-center mt-3">(Không tìm thấy lớp học)</h5>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>


