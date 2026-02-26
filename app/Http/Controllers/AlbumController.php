<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Auth;

use App\Models\Actividades;



class AlbumController extends Controller

{

    /**

     * Muestra la lista de álbumes de las actividades donde el usuario está inscrito

     */

    public function index()

    {

        // Obtenemos las actividades del usuario cargando la relación media para contar archivos

        $actividades = Auth::user()->actividades()->withCount('media')->get();

        return view('pagina.album', compact('actividades'));

    }



    /**

     * Muestra el contenido del álbum de una actividad específica

     */

    public function showActivityAlbum($id)

    {

        $user = Auth::user();



        // 1. Seguridad: Verificar si el usuario está inscrito

        if (!$user->actividades->contains($id)) {

            return redirect()->route('pagina.album')->with('error', 'No estás inscrito en esta actividad.');

        }



        $actividad = Actividades::findOrFail($id);

        

        // 2. Obtener los archivos multimedia de la tabla 'media'

        $items = DB::table('media')

            ->where('actividad_id', $id)

            ->orderBy('created_at', 'desc')

            ->get();



        return view('pagina.album_actividad', compact('actividad', 'items'));

    }



    /**

     * Sube un archivo mediante AJAX y devuelve el objeto creado

     */

    public function subir(Request $request)

    {

        try {

            $request->validate([

                'archivo' => 'required|file|mimes:jpg,jpeg,png,gif,mp4,mov,avi,webp|max:51200',

                'actividad_id' => 'required|exists:actividades,id'

            ]);



            if ($request->hasFile('archivo')) {

                $archivo = $request->file('archivo');

                $extension = strtolower($archivo->getClientOriginalExtension());

                

                // Clasificar tipo

                $tipo = in_array($extension, ['mp4', 'mov', 'avi']) ? 'video' : 'foto';

                

                // Guardar físicamente en storage/app/public/album

                $path = $archivo->store('album', 'public');



                // Insertar y obtener el ID para devolver el objeto al JS

                $nuevoId = DB::table('media')->insertGetId([

                    'url' => 'storage/' . $path,

                    'tipo' => $tipo,

                    'actividad_id' => $request->actividad_id,

                    'user_id' => Auth::id(),

                    'created_at' => now(),

                    'updated_at' => now()

                ]);



                // Recuperamos el registro recién creado

                $item = DB::table('media')->where('id', $nuevoId)->first();



                // DEVOLVEMOS JSON (Esto permite que aparezca sin refrescar)

                return response()->json([

                    'success' => true,

                    'message' => 'Archivo subido correctamente',

                    'item' => $item 

                ]);

            }

        } catch (\Exception $e) {

            return response()->json([

                'success' => false,

                'message' => 'Error: ' . $e->getMessage()

            ], 422);

        }



        return response()->json(['success' => false, 'message' => 'Error inesperado'], 400);

    }



    /**

     * Elimina un archivo (físicamente y de la BD)

     */

    public function destroy($id)
{
    $archivo = DB::table('media')->where('id', $id)->first();

    if (!$archivo) {
        return response()->json([
            'success' => false,
            'message' => 'El archivo no existe.'
        ], 404);
    }

    // Solo el dueño o el admin
    if ($archivo->user_id != Auth::id() && Auth::user()->email != 'cabrerajosedaniel89@gmail.com') {
        return response()->json([
            'success' => false,
            'message' => 'No tienes permiso para borrar esto.'
        ], 403);
    }

    // Borrar archivo físico
    $pathReal = str_replace('storage/', '', $archivo->url);
    if (Storage::disk('public')->exists($pathReal)) {
        Storage::disk('public')->delete($pathReal);
    }

    // Borrar de la BD
    DB::table('media')->where('id', $id)->delete();

    return response()->json([
        'success' => true,
        'message' => 'Archivo eliminado correctamente.'
    ]);
}

}