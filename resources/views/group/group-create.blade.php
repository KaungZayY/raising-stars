<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create New Group') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{route('group.store')}}" method="POST">
                    @csrf

                    <!-- Group Name -->
                    <div class="mb-4">
                        <label for="name" class="block dark:text-white text-lg font-bold mb-2">Group Name</label>
                        <input type="text" name="name" id="name" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" required>
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label for="description" class="block dark:text-white text-lg font-bold mb-2">Group Description</label>
                        <textarea name="description" id="description" rows="4" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" required></textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex flex-row justify-between">
                        <div class="flex w-1/2 justify-center">
                            <x-button-cancel :cancelRoute="route('group')">
                                {{__('Cancel')}}
                            </x-button-cancel>
                        </div>
                        <div class="flex w-1/2 justify-center">
                            <x-button class="ms-4">
                                {{ __('Add') }}
                            </x-button>     
                        </div>                                       
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
