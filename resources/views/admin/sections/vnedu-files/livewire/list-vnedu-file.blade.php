<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header header-elements-inline bg-vnpt text-white">
                <h6 class="card-title">
                    <i class="icon-table2 mr-2"></i>
                    Danh sách bảng điểm
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
                        <input type="text" class="form-control mb-3 w-auto" placeholder="Tìm kiếm" wire:model.live="params.file_name">
                    </div>
                    {{-- <div class="col text-right">
                        <a href="{{ route('dashboard.index') }}" class="btn btn-sm btn-success">
                            <i class="icon-file-excel mr-2"></i>
                            Nhập file excel
                        </a>
                    </div> --}}
                </div>

                <div class="row">
                    <div class="col">
                        <div class="table-responsive mb-2">
                            <table class="table table-bordered table-dark align-middle text-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">STT</th>
                                        <th scope="col" class="text-center">Bảng điểm</th>
                                        <th scope="col" class="text-center">Trường</th>
                                        <th scope="col" class="text-center">Lớp</th>
                                        <th scope="col" class="text-center">Học kỳ</th>
                                        <th scope="col" class="text-center"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($vnedu_files && count($vnedu_files) > 0)
                                    @php($sn = ($vnedu_files->perPage() * ($vnedu_files->currentPage() - 1)) + 1)
                                    @foreach ($vnedu_files as $key => $vnedu_file)
                                    <tr>
                                        <td class="text-center">{{ $sn++ }}</td>
                                        <td class="text-center">{{ $vnedu_file->file_name ?? '' }}</td>
                                        <td class="text-center">{{ $vnedu_file->school->name ?? '' }}</td>
                                        <td class="text-center">{{ $vnedu_file->class->name ?? '' }}</td>
                                        <td class="text-center">
                                            {{ $vnedu_file->semester->semester ?? '' }} 
                                            {{ $vnedu_file->semester->school_year ?? '' }} 
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('scoreboard-import.index', ['file_id' => $vnedu_file->id]) }}" 
                                            class="badge badge-success">
                                                <i class="icon-file-excel"></i>
                                            </a>
                                            <a href="{{ route('scoreboard.index', ['file_id' => $vnedu_file->id]) }}" 
                                            class="badge badge-primary">
                                                <i class="icon-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="6" class="text-center">(Không tìm thấy bảng điểm)</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        @include('admin.components.livewire-table-nav', ['collection' => $vnedu_files])
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
