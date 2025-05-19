<?php

namespace App\Http\Controllers\Member\Room;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        return view('user.room.index');
    }
}
