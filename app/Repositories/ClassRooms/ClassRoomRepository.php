<?php

namespace App\Repositories\ClassRooms;

use App\Models\ClassRoom;
use App\Repositories\BaseRepository;

class ClassRoomRepository extends BaseRepository implements ClassRoomRepositoryInterface
{
    public function getModel() {
        return ClassRoom::class;
    }
}