<nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                {{-- <x-nav-link :href="route('')" :active="request()->routeIs('')">
                    {{ __('More Links Here') }}
                </x-nav-link> --}}
            </div>

            <div class="flex items-center space-x-4">
                <div class="space-x-4">
                    <x-nav-link :href="route('register')" :active="request()->routeIs('register')">
                        {{ __('Register') }}
                    </x-nav-link>

                    {{-- <x-nav-link :href="route('login')">
                        {{ __('Login') }}
                    </x-nav-link> --}}
                </div>
            </div>
        </div>
    </div>
</nav>
