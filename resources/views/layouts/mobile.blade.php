<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>سفرة - Sofra</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts (Cairo for Arabic) -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Cairo', sans-serif;
        }
        .gradient-btn {
            background: linear-gradient(90deg, #E91E63 0%, #C2185B 100%);
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    @yield('content')
</body>
</html>
