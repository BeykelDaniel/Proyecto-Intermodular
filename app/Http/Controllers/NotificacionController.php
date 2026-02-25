<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificacionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Solicitudes de amistad recibidas
        $notificaciones = $user->friendRequestsReceived()->select('users.id', 'users.name', 'users.perfil_foto')->get();
        
        return response()->json([
            'count' => $notificaciones->count(),
            'solicitudes' => $notificaciones
        ]);
    }
}
