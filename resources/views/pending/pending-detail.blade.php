<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pending Detail ') }}
        </h2>
    </x-slot>
    <div class="py-8">
        <div class="max-w-5xl mx-auto">
            <form action="{{route('pending')}}" method="GET">
                <button class="px-3 py-1 bg-green-500 hover:bg-green-700 text-white font-semibold rounded-md">
                    Back
                </button>
            </form>
        </div>
        <div class="text-center">
            <h1 class="text-black dark:text-white mb-4 text-2xl">Course Overview</h1>
        </div>
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 bg-gray-200 dark:bg-gray-700 rounded-lg">
            <div class="flex flex-col">
                <div class="flex flex-row flex-grow">
                    <div class="w-1/2 text-center mt-2">
                        <h1 class="text-gray-700 dark:text-gray-300 mb-4 text-lg">Course Name </h1>
                    </div>
                    <span class="text-lg text-gray-700 dark:text-gray-300 mb-4 mt-2">:</span>
                    <div class="w-1/2 text-center mt-2">
                        <p class="text-green-600 dark:text-green-400 ml-1 mb-4 text-lg">{{ $pending[0]->course }}
                        </p>
                    </div>
                </div>
                <div class="flex flex-row flex-grow">
                    <div class="w-1/2 text-center mt-2">
                        <h1 class="text-gray-700 dark:text-gray-300 mb-4 text-lg">Fees </h1>
                    </div>
                    <span class="text-lg text-gray-700 dark:text-gray-300 mb-4 mt-2">:</span>
                    <div class="w-1/2 text-center mt-2">
                        <p class="text-red-600 dark:text-red-400 ml-1 mb-4 text-lg underline">{{ $pending[0]->fees }}
                        </p>
                    </div>
                </div>
                <div class="flex flex-row flex-grow">
                    <div class="w-1/2 text-center">
                        <h1 class="text-gray-700 dark:text-gray-300 mb-4 text-lg">Start Date </h1>
                    </div>
                    <span class="text-lg text-gray-700 dark:text-gray-300 mb-4">:</span>
                    <div class="w-1/2 text-center">
                        <p class="text-green-600 dark:text-green-400 ml-1 mb-4 text-lg">{{ $pending[0]->start_date }}
                        </p>
                    </div>
                </div>
                <div class="flex flex-row flex-grow">
                    <div class="w-1/2 text-center">
                        <h1 class="text-gray-700 dark:text-gray-300 mb-4 text-lg">End </h1>
                    </div>
                    <span class="text-lg text-gray-700 dark:text-gray-300 mb-4">:</span>
                    <div class="w-1/2 text-center">
                        <p class="text-green-600 dark:text-green-400 ml-1 mb-4 text-lg">{{ $pending[0]->end_date }}</p>
                    </div>
                </div>
                <!-- Flex Row -->
                <div class="flex flex-row flex-grow">
                    <div class="w-1/2 text-center">
                        <h1 class="text-gray-700 dark:text-gray-300 mb-4 text-lg">Session </h1>
                    </div>
                    <span class="text-lg text-gray-700 dark:text-gray-300 mb-4">:</span>
                    <div class="w-1/2 text-center">
                        <p class="text-green-600 dark:text-green-400 ml-1 mb-4 text-lg">{{ $pending[0]->session }}</p>
                    </div>
                </div>
                <!-- Flex Row Ends -->
                <div class="flex flex-row flex-grow">
                    <div class="w-1/2 text-center">
                        <h1 class="text-gray-700 dark:text-gray-300 mb-4 text-lg">Student Limit </h1>
                    </div>
                    <span class="text-lg text-gray-700 dark:text-gray-300 mb-4">:</span>
                    <div class="w-1/2 text-center">
                        <p class="text-green-600 dark:text-green-400 ml-1 mb-4 text-lg">{{ $pending[0]->student_limit }}
                        </p>
                    </div>
                </div>
                <div class="flex flex-row flex-grow">
                    <div class="w-1/2 text-center">
                        <h1 class="text-gray-700 dark:text-gray-300 mb-4 text-lg">Schedule Description </h1>
                    </div>
                    <span class="text-lg text-gray-700 dark:text-gray-300 mb-4">:</span>
                    <div class="w-1/2 text-center">
                        <p class="text-green-600 dark:text-green-400 ml-1 mb-4 text-lg">
                            {{ $pending[0]->schedule_description }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center">
            <h1 class="text-black dark:text-white mb-4 text-2xl">Student Information</h1>
        </div>
        <x-student-info-admin-view :pending="$pending">
        </x-student-info-admin-view>
        <div class="flex flex-row">
            <div class="flex flex-row flex-grow w-full mb-2 mt-2 items-center">
                <div class="w-1/2 text-center mt-2">
                    <form action="{{route('pending.reject',$pending[0]->pending_id)}}" method="POST" onsubmit="return confirm('Reject this form?');">
                        @csrf
                        <x-button-reject class="ms-4">
                            {{ __('Reject') }}
                        </x-button-reject>
                    </form>
                </div>
                <div class="w-1/2 text-center">
                    <form action="{{route('pending.approve',$pending[0]->pending_id)}}" method="POST" onsubmit="return confirm('Approve this form?');">
                        @csrf
                        <x-button class="ms-4">
                            {{ __('Approve') }}
                        </x-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
