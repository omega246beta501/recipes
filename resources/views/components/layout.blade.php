<!doctype html>
<html lang="en">
@php
use App\Data\Routes\MenuRoutes;
use App\Data\Routes\RecipeRoutes;
use App\Data\Routes\CategoryRoutes;
@endphp

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Resetukis' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@animxyz/core">
    <style>
        .select2-selection__choice {
            background-color: #fd1dc2;
        }

        a {
            color: white;
            text-decoration: auto;
        }

        a:hover {
            color: #ffc107 !important;
            cursor: pointer;
            text-decoration: auto;
        }

        header {
            margin-bottom: 1%;
        }

        .close {
            float: right;
            font-size: 1.5rem;
            font-weight: 700;
            line-height: 1;
            color: #000;
            text-shadow: 0 1px 0 #fff;
            opacity: .5;
        }

        button.close {
            padding: 0;
            background-color: transparent;
            border: 0;
            -webkit-appearance: none;
        }

        .row {
            margin-bottom: 1%;
        }

        .ui-autocomplete {
            z-index: 2147483647;
        }

        .card-grid {
            --xyz-stagger: 0.2s;
            --xyz-translate-y: -350%;
            --xyz-scale-x: 0;
            --xyz-ease: cubic-bezier(0.5, -1.5, 0.5, 1.5);
            --xyz-duration: 0.7s;
        }
    </style>
</head>

<body>
    <header class="p-3 bg-dark text-white">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                    <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap">
                        <use xlink:href="#bootstrap"></use>
                    </svg>
                </a>

                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="{{ MenuRoutes::MENU }}" class="nav-link px-2 text-warning">Men??</a></li>
                    <li><a href="{{ CategoryRoutes::CATEGORIES }}" class="nav-link px-2 text-white">Categor??as</a></li>
                    <li><a href="{{ RecipeRoutes::RECIPES }}" class="nav-link px-2 text-white">Recetas</a></li>
                    <li><a href="#" class="nav-link px-2 text-white">FAQs</a></li>
                    <li><a href="#" class="nav-link px-2 text-white">About</a></li>
                </ul>


                <!-- <div class="text-end">
                    <button type="button" class="btn btn-outline-light me-2">Login</button>
                    <button type="button" class="btn btn-warning">Sign-up</button>
                </div> -->
            </div>
        </div>
    </header>
    {{ $slot }}
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/gh/xcash/bootstrap-autocomplete@v2.3.7/dist/latest/bootstrap-autocomplete.min.js"></script>

</html>