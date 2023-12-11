@push('scripts')
    <!-- JScroll CDN links -->
    <!-- '@'push to push to master layout, '@'stack('scripts')in master to fetch this script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.4.1/jquery.jscroll.min.js"></script>
@endpush

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div id="posts-container" class="text-white scrolling-pagination">
                    @foreach($posts as $post)
                        <div class="post bg-gray-800 rounded-lg p-4 mb-4 shadow-md">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-start">
                                    {{-- <img src="{{ $post->user->profile_image }}" alt="Profile Image" class="w-8 h-8 rounded-full mr-2"> --}}
                                    <h2 class="text-xl font-semibold">{{ $post->user->name }}</h2>
                                </div>
                                <div class="flex">
                                    <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-lg font-bold mb-2">{{ $post->title }}</h3>
                                <svg xmlns="http://www.w3.org/2000/svg" height="16" width="4" viewBox="0 0 128 512" class="toggle-icon"><path d="M64 360a56 56 0 1 0 0 112 56 56 0 1 0 0-112zm0-160a56 56 0 1 0 0 112 56 56 0 1 0 0-112zM120 96A56 56 0 1 0 8 96a56 56 0 1 0 112 0z"/></svg>
                            </div>
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-start">
                                    <p class="text-gray-300 mb-4">{{ $post->content }}</p>
                                </div>
                                <div class="option-container hidden flex-row-reverse">
                                    <button class="bg-blue-500 text-white px-2 py-1 mb-2">Edit</button>
                                    <button class="bg-red-500 text-white px-2 py-1 mb-2">Delete</button>
                                </div>
                            </div>
                            <!-- Post Category Tags -->
                            @if ($post->categories->isNotEmpty())
                                <p class="text-gray-500">Categories: 
                                    @foreach ($post->categories as $category)
                                        {{$category->category}}
                                        @unless ($loop->last), @endunless
                                        {{-- above line adding coma after each loop, unless for the last item --}}
                                    @endforeach
                                </p>
                            @endif
                        </div>
                    @endforeach
                    <div style="display:none">
                        {{ $posts->links() }}
                    </div>
                </div>                
                
            </div>
        </div>
    </div>
</x-app-layout>

<script type="text/javascript">
    $(document).ready(function() //jquery ready func
    {
        //jscroll 
        $('.scrolling-pagination').jscroll(
        {
            autoTrigger: true,
            padding: 0,
            nextSelector: 'a[rel="next"]',
            contentSelector: '.post',
            callback: function() {
                $('ul.pagination').remove();
            },
            errorCallback: function() {
                console.log('Error loading next page.');
            }
        });

        //menu toggle
        $('.option-container').hide();
        $('.toggle-icon').click(function(){
            $('.option-container').toggle();
        });
        $('.toggle-icon').hover(
            function() { $(this).css('cursor', 'pointer'); },
            function() { $(this).css('cursor', 'auto'); }
        );
    });
</script>
