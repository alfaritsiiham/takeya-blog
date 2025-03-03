<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-10 sm:px-6 lg:px-8">

            @if(!Auth::check())
                {{-- for gueset users --}}
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <p>Please <a href="{{ route('login') }}" class="text-blue-500">login</a> or
                        <a href="{{ route('register') }}" class="text-blue-500">register</a>.</p>
                    </div>
                </div>
            @else
                {{-- for authenticated users --}}
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="space-y-6 p-6">
                        <h2 class="text-lg font-semibold">Your Posts</h2>

                        @if(count($posts) == 0)
                            <center>No Data...</center>
                        @else
                            @foreach($posts as $val)
                                <div class="rounded-md border p-5 shadow">
                                    <div class="flex items-center gap-2">

                                        @if($val->status == App\Models\Post::STATUS_PUBLISHED)
                                            <span class="flex-none rounded bg-green-100 px-2 py-1 text-green-800">{{ $val->status }}</span>
                                        @elseif($val->status == App\Models\Post::STATUS_DRAFT)
                                            <span class="flex-none rounded bg-gray-100 px-2 py-1 text-gray-800">{{ $val->status }}</span>
                                        @elseif($val->status == App\Models\Post::STATUS_SCHEDULED)
                                            <span class="flex-none rounded bg-yellow-100 px-2 py-1 text-yellow-800">{{ $val->status }}</span>
                                        @endif

                                        <h3><a href="{{ route('posts.show', $val->slug) }}" class="text-blue-500">{{ $val->title }}</a></h3>
                                    </div>
                                    <div class="mt-4 flex items-end justify-between">
                                        <div>
                                            @if($val->status == App\Models\Post::STATUS_SCHEDULED)
                                                <div>Scheduled: {{ $val->publish_date }}</div>
                                            @else
                                                <div>Published: {{ $val->publish_date ?? '-' }}</div>
                                            @endif
                                            <div>Updated: {{ $val->updated_at }}</div>
                                        </div>
                                        <div>
                                            <a href="{{ route('posts.show', $val->slug) }}" class="text-blue-500">Detail</a> /
                                            <a href="{{ route('posts.edit', $val->slug) }}" class="text-blue-500">Edit</a> /
                                            <form action="{{ route('posts.delete', $val->slug) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="text-red-500">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        <div>
                            {{ $posts->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
