<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::autosort()->withCount('users')->get();
        return view('group.group-list',['groups'=>$groups]);
    }

    public function create()
    {
        return view('group.group-create');
    }

    public function store(Request $request)
    {
        // dd($request);
        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:groups,name',
            'description' => 'required',
        ]);
        
        if($validator->fails())
        {
            return redirect()->route('group')->with('error','Group already Exists or Action Failed');
        }

        $group = Group::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        if(!$group)
        {
            return redirect()->back()->with('error','Action Failed');
        }

        return redirect()->route('group')->with('success','Group Created');
    }

    public function edit(Group $group)
    {
        return view('group.group-edit',['group'=>$group]);
    }

    public function update(Request $request, Group $group)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:groups,name,'.$group->id,
            'description' => 'required',
        ]);

        if($validator->fails())
        {
            return redirect()->route('group')->with('error','Duplicated Group Or Action Failed');
        }

        $updated = $group->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        if(!$updated)
        {
            return redirect()->back()->with('error','Update Action Failed');
        }
        else
        {
            return redirect()->route('group')->with('success','Update Successful');
        }
    }

    public function destroy(Group $group)
    {
        // dd($group);
        $deleted = $group->delete();
        if(!$deleted)
        {
            return redirect()->route('group')->with('error','Cannot Remove this Group');
        }
        return redirect()->route('group')->with('success','Course Archived');
    }

    public function archives()
    {
        $groups = Group::onlyTrashed()->get();
        return view('group.group-archives',['groups'=>$groups]);
    }

    public function restore($id)
    {
        $group = Group::onlyTrashed()->findOrFail($id);
        $group->restore();
        return redirect()->route('group')->with('success','Group Restored');
    }

    public function forcedelete($id)
    {
        $group = Group::withTrashed()->findOrFail($id);
        $group->forceDelete();
        return redirect()->route('group.archives')->with('success','Group Deleted Permanently');
    }


    public function search(Request $request)
    {
        if($request->ajax())
        {
            $output="";
            $groups = DB::table('groups')
                ->leftJoin('user_group', 'groups.id', '=', 'user_group.group_id')
                ->leftJoin('users', 'user_group.user_id', '=', 'users.id')
                ->select('groups.*', DB::raw('COUNT(users.id) as user_count'))
                ->whereNull('groups.deleted_at')
                ->where('groups.name', 'LIKE', '%' . $request->search . '%')
                ->groupBy('groups.id')
                ->get();

            if($groups)
            {
                $counter = 1;
                foreach ($groups as $key => $group) {
                    $output.=
                    '<tr>'.
                        '<td class="py-2 px-4 border-b text-center">'.$counter.'</td>'.
                        '<td class="py-2 px-4 border-b text-center">'.$group->name.'</td>'.
                        '<td class="py-2 px-4 border-b text-center">'.$group->user_count.'</td>'.
                        '<td class="py-2 px-4 border-b text-center">'.$group->description.'</td>'.
                        '<td class="py-2 px-4 border-b text-center">'.
                            '<div class="inline-block">'.
                                '<form action="'.route('group.members',$group->id).'" method="GET">'.
                                    '<button>
                                    <svg xmlns="http://www.w3.org/2000/svg" height="16" width="20" viewBox="0 0 640 512">
                                        <path d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM609.3 512H471.4c5.4-9.4 8.6-20.3 8.6-32v-8c0-60.7-27.1-115.2-69.8-151.8c2.4-.1 4.7-.2 7.1-.2h61.4C567.8 320 640 392.2 640 481.3c0 17-13.8 30.7-30.7 30.7zM432 256c-31 0-59-12.6-79.3-32.9C372.4 196.5 384 163.6 384 128c0-26.8-6.6-52.1-18.3-74.3C384.3 40.1 407.2 32 432 32c61.9 0 112 50.1 112 112s-50.1 112-112 112z"/>
                                    </svg>
                                    </button>'.
                                '</form>'.
                            '</div>'.
                            '<span class="ml-2 mr-2">|</span>'.
                            '<div class="inline-block">'.
                                '<form action="'.route('group.edit',$group->id).'" method="GET">'.
                                    '<button>
                                        <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512">
                                            <path fill="#22C55E" d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/>
                                        </svg>
                                    </button>'.
                                '</form>'.
                            '</div>'.
                            '<span class="ml-2 mr-2">|</span>'.
                            '<div class="inline-block">'.
                                '<form action="'.route('group.delete',$group->id).'" method="POST" onsubmit="return confirm(\'Move this Data to Archives?\');">' .
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

    public function members($id)
    {
        $group = Group::findOrFail($id);
        $group->load('users');
        return view('group.group-members',compact('group'));
    }

    public function addMember($id)
    {
        $group = Group::findOrFail($id);
        $nonMembers = User::whereNotIn('id',$group->users->pluck('id'))->get();
        return view('group.group-members-add',compact('nonMembers','group'));
    }

    public function ajaxAdd(Request $request)
    {
        $group = Group::findOrFail($request->input('group_id'));
        $added = $group->users()->attach($request->input('user_id'));
        if(!$added)
        {
            return response()->json(['error' => 'Member Already Exists in the Group or Action Failed']);
        }
        return response()->json(['success' => 'Member Added to the Group']);
    }

    public function ajaxRemove(Request $request)
    {
        $group = Group::findOrFail($request->input('group_id'));
        $added = $group->users()->detach($request->input('user_id'));
        if(!$added)
        {
            return response()->json(['error' => 'Cannot Remove this Member']);
        }
        return response()->json(['success' => 'Member Removed from the Group']);
    }

    public function removeMember($groupId, $userId)
    {
        $group = Group::findOrFail($groupId);
        $user = User::findOrFail($userId);

        $removed = $group->users()->detach($user->id);

        if(!$removed)
        {
            return redirect()->back()->with('error','Cannot Remove this User form the Group');
        }
        return redirect()->route('group.members',$group->id)->with('success','Member Removed');
    }

    public function searchMember(Request $request, $id)
    {
        if($request->ajax())
        {
            $output = "";
            $members = DB::table('user_group')->where('user_group.group_id',$id)
                    ->leftJoin('users','user_group.user_id','=','users.id')
                    ->whereNull('users.deleted_at')
                    ->where('users.name','LIKE','%'.$request->search.'%')
                    ->select('users.name','users.email','users.role_id','user_group.created_at','users.id as uid','user_group.group_id as gid')
                    ->get();
            // return response()->json(['debug'=>$members]);
            if($members)
            {
                $counter = 1;
                foreach($members as $user)
                {
                    $output .= '<tr>'.
                        '<td class="py-2 px-4 border-b text-center">'.$counter.'</td>'.
                        '<td class="py-2 px-4 border-b text-center">'.$user->name.'</td>'.
                        '<td class="py-2 px-4 border-b text-center">'.$user->email.'</td>'.
                        '<td class="py-2 px-4 border-b text-center">';
                        // Role
                        if($user->role_id == 1) {
                            $output .= 'Student';
                        } elseif($user->role_id == 2) {
                            $output .= 'Lecturer';
                        } elseif($user->role_id == 3) {
                            $output .= 'Moderator';
                        } elseif($user->role_id == 4) {
                            $output .= 'Admin';
                        } else {
                            $output .= 'Unknown Role';
                        }
                    $output .= '</td>'.
                        '<td class="py-2 px-4 border-b text-center">'.\Carbon\Carbon::parse($user->created_at)->diffForHumans().'</td>'.
                        '<td class="py-2 px-4 border-b text-center">'.
                            '<div class="inline-block">'.
                                '<form action="'.route('group.removeMember',['groupId'=>$user->gid,'userId'=>$user->uid]).'" method="POST" onsubmit="return confirm(\'Remove this member from the group?\');">'.
                                    '<input type="hidden" name="_token" value="' . csrf_token() . '">' .
                                    '<input type="hidden" name="_method" value="DELETE">' .
                                    '<button>'.
                                        '<svg xmlns="http://www.w3.org/2000/svg" height="22" width="20" viewBox="0 0 640 512">'.
                                            '<path fill="#EF4444" d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM472 200H616c13.3 0 24 10.7 24 24s-10.7 24-24 24H472c-13.3 0-24-10.7-24-24s10.7-24 24-24z"/>'.
                                        '</svg>'.
                                    '</button>'.
                                '</form>'.
                            '</div>'.
                        '</td>'.
                    '</tr>';

                    $counter++;
                }
                return Response ($output);
            }
        }
    }

    public function searchNonMember(Request $request, $id)
    {
        if($request->ajax())
        {
            $output = "";
            $group = Group::findOrFail($id);
            $nonMembers = DB::table('users')
                ->whereNotIn('id', $group->users->pluck('id'))
                ->where('name','LIKE','%'.$request->search.'%')
                ->select('name','email','role_id','id')
                ->get();
            // return response()->json(['debug'=>$nonMembers]);
            if($nonMembers)
            {
                $counter = 1;
                foreach($nonMembers as $user)
                {
                    $output .= '<tr>'.
                                '<td class="py-2 px-4 border-b text-center">'.$counter.'</td>'.
                                '<td class="py-2 px-4 border-b text-center">'.$user->name.'</td>'.
                                '<td class="py-2 px-4 border-b text-center">'.$user->email.'</td>'.
                                '<td class="py-2 px-4 border-b text-center">';
                                    // Role
                                    if($user->role_id == 1) {
                                        $output .= 'Student';
                                    } elseif($user->role_id == 2) {
                                        $output .= 'Lecturer';
                                    } elseif($user->role_id == 3) {
                                        $output .= 'Moderator';
                                    } elseif($user->role_id == 4) {
                                        $output .= 'Admin';
                                    } else {
                                        $output .= 'Unknown Role';
                                    }
                    $output .= '</td>'.
                                '<td class="py-2 px-4 border-b text-center">'.
                                    '<div class="inline-block">'.
                                        '<button id="btn-add-'.$user->id.'" onclick="userAdd('.$user->id.','.$group->id.')" '.(!$group->users($user->id) ? 'style="display:none"' : '').'>'.
                                            '<svg xmlns="http://www.w3.org/2000/svg" height="20" width="16" viewBox="0 0 448 512">'.
                                                '<path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/>'.
                                            '</svg>'.
                                        '</button>'.
                                        '<button id="btn-remove-'.$user->id.'" onclick="userRemove('.$user->id.','.$group->id.')" '.($group->users($user->id) ? 'style="display:none"' : '').'>'.
                                            '<svg xmlns="http://www.w3.org/2000/svg" height="20" width="16" viewBox="0 0 384 512">'.
                                                '<path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/>'.
                                            '</svg>'.
                                        '</button>'.
                                    '</div>'.
                                '</td>'.
                        '</tr>';
                    $counter++;
                }
                return Response ($output);
            }

        }
    }

    public function myGroups()
    {
        $groups = Group::whereHas('users', function ($query) {
            $query->where('user_id', Auth::id());
        })->withCount('users')
        ->get();
        return view('universal-view.my-groups',compact('groups'));
    }

    public function viewGroup(Group $group)
    {
        dd($group);
    }
}
