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

        .header {
            padding: 15px;
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
    </style>
</head>

<body>
    <div class="row">
        <div class="col-12 header">
            <h2>Recetas</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-12 card last-card">
            @foreach ($recipes as $recipe)
            <div class="row card-element">
                <div class="col-xs-2" style="text-align: center;">
                    <div class="no-image">
                        <svg viewBox="0 0 24 24" width="24" height="24">
                            <path d="m16.736 9.252-3.982-5.876A.907.907 0 0 0 12 3a.892.892 0 0 0-.755.385L7.264 9.252H2.909c-.5 0-.909.403-.909.896 0 .08.01.16.036.241l2.31 8.303C4.554 19.445 5.254 20 6.09 20h11.818c.837 0 1.537-.555 1.755-1.308l2.309-8.303.027-.241a.905.905 0 0 0-.91-.896h-4.354Zm-7.463 0L12 5.31l2.727 3.94H9.273ZM12 16.417c-1 0-1.818-.806-1.818-1.791 0-.985.818-1.791 1.818-1.791s1.818.806 1.818 1.79c0 .986-.818 1.792-1.818 1.792Z"></path>
                        </svg>
                    </div>
                    <!-- <img class="image" src="http://192.168.0.177/storage/img_chania.jpg"> -->
                </div>
                <div class="col-xs-7" style="padding-left: 5px;" href="{{ route('newRecipes', ['tenant' => tenant()]) }}">
                    <a href="{{ route('newViewRecipe', ['tenant' => tenant(), 'id' => $recipe->id]) }}">{{ $recipe->name }}</a>
                </div>
                <div class="col-xs-3">
                    <span>{{ $recipe->last_used_at }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="footer">
        <div class="footer-flex">
            <a href="/feed" id="home-link">
                <svg viewBox="0 0 24 24" width="24" height="24" data-testid="home">
                    <path fill-rule="evenodd" d="M8 15.5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2V20h3V8.177l-7-3.89-7 3.89V20h3v-4.5ZM3 7l9-5 9 5v15h-7v-6.5h-4V22H3V7Z" clip-rule="evenodd"></path>
                </svg>
                Home
            </a>
            <a href="/" id="search-link">
                <svg viewBox="0 0 24 24" width="24" height="24" data-testid="search">
                    <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5Zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14Z"></path>
                </svg>
                Recetas
            </a>
            <a href="/recipe-box" id="recipes-link">
                <svg viewBox="0 0 24 24" width="24" height="24" data-testid="bookmark">
                    <path d="M17 3H7c-1.1 0-2 .9-2 2v16l7-3 7 3V5c0-1.1-.9-2-2-2Zm0 15-5-2.18L7 18V6c0-.55.45-1 1-1h8c.55 0 1 .45 1 1v12Z"></path>
                </svg>
                Categorías
            </a>
            <a href="/meal-plan" id="meal-planner-link">
                <svg viewBox="0 0 24 24" width="24" height="24" data-testid="calendar">
                    <path d="M18.454 5H17V3.773C17 3.348 16.494 3 16 3c-.493 0-1 .348-1 .773V5H9V3.773C9 3.348 8.5 3 8 3s-1 .348-1 .773V5H5.545A1.55 1.55 0 0 0 4 6.545v11.91C4 19.305 4.695 20 5.545 20h12.91A1.55 1.55 0 0 0 20 18.454V6.545A1.55 1.55 0 0 0 18.454 5Zm-1.227 13H6.773A.775.775 0 0 1 6 17.227V8h12v9.227a.775.775 0 0 1-.773.773Z"></path>
                </svg>
                Menu
            </a>
            <a href="/shopping-list" id="sl-link">
                <svg viewBox="0 0 24 24" width="24" height="24" data-testid="lists">
                    <path fill-rule="evenodd" d="M18.5 4a.5.5 0 0 1 .5.5v15a.5.5 0 0 1-.5.5H5V4.5a.5.5 0 0 1 .5-.5h13ZM3 4a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4Zm7.777 3C10.348 7 10 7.448 10 8s.348 1 .777 1h5.445c.43 0 .778-.448.778-1s-.349-1-.778-1h-5.445ZM10 12c0-.552.348-1 .777-1h5.445c.43 0 .778.448.778 1s-.349 1-.778 1h-5.445c-.429 0-.777-.448-.777-1Zm0 4c0-.552.348-1 .777-1h5.445c.43 0 .778.448.778 1s-.349 1-.778 1h-5.445c-.429 0-.777-.448-.777-1Zm-1 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0Zm-1-3a1 1 0 1 0 0-2 1 1 0 0 0 0 2Zm1-5a1 1 0 1 1-2 0 1 1 0 0 1 2 0Z" clip-rule="evenodd"></path>
                </svg>
                Lista
            </a>
        </div>
    </div>
    <div class="fixed-div">
        <div class="add-button">
            <svg class="plus" viewBox="0 0 24 24" width="24" height="24">
                <path fill-rule="evenodd" d="M11 6a1 1 0 1 1 2 0v12a1 1 0 1 1-2 0V6Z" clip-rule="evenodd"></path>
                <path fill-rule="evenodd" d="M5 12a1 1 0 0 1 1-1h12a1 1 0 1 1 0 2H6a1 1 0 0 1-1-1Z" clip-rule="evenodd"></path>
            </svg>
        </div>
    </div>

</body>

</html>