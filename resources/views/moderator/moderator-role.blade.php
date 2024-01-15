<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Update Moderator Role') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 mt-12">
            <form method="POST" action="{{route('moderator.role',$moderator->id)}}">
                @csrf
                <div class="mt-4 mb-4">
                    <x-input-label for="role_id" :value="__('Role')" />
                    <select name="role_id" id="role_id" class="block mt-1 w-full form-control" style="border-radius: 0.375rem;">
                        <option value = 3 {{ $moderator->role_id === 3 ? 'selected' : '' }}>Moderator</option>
                        <option value = 4 {{ $moderator->role_id === 4 ? 'selected' : '' }}>Admin</option>
                    </select>
                    <x-input-error :messages="$errors->get('role')" class="mt-2" />
                </div>
                
                <div class="flex items-center justify-between mt-8">
                    <x-button-cancel :cancelRoute="route('moderator')">
                        {{__('Cancel')}}
                    </x-button-cancel>
                    <x-primary-button class="ms-4">
                        {{ __('Save') }}
                    </x-primary-button>
                </div>
            </form>
            </div>
        </div>
    </div>
</x-app-layout>