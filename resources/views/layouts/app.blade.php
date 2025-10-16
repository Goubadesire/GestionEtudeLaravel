<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles de base pour debug -->
    <style>
        .sidebar-desktop {
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            height: 100vh;
            background: #1f2937;
            color: white;
            padding: 20px;
            z-index: 30;
        }
        
        .main-content {
            margin-left: 250px;
            min-height: 100vh;
            background: #f9fafb;
        }
        
        @media (max-width: 768px) {
            .sidebar-desktop {
                display: none;
            }
            .main-content {
                margin-left: 0;
            }
        }
        
        .sidebar-mobile {
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            height: 100vh;
            background: #1f2937;
            color: white;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            z-index: 50;
        }
        
        .sidebar-mobile.open {
            transform: translateX(0);
        }
        
        .overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 40;
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <!-- Sidebar Desktop -->
    <aside class="sidebar-desktop" style="display: block !important;">
        <h2 class="text-2xl font-semibold mb-6">Menu</h2>
        <nav>
            <ul class="space-y-2">
                <li><a href="{{ route('dashboard.index') }}" class="block py-2 px-3 rounded hover:bg-gray-700">Tableau de bord</a></li>
                <li><a href="{{ route('matieres.index') }}" class="block py-2 px-3 rounded hover:bg-gray-700">Matières</a></li>
                <li><a href="{{ route('notes.index') }}" class="block py-2 px-3 rounded hover:bg-gray-700">Notes</a></li>
                <li><a href="{{ route('planning.index') }}" class="block py-2 px-3 rounded hover:bg-gray-700">Emploi du temps</a></li>
                <li><a href="{{ route('semestres.index') }}" class="block py-2 px-3 rounded hover:bg-gray-700">Semestre</a></li>
            </ul>
        </nav>
    </aside>

    <!-- Contenu Principal -->
    <div class="main-content">
        <header style="background: white; padding: 1rem; border-bottom: 1px solid #e5e7eb;">
            <div style="display: flex; justify-content: space-between;  align-items: center;">
                <h1 style="font-size: 1.25rem; font-weight: 600; color: #374151;">
                    @isset($header) {{ $header }} @else Tableau de bord @endisset
                </h1>
                
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <span style="color: #6b7280;">{{ Auth::user()->name }}</span>
                    <!-- Menu utilisateur -->
                </div>
            </div>
        </header>

        <main style="padding: 1.5rem;">
            {{ $slot }}
        </main>
    </div>

    <!-- Script simple pour la sidebar mobile -->
    <script>
        let sidebarOpen = false;
        
        function toggleSidebar() {
            sidebarOpen = !sidebarOpen;
            const sidebar = document.getElementById('sidebarMobile');
            const overlay = document.getElementById('overlay');
            
            if (sidebarOpen) {
                sidebar.classList.add('open');
                overlay.style.display = 'block';
            } else {
                sidebar.classList.remove('open');
                overlay.style.display = 'none';
            }
        }
        
        // Créer la sidebar mobile dynamiquement
        document.addEventListener('DOMContentLoaded', function() {
            // Créer l'overlay
            const overlay = document.createElement('div');
            overlay.id = 'overlay';
            overlay.className = 'overlay';
            overlay.style.display = 'none';
            overlay.onclick = toggleSidebar;
            document.body.appendChild(overlay);
            
            // Créer la sidebar mobile
            const sidebarMobile = document.createElement('aside');
            sidebarMobile.id = 'sidebarMobile';
            sidebarMobile.className = 'sidebar-mobile';
            sidebarMobile.innerHTML = `
                <div style="padding: 1.25rem; border-bottom: 1px solid #374151; display: flex; justify-content: space-between; align-items: center;">
                    <h2 style="font-size: 1.5rem; font-weight: 600;">Menu</h2>
                    <button onclick="toggleSidebar()" style="font-size: 1.5rem; padding: 0.5rem; border-radius: 0.25rem; background: transparent; color: white; border: none; cursor: pointer;">×</button>
                </div>
                <nav style="padding: 1rem;">
                    <ul style="display: flex; flex-direction: column; gap: 0.5rem;">
                        <li><a href="{{ route('dashboard.index') }}" style="display: block; padding: 0.5rem 0.75rem; border-radius: 0.375rem; color: white; text-decoration: none; background: transparent;">Tableau de bord</a></li>
                        <li><a href="{{ route('matieres.index') }}" style="display: block; padding: 0.5rem 0.75rem; border-radius: 0.375rem; color: white; text-decoration: none; background: transparent;">Matières</a></li>
                        <li><a href="{{ route('notes.index') }}" style="display: block; padding: 0.5rem 0.75rem; border-radius: 0.375rem; color: white; text-decoration: none; background: transparent;">Notes</a></li>
                        <li><a href="{{ route('planning.index') }}" style="display: block; padding: 0.5rem 0.75rem; border-radius: 0.375rem; color: white; text-decoration: none; background: transparent;">Emploi du temps</a></li>
                        <li><a href="{{ route('semestres.index') }}" style="display: block; padding: 0.5rem 0.75rem; border-radius: 0.375rem; color: white; text-decoration: none; background: transparent;">Semestre</a></li>
                    </ul>
                </nav>
            `;
            document.body.appendChild(sidebarMobile);
            
            // Créer le bouton hamburger mobile
            const header = document.querySelector('header');
            const hamburger = document.createElement('button');
            hamburger.innerHTML = '☰';
            hamburger.onclick = toggleSidebar;
            hamburger.style.cssText = `
                display: none;
                padding: 0.5rem;
                border-radius: 0.375rem;
                color: #6b7280;
                background: transparent;
                border: none;
                cursor: pointer;
                font-size: 1.5rem;
            `;
            
            // Afficher seulement sur mobile
            function checkScreenSize() {
                if (window.innerWidth < 768) {
                    hamburger.style.display = 'block';
                    document.querySelector('.sidebar-desktop').style.display = 'none';
                    document.querySelector('.main-content').style.marginLeft = '0';
                } else {
                    hamburger.style.display = 'none';
                    document.querySelector('.sidebar-desktop').style.display = 'block';
                    document.querySelector('.main-content').style.marginLeft = '250px';
                }
            }
            
            header.querySelector('div').insertBefore(hamburger, header.querySelector('div').firstChild);
            checkScreenSize();
            window.addEventListener('resize', checkScreenSize);
        });
    </script>
</body>
</html>