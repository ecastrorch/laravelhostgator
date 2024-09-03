<?php
namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class AdminMovieController extends Controller
{
    // Mostrar todas las películas
    public function index()
    {
        //$movies = Movie::with('genres')->get(); // Obtener todas las películas con sus géneros asociados
        //return view('admin.movies.index', compact('movies'));
        // Realiza una solicitud GET al microservicio para obtener las películas
        $response = Http::get('http://189.218.48.32:8080/movies');

        if ($response->successful()) {
            // Decodifica la respuesta JSON y convierte cada elemento a un objeto
            $movies = collect($response->json())->map(function ($movie) {
                return (object) $movie;
            });
    
            return view('admin.movies.index', compact('movies'));
        } else {
            return redirect()->route('admin.movies.index')->withErrors('Error al obtener los datos del microservicio.');
        }
    }

    // Mostrar el formulario para crear una nueva película
    public function create()
    {
        $allGenres = Genre::all();
        return view('admin.movies.create', compact('allGenres'));
    }

    // Almacenar una nueva película en la base de datos
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'duration' => 'required|integer',
            'trailer_link' => 'required|url',
            'stream_link' => 'required|url',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'genres' => 'required|array'
        ]);

        // Generar el slug a partir del nombre
        $slug = Str::slug($request->name);

        // Subida de imagen con el nombre del slug
        $coverImageName = null;
        if ($request->hasFile('cover_image')) {
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            $coverImageName = $slug . '.' . $extension;
            $request->file('cover_image')->move(public_path('images/covers'), $coverImageName);
        }
        // Crear la película
        $movie = Movie::create([
            'name' => $request->name,
            'description' => $request->description,
            'duration' => $request->duration,
            'trailer_link' => $request->trailer_link,
            'stream_link' => $request->stream_link,
            'cover_image' => $coverImageName,
            'slug' => $slug, // Usar el slug generado
        ]);

        // Asociar géneros a la película
        $movie->genres()->attach($request->genres);

        return redirect()->route('admin.movies.index')->with('success', 'Película creada exitosamente.');
    }

    // Mostrar una película específica
    public function show(Movie $movie)
    {
        return view('admin.movies.show', compact('movie'));
    }

    // Mostrar el formulario para editar una película existente
    public function edit(Movie $movie)
    {
        $allGenres = Genre::all();
        return view('admin.movies.edit', compact('movie', 'allGenres'));
    }

    // Actualizar una película existente en la base de datos
    public function update(Request $request, Movie $movie)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'duration' => 'required|integer',
            'trailer_link' => 'required|url',
            'stream_link' => 'required|url',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'genres' => 'required|array'
        ]);

        // Generar el nuevo slug a partir del nombre
        $slug = Str::slug($request->name);

        // Verificar si se ha subido una nueva imagen
        $coverImageName = $movie->cover_image;

        if ($request->hasFile('cover_image')) {
            if ($movie->cover_image && file_exists(public_path('images/covers/' . $movie->cover_image))) {
                unlink(public_path('images/covers/' . $movie->cover_image));
            }

            $extension = $request->file('cover_image')->getClientOriginalExtension();
            $coverImageName = $slug . '.' . $extension;
            $request->file('cover_image')->move(public_path('images/covers'), $coverImageName);
        } else {
            if ($movie->cover_image && file_exists(public_path('images/covers/' . $movie->cover_image))) {
                $extension = pathinfo($movie->cover_image, PATHINFO_EXTENSION);
                $newCoverImageName = $slug . '.' . $extension;
                rename(public_path('images/covers/' . $movie->cover_image), public_path('images/covers/' . $newCoverImageName));
                $coverImageName = $newCoverImageName;
            }
        }

        // Actualizar la película
        $movie->update([
            'name' => $request->name,
            'description' => $request->description,
            'duration' => $request->duration,
            'trailer_link' => $request->trailer_link,
            'stream_link' => $request->stream_link,
            'cover_image' => $coverImageName,
            'slug' => $slug,
        ]);

        // Sincronizar géneros con la película
        $movie->genres()->sync($request->genres);

        return redirect()->route('admin.movies.index')->with('success', 'Película actualizada exitosamente.');
    }

    // Eliminar una película de la base de datos
    public function destroy(Movie $movie)
    {
        // Eliminar la imagen asociada
        $imagePath = public_path('images/covers/' . $movie->cover_image);

        if ($movie->cover_image && file_exists($imagePath)) {
            unlink($imagePath);
        }

        $movie->delete();
        return redirect()->route('admin.movies.index')->with('success', 'Película eliminada exitosamente.');
    }
}
