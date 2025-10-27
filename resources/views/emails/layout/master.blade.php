<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> @yield('title') </title>
    <style>
        @media only screen and (max-width: 640px) {
            .container {
                width: 100% !important;
            }

            .mobile-full {
                width: 100% !important;
                display: block !important;
            }

            .mobile-padding {
                padding: 15px !important;
            }

            .mobile-stack {
                display: block !important;
                width: 100% !important;
                padding: 10px 0 !important;
            }

            .button-container {
                text-align: center !important;
            }

            .button-mobile {
                display: block !important;
                width: 100% !important;
                box-sizing: border-box !important;
                margin: 10px 0 !important;
            }
        }
    </style>
</head>

@yield('content')

</html>
