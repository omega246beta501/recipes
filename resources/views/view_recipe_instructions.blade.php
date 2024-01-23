<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            box-sizing: border-box;
            background-color: #f6f7fb;
            color: #293a4a;
            margin: 0;
        }

        .row::after {
            content: "";
            clear: both;
            display: table;
        }

        [class*="col-"] {
            float: left;
        }

        html {
            font-family: "Lucida Sans", sans-serif;
        }

        .sticky-header {
            padding: 15px;
            position: sticky;
            top: 0;
        }

        .card {
            border-radius: 25px;
            background-color: white;
        }

        .last-card {
            margin-bottom: 140px;
        }

        .card-element {
            /* margin: 15px; */
            padding: 15px;
            overflow-wrap: anywhere;
            display: flex;
            align-items: center;
            min-height: 58px;
            border-color: #f3f3f3;
            border-width: 1px;
            border-bottom-style: solid;
        }

        .ingredient-card-element {
            /* margin: 15px; */
            padding: 0px 15px 0px 15px;
            overflow-wrap: anywhere;
            display: flex;
            align-items: center;
            min-height: 58px;
        }

        /* .card-element >* {
            border-color: #f3f3f3;
            border-width: 1px;
            border-bottom-style: solid;
            margin-bottom: 2px;
        } */

        .card * {
            background-color: transparent;
        }

        .footer {
            position: fixed;
            bottom: 0;
            height: 60px;
            background: rgba(255, 255, 255, 0.95);
            z-index: 10;
            width: 100%;
            /* padding: 0 8px; */
            box-shadow: 0px 0px 12px rgba(79, 79, 106, 0.06);
        }

        .footer-flex {
            display: flex;
            height: 100%;
            backdrop-filter: blur(4px);
        }

        a {
            text-decoration: none;
        }

        .footer-flex a {
            fill: rgb(35 55 72 / 60%);
            color: rgb(35 55 72 / 60%);
            display: flex;
            position: relative;
            flex: 1 0 auto;
            justify-content: center;
            flex-direction: column;
            align-items: center;
            font-size: 12px;
            line-height: 14px;
            font-weight: 400;
        }

        /* For mobile phones: */
        [class*="col-"] {
            width: 100%;
        }

        .image {
            border-radius: 50%;
            height: 48px;
            width: 48px;
        }

        .no-image {
            height: 48px;
            width: 48px;
            border-radius: 50%;
            background-color: #F6F7FA;
            fill: #E4E6EA;
            display: flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 auto;
        }

        .fixed-div {
            position: fixed;
            bottom: 80px;
            right: 20px;
            z-index: 40;
            background-color: transparent;
        }

        .add-button {
            background-color: #ff9838;
            fill: #fff;
            box-shadow: 5px 10px 30px rgba(98, 98, 119, 0.1);
            height: 50px;
            width: 50px;
            position: relative;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 0;
        }

        .plus {
            overflow-clip-margin: content-box;
            overflow: hidden;
            background: inherit;
        }

        .back-arrow {
            fill: #233748;
            border: none;
        }

        @media only screen and (min-width: 200px) {

            /* For tablets: */
            .col-xs-1 {
                width: 8.33%;
            }

            .col-xs-2 {
                width: 16.66%;
            }

            .col-xs-3 {
                width: 25%;
            }

            .col-xs-4 {
                width: 33.33%;
            }

            .col-xs-5 {
                width: 41.66%;
            }

            .col-xs-6 {
                width: 50%;
            }

            .col-xs-7 {
                width: 58.33%;
            }

            .col-xs-8 {
                width: 66.66%;
            }

            .col-xs-9 {
                width: 75%;
            }

            .col-xs-10 {
                width: 83.33%;
            }

            .col-xs-11 {
                width: 91.66%;
            }

            .col-xs-12 {
                width: 100%;
            }
        }

        @media only screen and (min-width: 600px) {

            /* For tablets: */
            .col-s-1 {
                width: 8.33%;
            }

            .col-s-2 {
                width: 16.66%;
            }

            .col-s-3 {
                width: 25%;
            }

            .col-s-4 {
                width: 33.33%;
            }

            .col-s-5 {
                width: 41.66%;
            }

            .col-s-6 {
                width: 50%;
            }

            .col-s-7 {
                width: 58.33%;
            }

            .col-s-8 {
                width: 66.66%;
            }

            .col-s-9 {
                width: 75%;
            }

            .col-s-10 {
                width: 83.33%;
            }

            .col-s-11 {
                width: 91.66%;
            }

            .col-s-12 {
                width: 100%;
            }
        }

        @media only screen and (min-width: 768px) {

            /* For desktop: */
            .col-1 {
                width: 8.33%;
            }

            .col-2 {
                width: 16.66%;
            }

            .col-3 {
                width: 25%;
            }

            .col-4 {
                width: 33.33%;
            }

            .col-5 {
                width: 41.66%;
            }

            .col-6 {
                width: 50%;
            }

            .col-7 {
                width: 58.33%;
            }

            .col-8 {
                width: 66.66%;
            }

            .col-9 {
                width: 75%;
            }

            .col-10 {
                width: 83.33%;
            }

            .col-11 {
                width: 91.66%;
            }

            .col-12 {
                width: 100%;
            }
        }

        .recipe-header {
            justify-content: center;
            flex-direction: column;
            display: flex;
            font-size: 22px;
            font-weight: 500;
        }

        .recipe-header-items {
            align-items: center;
            display: inherit;
        }

        .special-button {
            fill: #233748;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            line-height: 0;
            background: transparent;
            border: none;
            padding: 0;
        }

        .recipe-nav {
            display: flex;
            justify-content: space-evenly;
        }

        .nav-active-element {
            text-decoration: underline;
            text-decoration-thickness: 2px;
            text-underline-offset: 100%;
            color: #ff9939;
        } 
    </style>
