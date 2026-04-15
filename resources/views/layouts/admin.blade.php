<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <title>Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        
        @include('includes.style')

        @yield('page-style')
    </head>
    <body class="min-h-screen bg-gray-100">
        <div class="flex h-screen">
            {{-- Sidebar --}}
            <aside id="sidebar" class="bg-white w-[200px] hidden shadow-sm md:block">
                <div class="p-4 text-xl font-semibold">FlowForge</div>
                <nav class="px-2 py-4 space-y-2 text-sm">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center p-2 px-3 text-gray-700 rounded-md hover:bg-gray-50 @yield('sidebar-dashboard')">
                        <span>Monitoring</span>
                    </a>
                    <a href="{{ route('admin.workflow') }}" class="flex items-center p-2 px-3 text-gray-700 rounded-md hover:bg-gray-50 @yield('sidebar-workflow')">
                        <span>Workflow</span>
                    </a>
                    <a href="{{ route('admin.history') }}" class="flex items-center p-2 px-3 text-gray-700 rounded-md hover:bg-gray-50 @yield('sidebar-history')">
                        <span>Riwayat</span>
                    </a>
                    <a href="{{ route('admin.users') }}" class="flex items-center p-2 px-3 text-gray-700 rounded-md hover:bg-gray-50 @yield('sidebar-users')">
                        <span>Pengguna</span>
                    </a>
                </nav>
            </aside>

            {{-- Main --}}
            <div class="flex-1 flex flex-col">
                {{-- Navbar --}}
                <div class="bg-white px-6 py-3">
                    <center>
                        <div class="max-w-6xl">
                            <header class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <button id="sidebarToggle" class="md:hidden p-2 aspect-square rounded bg-gray-100 hover:bg-gray-200" aria-label="Toggle sidebar">☰</button>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <div class="hidden sm:block text-sm text-gray-600">Admin</div>
                                    <a href="/" class="px-3 py-1 bg-red-50 text-red-600 rounded-md hover:bg-red-100">Keluar</a>
                                </div>
                            </header>
                        </div>
                    </center>
                </div>

                {{-- Content --}}
                <main class="p-6 overflow-auto">
                    <center>
                        <div class="max-w-6xl text-start">
                            @yield('content')
                        </div>
                    </center>
                </main>
            </div>
        </div>

        @include('includes.scripts')
        <script>
            // Sidebar toogle
            (function(){
                var btn = document.getElementById('sidebarToggle');
                var sidebar = document.getElementById('sidebar');
                if (!btn || !sidebar) return;
                btn.addEventListener('click', function(){
                    sidebar.classList.toggle('hidden');
                });
            })();
        </script>
        @yield('page-scripts')
    </body>
</html>
