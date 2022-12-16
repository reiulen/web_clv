<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <link href="{{ mix('assets/css/app.css') }}" rel="stylesheet" async>
        <script src="{{ mix('assets/js/app.js') }}" defer></script>

    </head>
    <body class="antialiased">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <h1>Admin</h1>
                </div>
            </div>
        </div>
    </body>
    <script>
        axios.get('/api/admin')
            .then(response => {
                console.log(response.data);
            })
            .catch(error => {
                console.log(error);
            });
    </script>
</html>
