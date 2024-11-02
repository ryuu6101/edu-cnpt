<?php

namespace App\Repositories\VneduFiles;

use App\Models\VneduFile;
use App\Repositories\BaseRepository;

class VneduFileRepository extends BaseRepository implements VneduFileRepositoryInterface
{
    public function getModel() {
        return VneduFile::class;
    }
}