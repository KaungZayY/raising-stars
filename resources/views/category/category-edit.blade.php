<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Category') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{route('category.update',$category->id)}}" method="POST">
                    @csrf

                    <!-- Category Name -->
                    <div class="mb-4">
                        <label for="category" class="block text-yellow-300 text-lg font-bold mb-2">Category Tag</label>
                        <input type="text" name="category" id="category" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" required value="{{$category->category}}">
                    </div>

                    <!-- Active On Off -->
                    <div class="flex items-center mb-4">
                        <input id="status" name="status" type="checkbox" {{$category->status ===1?'checked':''}} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="status" class="ms-2 text-sm font-medium text-yellow-300">Active Status</label>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex flex-row justify-between">
                        <x-button-cancel>
                            {{__('Cancel')}}
                        </x-button-cancel>
                        <x-button class="ms-4">
                            {{ __('Add') }}
                        </x-button>                                            
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
