<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Movies') }}
            </h2>
            <a href="{{ route('admin.movies.create') }}"
                style="background-color: green; color: white; padding: 10px 20px; border-radius: 5px;">
                {{ __('Add Movie') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($movies->isEmpty())
                        <p>{{ __('No movies found.') }}</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full w-full leading-normal">
                                <thead>
                                    <tr>
                                        <th
                                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            {{ __('Movie Name') }}
                                        </th>
                                        <th
                                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            {{ __('Description') }}
                                        </th>
                                        <th
                                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            {{ __('Trailer Link') }}
                                        </th>
                                        <th
                                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            {{ __('Actions') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($movies as $movie)
                                        <tr>
                                            <td
                                                class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                <div class="font-bold text-lg">{{ $movie->name }}</div>
                                            </td>
                                            <td
                                                class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                <p>{{ $movie->description }}</p>
                                            </td>
                                            <td
                                                class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                <a href="{{ $movie->trailer_link }}" class="text-blue-500"
                                                    target="_blank">{{ __('Watch Trailer') }}</a>
                                            </td>
                                            <td
                                                class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                <div class="flex">
                                                    <!-- Edit Button -->
                                                    <a href="{{ route('admin.movies.edit', $movie->slug) }}" class="mr-2"
                                                        style="background-color: blue; color: white; padding: 5px 10px; border-radius: 5px;">
                                                        {{ __('Edit') }}
                                                    </a>

                                                    <!-- Delete Button -->
                                                    <form action="{{ route('admin.movies.destroy', $movie->slug) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('{{ __('Are you sure you want to delete this movie?') }}');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            style="background-color: red; color: white; padding: 5px 10px; border-radius: 5px;">
                                                            {{ __('Delete') }}
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
