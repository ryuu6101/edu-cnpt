<?php

namespace App\Repositories\Scoreboards;

use App\Models\Scoreboard;
use App\Repositories\BaseRepository;

class ScoreboardRepository extends BaseRepository implements ScoreboardRepositoryInterface
{
    public function getModel() {
        return Scoreboard::class;
    }
}