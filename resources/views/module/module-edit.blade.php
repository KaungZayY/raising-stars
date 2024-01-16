@push('scripts')
    <!-- Select2 CDN links -->
    <!-- '@'push to push to master layout, '@'stack('scripts')in master to fetch this script -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
@endpush

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Module') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{route('module.edit',$module->id)}}" method="POST">
                    @csrf

                    <!-- Module Number -->
                    <div class="mb-4">
                        <label for="module_number" class="block dark:text-white text-lg font-bold mb-2">Module Number</label>
                        <input type="text" name="module_number" id="module_number" value="{{$module->module_number}}" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" required placeholder="Eg - M-01">
                    </div>

                    <!-- Subject -->
                    <div class="mb-4">
                        <label for="subject_id" class="block dark:text-white text-lg font-bold mb-2">Subject</label>
                        <select name="subject_id" id="subject_id" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500">
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" {{$module->subject_id == $subject->id ? 'selected' : '' }}>{{ $subject->subject }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Lecturers -->
                    <div class="mb-4">
                        <label for="lecturers" class="block dark:text-white text-lg font-bold mb-2">lecturers</label>
                        <select name="lecturers[]" id="lecturers" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" multiple required>
                            @foreach($lecturers as $lecturer)
                                <option value="{{ $lecturer->id }}" {{ in_array($lecturer->id, $module->lecturers->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $lecturer->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex flex-row justify-between">
                        <x-button-cancel :cancelRoute="route('module')">
                            {{__('Cancel')}}
                        </x-button-cancel>
                        <x-button class="ms-4">
                            {{ __('Update') }}
                        </x-button>                                            
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- select 2 script -->
<script>
    $(document).ready(function() {
        $('#lecturers').select2({
            tags: true,
        });
    });
</script>
