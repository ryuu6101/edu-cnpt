<?php

namespace App\Livewire\CoordinatePresets;

use Livewire\Component;
use Livewire\WithPagination;
use App\Repositories\CoordinatePresets\CoordinatePresetRepositoryInterface;

class ListCoordinatePreset extends Component
{
    use WithPagination;

    protected $coordinatePresetRepos;

    public $params = [];
    public $paginate = 5;

    protected $listeners = [
        'search',
        'refresh' => '$refresh',
    ];

    public function boot(CoordinatePresetRepositoryInterface $coordinatePresetRepos) {
        $this->coordinatePresetRepos = $coordinatePresetRepos;
    }

    public function updatedPaginate() {
        $this->resetPage();
    }

    public function search($params) {
        $this->params = $params;
        $this->resetPage();
    }

    public function setDefault($id) {
        $result = $this->coordinatePresetRepos->setDefault($id);
        
        if ($result) {
            $this->dispatch('show-message', 
                type: 'success', 
                message: 'Đã đặt mẫu làm mặc định',
            );
        } else {
            $this->dispatch('show-message', 
                type: 'error', 
                message: 'Đã xảy ra lỗi!',
            );
        }
    }

    public function render()
    {
        $coordinate_presets = $this->coordinatePresetRepos->filter($this->params, $this->paginate);

        return view('admin.sections.coordinate-presets.livewire.list-coordinate-preset')->with([
            'coordinate_presets' => $coordinate_presets,
        ]);
    }
}
