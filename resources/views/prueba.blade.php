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

        .card-element {
            margin: 15px;
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
            background-color: #0099cc;
            color: #ffffff;
            text-align: center;
            font-size: 12px;
            padding: 15px;
        }

        /* For mobile phones: */
        [class*="col-"] {
            width: 100%;
        }

        img {
            max-width: 100%;
            border-radius: 50%;
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
        <div class="col-3 header">
            <h1>Recetas</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-12 card">
            @foreach ($recipes as $recipe)
            <div class="row card-element">
                <div class="col-xs-2" style="padding-right: 5px;">
                    <img src="http://64.227.67.35/storage/img_chania.jpg" width="54" height="54">
                </div>
                <div class="col-xs-9">
                    <span>{{ $recipe->name }}</span>
                </div>
                <div class="col-xs-3">
                    <span>{{ $recipe->last_used_at }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="footer">
                <p>Resize the browser window to see how the content respond to the resizing.</p>
            </div>
        </div>
    </div>

</body>

</html>