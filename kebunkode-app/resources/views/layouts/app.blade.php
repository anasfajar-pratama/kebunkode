<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @include('partials.favicon')
    @include('partials.seo', ['seo' => $seo ?? null])
    @yield('styles')
</head>
<body>
    @yield('content')
    @yield('scripts')
</body>
</html>
