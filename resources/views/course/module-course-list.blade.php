<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-green-500 leading-tight">
            {{ __('Modules for  ') }}{{$course->course}}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-row justify-between">
                <form action="{{route('course')}}" method="GET">
                    <button class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg mb-2">
                        Back
                    </button>
                </form>
                <form action="{{route('course.moduleadd',$course->id)}}" method="GET">
                    <button class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg mb-2">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" height="20" width="16" viewBox="0 0 448 512" class="mr-2">
                                <path fill="#FFFFFF" d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/>
                            </svg>
                            Add Module
                        </div>
                    </button>
                </form>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300 border-separate">
                  <thead class="with-larasort">
                    <tr>
                        <th class="py-2 px-4 border-b bg-teal-300">No</th>
                        <th class="py-2 px-4 border-b bg-teal-300">Module Number</th>
                        <th class="py-2 px-4 border-b bg-teal-300">Subject</th>
                        <th class="py-2 px-4 border-b bg-teal-300">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                @if ($course->modules->count())
                    @foreach ($course->modules as $module)
                    <tr>
                        <td class="py-2 px-4 border-b text-center bg-gray-200">{{$loop->iteration}}</td>
                        <td class="py-2 px-4 border-b text-center bg-gray-200">{{$module->module_number}}</td>
                        <td class="py-2 px-4 border-b text-center bg-gray-200">{{$module->subject->subject}}</td>
                        <td class="py-2 px-4 border-b text-center bg-gray-200">
                            <div class="inline-block">
                                <form action="{{route('course.moduleremove',$course->id)}}" method="POST" onsubmit="return confirm('Remove {{$module->module_number}} form {{$course->course}} Course?');">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="module_id" value="{{$module->id}}">
                                    <button>
                                        <svg xmlns="http://www.w3.org/2000/svg" height="20" width="16" viewBox="0 0 384 512">
                                            <path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="py-2 px-4 text-center" colspan="4">No Data found</td>
                    </tr>
                @endif
                  </tbody>
                </table>
              </div>

        </div>
    </div>
</x-app-layout>