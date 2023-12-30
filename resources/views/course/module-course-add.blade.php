@push('scripts')
    <!-- JQuery Ajax -->
    <!-- '@'push to push to master layout, '@'stack('scripts')in master to fetch this script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
@endpush


<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-yellow-500 leading-tight">
            {{ __('Assign Course to ') }}{{$course->course}}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-row justify-start">
                <form action="{{route('course.module',$course->id)}}" method="GET">
                    <button class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg mb-2">
                        Back
                    </button>
                </form>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300 border-separate">
                  <thead class="with-larasort">
                    <tr>
                        <th class="py-2 px-4 border-b bg-gray-300">No</th>
                        <th class="py-2 px-4 border-b bg-gray-300">Module Number</th>
                        <th class="py-2 px-4 border-b bg-gray-300">Subject</th>
                        <th class="py-2 px-4 border-b bg-gray-300">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                @if ($unassignedModules->count())
                    @foreach ($unassignedModules as $module)
                    <tr>
                        <td class="py-2 px-4 border-b text-center">{{$loop->iteration}}</td>
                        <td class="py-2 px-4 border-b text-center">{{$module->module_number}}</td>
                        <td class="py-2 px-4 border-b text-center">{{$module->subject->subject}}</td>
                        <td class="py-2 px-4 border-b text-center">
                            <div class="inline-block">
                                <button id="btn-add-{{$module->id}}" onclick="moduleAssigned({{$module->id}},{{$course->id}})" @if(!$course->modules($module->id)) style="display:none" @endif>
                                    <svg xmlns="http://www.w3.org/2000/svg" height="20" width="16" viewBox="0 0 448 512">
                                        <path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/>
                                    </svg>
                                </button>
                                <button id="btn-remove-{{$module->id}}" onclick="moduleUnassigned({{$module->id}},{{$course->id}})" @if($course->modules($module->id)) style="display:none" @endif>
                                    <svg xmlns="http://www.w3.org/2000/svg" height="20" width="16" viewBox="0 0 384 512">
                                        <path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/>
                                    </svg>
                                </button>
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

<script>
    function moduleAssigned(module_id,course_id)
    {
        const flashMessageContainer = $('#flash-message-container');
        $.ajax({
            url: "{{route('course.moduleassign')}}",
            method: 'POST',
            data: {
                '_token': '{{ csrf_token() }}',
                'module_id': module_id,
                'course_id' : course_id,
            },
            success: function() {
                $('#flash-message-container').html('<div style="background-color: #48bb78; color: #fff; padding: 0.5rem 1rem;">Module Added</div>');
                $('#btn-add-' + module_id).hide();
                $('#btn-remove-' + module_id).show();
                setTimeout(function() 
                {
                    flashMessageContainer.hide();
                }, 2000);
            },
            error: function() {
                $('#flash-message-container').html('<div style="background-color: #e40f0f; color: #fff; padding: 0.5rem 1rem;">Cannot add this Module</div>');
                setTimeout(function() 
                {
                    flashMessageContainer.hide();
                }, 2000);
            }
        });
    }

    function moduleUnassigned(module_id,course_id)
    {
        const flashMessageContainer = $('#flash-message-container');
        $.ajax({
            url: "{{route('course.moduleunassign')}}",
            method: 'DELETE',
            data: {
                '_token': '{{ csrf_token() }}',
                'module_id': module_id,
                'course_id' : course_id,
            },
            success: function() {
                $('#flash-message-container').html('<div style="background-color: #48bb78; color: #fff; padding: 0.5rem 1rem;">Module Removed</div>');
                $('#btn-remove-' + module_id).hide();
                $('#btn-add-' + module_id).show();
                setTimeout(function() 
                {
                    flashMessageContainer.hide();
                }, 2000);
            },
            error: function() {
                $('#flash-message-container').html('<div style="background-color: #e40f0f; color: #fff; padding: 0.5rem 1rem;">Cannot remove this Module</div>');
                setTimeout(function() 
                {
                    flashMessageContainer.hide();
                }, 2000);
            }
        });
    }
</script>