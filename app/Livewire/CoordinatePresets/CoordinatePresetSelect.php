<?php

namespace App\Livewire\CoordinatePresets;

use Livewire\Component;
use App\Repositories\CoordinatePresets\CoordinatePresetRepositoryInterface;

class CoordinatePresetSelect extends Component
{    
    protected $coordinatePresetRepos;

    public $coordinate_presets;
    public $department;
    public $school;
    public $class;
    public $semester;
    public $subject;
    public $starting_row;

    public function boot(CoordinatePresetRepositoryInterface $coordinatePresetRepos) {
        $this->coordinatePresetRepos = $coordinatePresetRepos;
    }

    public function mount() {
        $this->coordinate_presets = $this->coordinatePresetRepos->getAll();
        
        $default_preset = $this->coordinate_presets->where('is_default', true)->first();
        $this->getData($default_preset);
    }

    public function getData($preset) {
        $this->department = $preset->department ?? 'A1';
        $this->school = $preset->school ?? 'A1';
        $this->class = $preset->class ?? 'A1';
        $this->semester = $preset->semester ?? 'A1';
        $this->subject = $preset->subject ?? 'A1';
        $this->starting_row = $preset->starting_row ?? '1';
    }

    public function selectPreset($id) {
        $preset = $this->coordinatePresetRepos->find($id);
        $this->getData($preset);
    }

    public function render()
    {
        return view('admin.sections.excel-import.livewire.coordinate-preset-select');
    }
}
