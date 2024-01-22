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
            @if ($groups !== null)
                {{ __('Create a New Post') }}
            @else
                {{ __('Create post to ') }}{{$group->name}}
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('post.store') }}" method="POST">
                    @csrf

                    <!-- Title -->
                    <div class="mb-4">
                        <label for="title" class="block dark:text-white text-lg font-bold mb-2">Title</label>
                        <input type="text" name="title" id="title" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" required>
                    </div>

                    <!-- Content -->
                    <div class="mb-4">
                        <label for="content" class="block dark:text-white text-lg font-bold mb-2">Content</label>
                        <textarea name="content" id="content" rows="4" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" required></textarea>
                    </div>

                    <!-- Category -->
                    <div class="mb-4">
                        <label for="categories" class="block dark:text-white text-lg font-bold mb-2">Category</label>
                        <select name="categories[]" id="categories" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" multiple>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->category }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Group -->
                    @if ($groups != null)
                        <div class="mb-4">
                            <label for="group_id" class="block dark:text-white text-lg font-bold mb-2">Upload to </label>
                            <select name="group_id" id="group_id" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" required>
                                <option value="">-- Select Group --</option>
                                @foreach($groups as $group)
                                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @else
                        <input type="hidden" name="group_id" id="group_id" value="{{$group->id}}" required>
                        <input type="hidden" name="group" id="group" value="{{$group->id}}" required>
                    @endif

                    <!-- Submit Button -->
                    <div class="flex flex-row justify-between">
                        <div class="flex w-1/2 justify-center">
                            @if ($groups != null)
                                <x-button-cancel :cancelRoute="route('home')">
                                    {{__('Cancel')}}
                                </x-button-cancel>
                            @else
                                <x-button-cancel :cancelRoute="route('group.view',$group->id)">
                                    {{__('Cancel')}}
                                </x-button-cancel>
                            @endif
                        </div>
                        <div class="flex w-1/2 justify-center">
                            <x-button>
                                {{ __('Post') }}
                            </x-button>       
                        </div>                            
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- select 2 script -->
<script>
    $(document).ready(function() {
        $('#categories').select2({
            tags: true,
        });
    });
</script>