</head>

<body>
    <div class="sticky-header">
        <div class="row" style="margin-bottom: 25px;">
            <div class="col-12">
                <div class="row recipe-header">
                    <div class="recipe-header-items">
                        <a href="{{ route('newRecipes') }}" class="col-xs-1">
                            <button class="special-button" type="button">
                                <svg viewBox="0 0 24 24" width="24" height="24">
                                    <path d="M20 12a1 1 0 0 0-1-1H7.83l4.88-4.88a1 1 0 0 0-1.415-1.415l-6.588 6.588a1 1 0 0 0 0 1.414l6.588 6.588a.997.997 0 0 0 1.41-1.41L7.83 13H19a1 1 0 0 0 1-1Z"></path>
                                </svg>
                            </button>
                        </a>
                        <div class="col-xs-10" style="margin-left: 15px;">{{ $recipe->name }}</div>
                        <div class="col-xs-1">
                            <button class="special-button" type="button">
                                <svg viewBox="0 0 24 24" width="24" height="24">
                                    <path d="M7.99 12c0-1.105-.893-2-1.995-2A1.997 1.997 0 0 0 4 12c0 1.105.893 2 1.995 2a1.997 1.997 0 0 0 1.995-2ZM13.975 12c0-1.105-.893-2-1.995-2a1.997 1.997 0 0 0-1.995 2c0 1.105.893 2 1.995 2a1.997 1.997 0 0 0 1.995-2ZM17.965 10c1.102 0 1.995.895 1.995 2s-.893 2-1.995 2a1.997 1.997 0 0 1-1.995-2c0-1.105.893-2 1.995-2Z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 recipe-nav">
                <a href="{{ route('newViewRecipe', ['id' => $recipe->id]) }}">Ingredientes</a>
                <a class="nav-active-element" href="{{ route('viewRecipeInstructions', ['id' => $recipe->id]) }}">Instrucciones</a>
            </div>
        </div>
    </div>
    @php
        $instructions = $recipe->recipeParts->first()->instructions()->orderBy('order', 'asc')->get()
    @endphp
    <div class="row">
        <div class="col-12 card last-card">
            @for ($i = 0; $i < $instructions->count(); $i++)
            <div class="row card-element">
                <div class="col-xs-11">
                    <p style="margin-bottom: 8px; color: #898f9d;";>Step {{ $i + 1 }}</p>
                    <span>{{ $instructions[$i]->description }}</span>
                </div>
            </div>
            @endfor
        </div>
    </div>
</body>

</html>