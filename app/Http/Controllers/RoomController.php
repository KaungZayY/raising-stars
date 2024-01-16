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
        $rooms = Room::autosort()->get();
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

    public function destroy(Room $room)
    {
        // dd($room);
        $deleted = $room->delete();
        if(!$deleted)
        {
            return redirect()->back()->with('error','Cannot Remove This Room');
        }
        return redirect()->route('room')->with('success','Room Archived');
    }

    public function archives()
    {
        $rooms = Room::onlyTrashed()->get();
        return view('room.room-archives',['rooms'=>$rooms]);
    }

    public function restore($id)
    {
        $room = Room::onlyTrashed()->findOrFail($id);
        $room->restore();
        return redirect()->route('room')->with('success','Room Restored');
    }

    public function forcedelete($id)
    {
        $room = Room::withTrashed()->findOrFail($id);
        $room->forceDelete();
        return redirect()->route('room.archives')->with('success','Room Deleted Permanently');
    }

    public function search(Request $request)
    {
        if($request->ajax())
        {
            $output="";
            $rooms=DB::table('rooms')->whereNull('deleted_at')->where('room_number','LIKE','%'.$request->search."%")->get();

            if($rooms)
            {
                $counter = 1;
                foreach ($rooms as $key => $room) {
                    $output.=
                    '<tr>'.
                        '<td class="py-2 px-4 border-b text-center">'.$counter.'</td>'.
                        '<td class="py-2 px-4 border-b text-center">'.$room->room_number.'</td>'.
                        '<td class="py-2 px-4 border-b text-center">'.$room->floor_number.'</td>'.
                        '<td class="py-2 px-4 border-b text-center">'.$room->seat_capacity.'</td>'.
                        '<td class="py-2 px-4 border-b text-center">'.
                            '<div class="inline-block">'.
                                '<form action="'.route('room.edit',$room->id).'" method="GET">'.
                                    '<button>
                                        <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512">
                                            <path fill="#22C55E" d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/>
                                        </svg>
                                    </button>'.
                                '</form>'.
                            '</div>'.
                            '<span class="ml-2 mr-2">|</span>'.
                            '<div class="inline-block">'.
                                '<form action="'.route('room.delete',$room->id).'" method="POST" onsubmit="return confirm(\'Move this Data to Archives?\');">' .
                                    '<input type="hidden" name="_token" value="' . csrf_token() . '">' .
                                    '<input type="hidden" name="_method" value="DELETE">' .
                                    '<button>
                                        <svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512">
                                            <path fill="#EF4444" d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/>
                                        </svg>
                                    </button>'.
                                '</form>'.
                            '</div>'.
                        '</td>'.
                    '</tr>';
                    $counter++;
                }
                return Response($output);
            }
            
        }
    }
}
