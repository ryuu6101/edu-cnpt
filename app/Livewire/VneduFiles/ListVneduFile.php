<?php

namespace App\Livewire\VneduFiles;

use Livewire\Component;
use Livewire\WithPagination;
use App\Repositories\VneduFiles\VneduFileRepositoryInterface;

class ListVneduFile extends Component
{
    use WithPagination;

    protected $vneduFileRepos;

    public $params = [];
    public $paginate = 10;

    protected $listeners = [
        'search',
        'refresh' => '$refresh',
    ];

    public function boot(VneduFileRepositoryInterface $vneduFileRepos) {
        $this->vneduFileRepos = $vneduFileRepos;
    }

    public function search($params) {
        $this->params = $params;
    }

    public function render()
    {
        $vnedu_files = $this->vneduFileRepos->filter($this->params, $this->paginate, 'desc');

        return view('admin.sections.vnedu-files.livewire.list-vnedu-file')->with([
            'vnedu_files' => $vnedu_files,
        ]);
    }
}
