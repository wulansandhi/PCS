<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,
initial-scale=1.0">
    @vite('resources/sass/app.scss')
</head>
<body>
    <div class="d-flex">
        <a href="{{ route('data.edit') }}" class="btn btn-warning me-2"><i class="bi bi-pencil-square"></i></a>
        <a href="{{ route('detail/') }}" class="btn btn-primary me-2"> <i class="bi bi-qr-code"></i></a>
        <a href="{{ route('delete/') }}" class="btn btn-danger me-2"><i class="bi bi-trash-fill"></i></a>
    </div>
    @vite('resources/js/app.js')
</body>
</html>
