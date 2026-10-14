@props(['title' => null])

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="description" content="Calmify – eine ruhige Begleitung für schwere Momente: Atem-Taktgeber, 5-4-3-2-1-Übung und SOS-Kontakte.">
    <meta name="theme-color" content="#2C3A33">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title && $title !== 'Calmify' ? $title.' · Calmify' : 'Calmify' }}</title>

    <link rel="icon" href="{{ asset('icon.svg') }}" type="image/svg+xml">
    <link rel="manifest" href="{{ asset('manifest.webmanifest') }}">

    {{-- Apply the stored theme before the first paint to avoid a colour flash. --}}
    <script nonce="{{ Vite::cspNonce() }}">
        try {
            var calmSettings = JSON.parse(localStorage.getItem('calmify.settings') || '{}') || {};
            if (calmSettings.theme === 'nachtblau') document.documentElement.dataset.theme = 'nachtblau';
            if (calmSettings.motion === 'reduziert') document.documentElement.dataset.motion = 'reduced';
        } catch (e) {}
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-calm-outer font-sans antialiased">
    <div class="flex min-h-dvh justify-center bg-calm-outer">
        <main class="relative flex min-h-dvh w-full max-w-[430px] flex-col overflow-hidden bg-calm-bg text-calm-text">
            {{ $slot }}
        </main>
    </div>

    @livewireScriptConfig
</body>
</html>
