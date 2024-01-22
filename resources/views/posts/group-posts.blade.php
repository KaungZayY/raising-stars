@push('scripts')
    <!-- JScroll CDN links -->
    <!-- '@'push to push to master layout, '@'stack('scripts')in master to fetch this script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.4.1/jquery.jscroll.min.js"></script>

    <!-- Post.JS -->
    <script>
        // Define JavaScript variables with route URLs
        const likeRoute = "{{ route('post.like') }}";
        const unlikeRoute = "{{ route('post.unlike') }}";
        const commentRoute = "{{ route('post.comment') }}";
        var csrf = "{{ csrf_token() }}";
    </script>
    <script src="{{asset('javascript/post.js')}}"></script>
@endpush

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            "{{$group->name}}" Group Discussion
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-row justify-end">
                <a href="{{ route('post.create',$group->id) }}" class="bg-green-500 text-white px-2 py-1 mb-6 rounded-md">Create Post</a>
            </div>
            <div class="overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div id="posts-container" class="text-white scrolling-pagination">
                    @if ($posts->count())
                        @foreach($posts as $post)
                        <div class="post bg-grey-200 dark:bg-gray-800 shadow-sm sm:rounded-lg border border-gray-400 mb-3 mt-3">
                            <x-post-card :post="$post" :showGpName="false">
                            </x-post-card>
                        </div>
                        @endforeach
                        <div style="display:none">
                            {{ $posts->links() }}
                        </div>
                    @else
                        <p class="text-lg text-center text-black dark:text-white">No Posts Here</p>
                    @endif
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
    });

    function postDetail(route_url) 
    {
        window.location.href = route_url;
    }
</script>