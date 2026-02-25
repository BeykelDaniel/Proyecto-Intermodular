<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage; // Importante para borrar archivos

class AlbumController extends Controller
{
    public function index()
    {
        // Obtenemos los archivos de la tabla 'media'
        $items = DB::table('media')->orderBy('created_at', 'desc')->get();

        return view('pagina.album', compact('items'));
    }

    public function subir(Request $request)
    {
        $request->validate([
            'archivo' => 'required|file|mimes:jpg,jpeg,png,gif,mp4,mov,avi|max:51200',
            'actividad_id' => 'nullable|exists:actividades,id'
        ]);

        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $tipo = str_contains($file->getMimeType(), 'video') ? 'video' : 'foto';

            // Guarda en storage/app/public/album
            $path = $file->store('album', 'public');

            DB::table('media')->insert([
                'url' => 'storage/' . $path,
                'tipo' => $tipo,
                'actividad_id' => $request->actividad_id,
                'user_id' => Auth::id(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 400);
    }

    public function showActivityAlbum($id)
    {
        $actividad = \App\Models\Actividades::findOrFail($id);
        $items = DB::table('media')->where('actividad_id', $id)->orderBy('created_at', 'desc')->get();
        return view('pagina.album_actividad', compact('actividad', 'items'));
    }

    public function separar()
    {
        $fotos = DB::table('media')->where('tipo', 'foto')->get();
        $videos = DB::table('media')->where('tipo', 'video')->get();
        return view('album.index', compact('fotos', 'videos'));
    }

    // Método para la tabla de administración
    public function indexAdmin()
    {
        // Usamos paginate para que funcione el $fotos->links() de tu vista
        $fotos = DB::table('media')->orderBy('created_at', 'desc')->paginate(10);
        return view('album.index', compact('fotos'));
    }

    public function destroy($id)
    {
        // Buscamos el registro en la tabla 'media'
        $archivo = DB::table('media')->where('id', $id)->first();

        if ($archivo) {
            // 1. Borrar archivo físico usando el Facade Storage
            // Convertimos 'storage/album/xxx.jpg' a 'album/xxx.jpg'
            $pathPublic = str_replace('storage/', '', $archivo->url);

            if (Storage::disk('public')->exists($pathPublic)) {
                Storage::disk('public')->delete($pathPublic);
            }

            // 2. Borrar registro de la base de datos
            DB::table('media')->where('id', $id)->delete();

            return redirect()->back()->with('success', 'Archivo eliminado permanentemente.');
        }

        return redirect()->back()->with('error', 'No se encontró el archivo.');
    }
}