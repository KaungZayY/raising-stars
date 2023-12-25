<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        return view('room.room-list',['rooms'=>$rooms]);
    }

    public function create()
    {
        return view('room.room-create');
    }

    public function store(Request $request)
    {
        // dd($request);
        $validator = Validator::make($request->all(),[
            'room_number' => 'required|numeric',
            'hidden_room_number' => 'required|unique:rooms,room_number',
            'floor_number' => 'required|numeric',
            'seat_capacity' => 'required|numeric',
        ]);
        
        if($validator->fails())
        {
            return redirect()->route('room')->with('error','Room already Exists or Action Failed');
            exit();
        }

        $room = Room::create([
            'room_number' => $request->hidden_room_number,
            'floor_number' => $request->floor_number,
            'seat_capacity' => $request->seat_capacity,
        ]);

        if(!$room)
        {
            DB::rollBack();
            return redirect()->back()->with('error','Action Failed');
        }

        return redirect()->route('room')->with('success','Room Added');
    }

    public function edit(Room $room)
    {   
        return view('room.room-edit',['room'=>$room]);
    }

    public function update(Request $request, Room $room)
    {
        // dd($request);
        $validator = Validator::make($request->all(),[
            'room_number' => 'required|unique:rooms,room_number,'.$room->id,
            'floor_number' => 'required|numeric',
            'seat_capacity' => 'required|numeric',
        ]);

        if($validator->fails())
        {
            return redirect()->route('room')->with('error','Duplicated Room Number Or Action Failed');
            exit();
        }

        $updated = $room->update([
            'room_number' => $request->room_number,
            'floor_number' => $request->floor_number,
            'seat_capacity' => $request->seat_capacity,
        ]);

        if(!$updated)
        {
            return redirect()->back()->with('error','Update Action Failed');
        }
        else
        {
            return redirect()->route('room')->with('success','Update Successful');
        }
        
    }
}
