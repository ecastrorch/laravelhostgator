<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Movie') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.movies.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Movie Name -->
                        <div class="mb-4">
                            <label for="name" class="block font-medium text-sm text-gray-700">
                                {{ __('Movie Name') }}
                            </label>
                            <input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ old('name') }}"
                                required autofocus />
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="block font-medium text-sm text-gray-700">
                                {{ __('Description') }}
                            </label>
                            <textarea id="description" class="block mt-1 w-full" name="description"
                                required>{{ old('description') }}</textarea>
                        </div>

                        <!-- Duration -->
                        <div class="mb-4">
                            <label for="duration" class="block font-medium text-sm text-gray-700">
                                {{ __('Duration (min)') }}
                            </label>
                            <input id="duration" class="block mt-1 w-full" type="number" name="duration"
                                value="{{ old('duration') }}" required />
                        </div>

                        <!-- Trailer Link -->
                        <div class="mb-4">
                            <label for="trailer_link" class="block font-medium text-sm text-gray-700">
                                {{ __('Trailer Link') }}
                            </label>
                            <input id="trailer_link" class="block mt-1 w-full" type="url" name="trailer_link"
                                value="{{ old('trailer_link') }}" required />
                        </div>

                        <!-- Stream Link -->
                        <div class="mb-4">
                            <label for="stream_link" class="block font-medium text-sm text-gray-700">
                                {{ __('Stream Link') }}
                            </label>
                            <input id="stream_link" class="block mt-1 w-full" type="url" name="stream_link"
                                value="{{ old('stream_link') }}" required />
                        </div>

                        <!-- Genres -->
                        <div class="mb-4">
                            <label for="genres" class="block font-medium text-sm text-gray-700">
                                {{ __('Genres') }}
                            </label>
                            <select id="genres" class="block mt-1 w-full" name="genres[]" multiple required>
                                @foreach($allGenres as $genre)
                                    <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Cover Image -->
                        <div class="mb-4">
                            <label for="cover_image" class="block font-medium text-sm text-gray-700">
                                {{ __('Cover Image') }}
                            </label>
                            <input id="cover_image" class="block mt-1 w-full" type="file" name="cover_image"
                                accept="image/*" required />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit"
                                style="background-color: green; color: white; padding: 10px 20px; border-radius: 5px;">
                                {{ __('Create Movie') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
