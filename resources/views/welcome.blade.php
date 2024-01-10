<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <!-- 引入字型 -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <!-- 引入 Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- 風格設定 -->
    <style>
        /* 可能的自訂樣式 */
        body {
            font-family: 'figtree', sans-serif;
            /* 添加其他樣式 */
        }
        /* ...（其他自訂樣式）... */
    </style>
</head>
<body class="antialiased">
    <div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center bg-light">
        <!-- 登入和註冊連結 -->
        @if (Route::has('login'))
            <div class="position-fixed top-0 end-0 p-4 z-index-100">
                @auth
                    <a href="{{ url('/home') }}" class="btn btn-outline-primary">首頁</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary">登入</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-outline-primary ms-2">註冊</a>
                    @endif
                @endauth
            </div>
        @endif
        <div class="max-w-7xl mx-auto p-4">
            <div class="text-center">
                <!-- Laravel 圖示 -->
                <svg viewBox="0 0 62 65" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-16 w-auto bg-gray-100 dark:bg-gray-900">
                    <!-- ...（SVG路徑）... -->
                </svg>
            </div>
        </div>
    </div>
</body>
</html>
