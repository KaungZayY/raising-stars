<?php

namespace App\Http\Controllers;

use App\Exports\ModeratorExport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;


class ModeratorController extends Controller
{
    public function index()
    {
        $moderators = User::where('role_id',3)->autosort()->get();
        return view('moderator.moderator-list',compact('moderators'));
    }

    public function create()
    {
        return view('moderator.moderator-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone_number' => ['required', 'string', 'min:8','max:11'],
            'address' => ['required', 'string','min:3', 'max:255'],

        ]);
        // dd($request);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'role_id' => 3,
        ]);

        if(!$user)
        {
            return redirect()->back()->with('error','Cannot Add this User');
        }
        return redirect()->route('moderator')->with('success', 'New Moderator Added');  
    }

    public function edit(User $user)
    {
        return view('moderator.moderator-edit',['moderator'=>$user]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'phone_number' => ['required', 'string', 'min:8','max:11'],
            'address' => ['required', 'string','min:3', 'max:255'],
        ]);
        // dd($request);
        //Update DB transaction
        DB::beginTransaction();
        try
        {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone_number = $request->phone_number;
            $user->address = $request->address;
            $user->updated_at = now();
            $updated = $user->save();
            if(!$updated)
            {
                throw new \Exception('Error Updating User.');
            }
            DB::commit();
            return redirect()->route('moderator')->with('success', 'Information has Updated');
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            return redirect()->back()->with('error','Update Failed');
        }
        
    }

    public function destroy(User $user)
    {
        $deleted = $user->delete();
        if(!$deleted)
        {
            DB::rollBack();
            return redirect()->route('moderator')->with('error','Cannot Remove this User');
        }
        else
        {
            return redirect()->route('moderator')->with('success','User Archived');
        }
    }

    public function archives()
    {
        $moderators = User::onlyTrashed()->where('role_id',3)->get();
        return view('moderator.moderator-archives',['moderators'=>$moderators]);
    }

    public function restore($id)
    {
        $moderator = User::withTrashed()->findOrFail($id);
        $moderator->restore();
        return redirect()->route('moderator.archives')->with('success','User Restored');
    }

    public function forcedelete($id)
    {
        $moderator = User::withTrashed()->findOrFail($id);
        $moderator->forcedelete();
        return redirect()->route('moderator.archives')->with('success','User Removed Permanently');
    }

    public function export()
    {
        return (new ModeratorExport)->download('moderators.xlsx');
    }

    public function search(Request $request)
    {
        if($request->ajax())
        {
            $output="";
            $moderators=DB::table('users')->whereNull('deleted_at')->where('role_id',3)->where('name','LIKE','%'.$request->search."%")->get();

            if($moderators)
            {
                $counter = 1;
                foreach ($moderators as $key => $moderator) {
                    $output.=
                    '<tr>'.
                        '<td class="py-2 px-4 border-b text-center">'.$counter.'</td>'.
                        '<td class="py-2 px-4 border-b text-center">'.$moderator->name.'</td>'.
                        '<td class="py-2 px-4 border-b text-center">'.$moderator->email.'</td>'.
                        '<td class="py-2 px-4 border-b text-center">'.$moderator->phone_number.'</td>'.
                        '<td class="py-2 px-4 border-b text-center">'.$moderator->address.'</td>'.
                        '<td class="py-2 px-4 border-b text-center">'.
                            '<div class="inline-block">'.
                                '<form action="'.route('moderator.edit',$moderator->id).'" method="GET">'.
                                    '<button>
                                        <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512">
                                            <path fill="#22C55E" d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/>
                                        </svg>
                                    </button>'.
                                '</form>'.
                            '</div>'.
                            '<span class="ml-2 mr-2">|</span>'.
                            '<div class="inline-block">'.
                                '<form action="'.route('moderator.delete',$moderator->id).'" method="POST" onsubmit="return confirm(\'Move this Data to Archives?\');">' .
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
