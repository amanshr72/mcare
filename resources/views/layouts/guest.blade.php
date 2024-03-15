<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    <title>Mcare</title>
</head>

<body class="font-sans text-gray-900 antialiased">
    <?php $cur_route = Route::current()->getName(); ?>
    <main>
        {{ $slot }}
    </main>
</body>

</html>
