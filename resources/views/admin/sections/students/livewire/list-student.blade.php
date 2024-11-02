<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header header-elements-inline bg-secondary text-white">
                <h6 class="card-title">
                    <i class="icon-table2 mr-2"></i>
                    Danh sách học sinh lớp {{ $class->name }}
                </h6>
                <div class="header-elements"></div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <select class="form-select form-select-sm custom-select mb-3 w-auto" wire:model.live="paginate">
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                        </select>
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
                        @if ($error_students->count() > 0)
                        <div class="mb-2">
                            <span class="text-danger" type="button" wire:ignore.self
                            data-toggle="collapse" data-target="#errorStudentList" aria-expanded="false">
                                <i class="fa-solid fa-caret-down"></i>
                                Có {{ $error_students->count() }} học sinh nhập lỗi! (Click để xem chi tiết)
                            </span>
                        </div>
                        <div class="table-responsive mb-2 collapse border-bottom pb-2" id="errorStudentList" wire:ignore.self>
                            <table class="table table-dark table-bordered text-nowrap align-middle">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center" style="width:15%">STT</th>
                                        <th scope="col" class="text-center">Họ và tên</th>
                                        <th scope="col" class="text-center" style="width:30%">Mã học sinh</th>
                                        <th scope="col" class="text-center" style="width:15%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($error_students as $error_student)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-left">
                                            {{ $error_student->fullname }}
                                            <a href="#!" class="text-primary float-right" type="button"
                                            onclick="copyToClipboard('{{ $error_student->fullname }}')">
                                                <i class="mi-content-copy"></i>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            {{ $error_student->student_code }}
                                            <a href="#!" class="text-primary float-right" type="button"
                                            onclick="copyToClipboard('{{ $error_student->student_code }}')">
                                                <i class="mi-content-copy"></i>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <a href="#!" class="badge badge-secondary"
                                            wire:click.prevent="deleteErrorStudent({{ $error_student->id }})">
                                                <i class="icon-trash"></i>
                                            </a>
                                            <a href="#!" class="badge badge-success"
                                            wire:click.prevent="addStudentToList({{ $error_student->id }})">
                                                <i class="icon-add-to-list"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                    
                        <div class="table-responsive mb-2">
                            <table class="table table-bordered table-dark align-middle text-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center" style="width:15%">STT</th>
                                        <th scope="col" class="text-center">Họ và Tên</th>
                                        <th scope="col" class="text-center" style="width:30%">Mã học sinh</th>
                                        <th scope="col" class="text-center" style="width:15%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($students && count($students) > 0)
                                    @php($sn = ($students->perPage() * ($students->currentPage() - 1)) + 1)
                                    @foreach ($students as $key => $student)
                                    <tr>
                                        <td class="text-center">{{ $sn++ }}</td>
                                        <td class="text-left">{{ $student->fullname ?? '' }}</td>
                                        <td class="text-center">{{ $student->student_code ?? '' }}</td>
                                        <td class="text-center">
                                            <a  href="#!" class="badge badge-success" data-toggle="modal" 
                                            data-target="#crudStudentModal" data-student-id="{{ $student->id }}">
                                                <i class="icon-pencil"></i>
                                            </a>
                                            <a  href="#!" class="badge badge-danger" data-toggle="modal" 
                                            data-target="#crudStudentModal" data-student-id="{{ -$student->id }}">
                                                <i class="icon-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="4" class="text-center">(Không tìm thấy học sinh)</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        @include('admin.components.livewire-table-nav', ['collection' => $students])
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function copyToClipboard(value) {
        event.preventDefault();
        navigator.clipboard.writeText(value);
        alert("Đã lưu vào bộ nhớ đệm");
    }
</script>
@endpush
