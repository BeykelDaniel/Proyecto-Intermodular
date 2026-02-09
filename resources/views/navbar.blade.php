<nav class="navbar navbar-expand-md navbar-dark" style="background-color: rgb(235, 208, 142) !important; padding: 10px 0;">
    <div class="container-fluid">
        <!-- Logo con recorte circular perfecto -->
        <a class="navbar-brand" href="{{ route('inicio') }}" style="padding: 0; margin-right: 20px;">
            <img src="{{ asset('logo.png') }}" alt="Tenderete Logo"
                style="height: 100px; 
                       width: 100px; 
                       border-radius: 100%; 
                       object-fit: cover; 
                       
                       display: block;
                       /* Esto corta cualquier rastro de blanco en las esquinas */
                       clip-path: circle(50% at center);">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false" style="color: #32424D !important;">
                        Mis Actividades
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" tabindex="-1" style="color: #32424D !important;">Comunidades</a>
                </li>
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
                <li class="nav-item">
                    <a class="nav-link" href="#" tabindex="-1" style="color: #32424D !important;">Nosotros</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" tabindex="-1" style="color: #32424D !important;">Mis Amigos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" tabindex="-1" style="color: #32424D !important;">Login</a>
                </li>
            </ul>
        </div>
    </div>
</nav>