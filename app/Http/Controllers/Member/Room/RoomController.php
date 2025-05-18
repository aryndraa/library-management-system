<?php

namespace App\Http\Controllers\Member\Room;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        return view('user.room.index');
    }

    public function show(Room $room)
    {
        $room->load('category');

        return view('user.room.show', compact('room'));
    }
}
