<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Update Student Information') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            <form method="POST" action="{{route('student.update',$student->id)}}">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" required autofocus value="{{$student->name}}"/>
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <!-- Default Role will be student-->

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" required value="{{$student->email}}"/>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Phone Number -->
                <div>
                    <x-input-label for="phone_number" :value="__('Phone Number')" />
                    <x-text-input id="phone_number" class="block mt-1 w-full" type="text" name="phone_number" required autofocus value="{{$student->phone_number}}"/>
                    <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
                </div>

                <!-- Address -->
                <div>
                    <x-input-label for="address" :value="__('Address')" />
                    <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" required autofocus value="{{$student->address}}"/>
                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between mt-4">
                    <x-button-cancel :cancelRoute="route('student')">
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