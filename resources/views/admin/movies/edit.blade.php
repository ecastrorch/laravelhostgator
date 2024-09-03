<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Movie') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.movies.update', $movie->slug) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Movie Name -->
                        <div class="mb-4">
                            <label for="name" class="block font-medium text-sm text-gray-700">
                                {{ __('Movie Name') }}
                            </label>
                            <input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ old('name', $movie->name) }}"
                                required autofocus />
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="block font-medium text-sm text-gray-700">
                                {{ __('Description') }}
                            </label>
                            <textarea id="description" class="block mt-1 w-full" name="description"
                                required>{{ old('description', $movie->description) }}</textarea>
                        </div>

                        <!-- Duration -->
                        <div class="mb-4">
                            <label for="duration" class="block font-medium text-sm text-gray-700">
                                {{ __('Duration (min)') }}
                            </label>
                            <input id="duration" class="block mt-1 w-full" type="number" name="duration"
                                value="{{ old('duration', $movie->duration) }}" required />
                        </div>

                        <!-- Trailer Link -->
                        <div class="mb-4">
                            <label for="trailer_link" class="block font-medium text-sm text-gray-700">
                                {{ __('Trailer Link') }}
                            </label>
                            <input id="trailer_link" class="block mt-1 w-full" type="url" name="trailer_link"
                                value="{{ old('trailer_link', $movie->trailer_link) }}" required />
                        </div>

                        <!-- Stream Link -->
                        <div class="mb-4">
                            <label for="stream_link" class="block font-medium text-sm text-gray-700">
                                {{ __('Stream Link') }}
                            </label>
                            <input id="stream_link" class="block mt-1 w-full" type="url" name="stream_link"
                                value="{{ old('stream_link', $movie->stream_link) }}" required />
                        </div>

                        <!-- Géneros -->
                        <div class="mb-4">
                            <label for="genres" class="block font-medium text-sm text-gray-700">
                                {{ __('Genres') }}
                            </label>
                            <select id="genres" class="block mt-1 w-full" name="genres[]" multiple required>
                                @foreach($allGenres as $genre)
                                    <option value="{{ $genre->id }}" {{ in_array($genre->id, $movie->genres->pluck('id')->toArray()) ? 'selected' : '' }}>
                                        {{ $genre->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Cover Image -->
                        <div class="mb-4">
                            <label for="cover_image" class="block font-medium text-sm text-gray-700">
                                {{ __('Cover Image') }}
                            </label>
                            @if($movie->cover_image)
                                <div class="mb-2">
                                    <img src="{{ asset('images/covers/' . $movie->cover_image) }}" alt="{{ $movie->name }}" class="h-40 w-40 object-cover">
                                </div>
                            @endif
                            <input id="cover_image" class="block mt-1 w-full" type="file" name="cover_image"
                                accept="image/*" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit"
                                style="background-color: blue; color: white; padding: 10px 20px; border-radius: 5px;">
                                {{ __('Update Movie') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
