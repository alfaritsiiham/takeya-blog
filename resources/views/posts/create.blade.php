<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <form method="post" action="{{ route('posts.insertOrUpdate') }}" class="space-y-6">
                            {{ csrf_field() }}
                            <x-text-input name="act" type="hidden" value="{{ $act }}" />

                            <div>
                                <x-input-label for="title" :value="__('Title')" />
                                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" value="{{ old('title') }}" />
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="content" :value="__('Content')" />
                                <textarea id="content" name="content" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="6">{{ old('content') }}</textarea>
                                <x-input-error :messages="$errors->get('content')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="post_schedule" :value="__('Post Schedule')" />

                                <select id="post_schedule" onchange="scheduleChange()" name="post_schedule" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="0" {{ old('post_schedule') == App\Models\Post::STATUS_DRAFT ? 'selected' : '' }}>Draft</option>
                                    <option value="1" {{ old('post_schedule') == App\Models\Post::STATUS_SCHEDULED ? 'selected' : '' }}>Schedule</option>
                                    <option value="2" {{ old('post_schedule') == App\Models\Post::STATUS_PUBLISHED ? 'selected' : '' }}>Publish Now</option>
                                </select>
                                <x-input-error :messages="$errors->get('post_schedule')" class="mt-2" />
                            </div>

                            <div id="publishedDiv" class="hidden">
                                <x-input-label for="published_at" :value="__('Publish Date')" />
                                <x-text-input id="published_at" name="published_at" type="date" class="mt-1 block w-full" value="{{ old('published_at') }}" />
                                <x-input-error :messages="$errors->get('published_at')" class="mt-2" />
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Post') }}</x-primary-button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script>
            function scheduleChange() {
                var post_schedule = $('#post_schedule').val();

                if (post_schedule == 1) {
                    $('#publishedDiv').show();
                } else {
                    $('#publishedDiv').hide();
                }
            }
        </script>
    </x-slot>
</x-app-layout>
