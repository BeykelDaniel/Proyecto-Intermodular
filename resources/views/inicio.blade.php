@extends('layout')
@section('title', 'Inicio')
@section('contenido')
<div style="background-color:   #f0eddd  ; min-height: 100vh; padding: 15px; font-family: sans-serif; display: flex; flex-direction: column; align-items: center; gap: 15px;">
    
    <!-- SECCIÓN SUPERIOR: Video, Banner y Lista (Altura controlada) -->
    <div style="display: flex; gap: 15px; width: 100%; max-width: 1100px; height: 500px; align-items: stretch;">
        
        <!-- COLUMNA IZQUIERDA: Video + Banner -->
        <div style="flex: 3; display: flex; flex-direction: column; gap: 15px;">
            <div style="display: flex; gap: 15px; background: white; border-radius: 12px; padding: 15px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); flex-shrink: 0;">
                <div style="width: 220px;">
                    <video id="mainVideo" src="{{ asset('vid.mp4') }}" autoplay muted loop controls style="width: 100%; border-radius: 8px; background: #000;"></video>
                </div>
                <div style="flex: 1; overflow: hidden;"> 
                    <h4 style="margin: 0 0 8px 0; color: #333; font-size: 1.2em;">Transcripción</h4>
                    <p style="margin: 0; color: #555; font-size: 0.85em; line-height: 1.3;">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Placeat perferendis quia obcaecati tempora odit quam cum porro libero, vitae fugit inventore repellat laboriosam repudiandae maiores.
                    </p>
                </div>
            </div>

            <!-- Banner que rellena el espacio -->
            <div style="flex-grow: 1; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05); background: white;">
                <img src="{{ asset('banner.png') }}" alt="banner" style="width: 100%; height: auto; object-fit: contain; display: block;">
            </div>
        </div>

        <!-- COLUMNA DERECHA: Lista de Amigos con Scroll -->
        <div style="flex: 0 0 240px; background: white; border-radius: 12px; padding: 15px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); display: flex; flex-direction: column;"> 
            <h4 style="margin: 0 0 12px 0; color: #81ac9c  ; font-size: 1.2em; border-bottom: 1px solid #eee; padding-bottom: 5px;">Añadir Amigos</h4>
            <div style="flex: 1; overflow-y: auto; scrollbar-width: thin; padding-right: 5px;">
                <ul style="padding: 0; margin: 0; list-style: none; color: #4b3085; font-size: 0.9em;">
                    @php 
                        $usuarios = ['Pedro Hoyos', 'Maria Hernandez', 'Andrés Rodriguez', 'Pedro Hoyos', 'Maria Hernandez', 'Andrés Rodriguez', 'Pedro Hoyos', 'Maria Hernandez', 'Andrés Rodriguez', 'Pedro Hoyos', 'Maria Hernandez', 'Andrés Rodriguez'];
                    @endphp
                    @foreach($usuarios as $usuario)
                        <li style="margin-bottom: 10px; display: flex; align-items: center; gap: 8px;">
                            <span style="font-size: 1.1em;">👤</span> {{ $usuario }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <!-- SECCIÓN INFERIOR: Actividades (Ocupa todo el ancho disponible) -->
    <div style="width: 100%; max-width: 1100px; background: white; border-radius: 12px; padding: 15px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <h4 style="margin: 0 0 12px 0; color: #333; font-size: 1.2em; border-bottom: 1px solid #eee; padding-bottom: 5px;">Actividades</h4>
        <p style="color: #666; font-size: 0.9em;">Aquí puedes listar las actividades recientes...</p>
    </div>
    <!-- SECCIÓN INFERIOR: Actividades (Ocupa todo el ancho disponible) -->
    <div style="width: 100%; max-width: 1100px; background: white; border-radius: 12px; padding: 15px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <h4 style="margin: 0 0 12px 0; color: #333; font-size: 1.2em; border-bottom: 1px solid #eee; padding-bottom: 5px;">Albumes</h4>
        <p style="color: #666; font-size: 0.9em;">Albumes...</p>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const video = document.getElementById('mainVideo');
        video.play().catch(() => {
            video.muted = true;
            video.play();
        });
    });
</script>
@endsection
