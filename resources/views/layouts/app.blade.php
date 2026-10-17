<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - SILABKOM Unila</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col font-sans">

    @include('layouts.template.navbar')

    <div class="flex flex-1">
        @include('layouts.template.sidebar')

        <main class="flex-1 p-6 md:p-8 max-w-7xl mx-auto w-full">
            {{-- Alert Sukses --}}
            @if(session('success'))
                <div class="mb-6 flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl shadow-sm text-sm">
                    <i data-lucide="check-circle" class="w-5 h-5 text-emerald-600 flex-shrink-0"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 flex items-center gap-3 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl shadow-sm text-sm">
                    <i data-lucide="alert-triangle" class="w-5 h-5 text-rose-600 flex-shrink-0"></i>
                    <span>Periksa kembali isian formulir Anda.</span>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @include('layouts.template.footer')

    <script>
        lucide.createIcons();
    </script>
</body>
</html>