<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add New Subject') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{route('subject.store')}}" method="POST">
                    @csrf

                    <!-- Subject Name -->
                    <div class="mb-4">
                        <label for="subject" class="block text-white text-lg font-bold mb-2">Subject</label>
                        <input type="text" name="subject" id="subject" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" required>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex flex-row justify-between">
                        <x-button-cancel :cancelRoute="route('subject')">
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
