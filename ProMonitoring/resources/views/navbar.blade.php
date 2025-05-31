<nav class="navbar">
    <div class="nav-container">
        <a href="{{ route('dashboard') }}" class="logo">🌊 ProMonitor</a>

        <ul class="nav-links">
            <li>
                <a href="{{ route('dashboard') }}" 
                   class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                   Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('projects.index') }}" 
                   class="{{ request()->routeIs('projects.*') ? 'active' : '' }}">
                   Proyek
                </a>
            </li>
        </ul>

       @auth
            <div class="profile-container">
                <img 
                    src="{{ Auth::user()->photo_url ? asset(Auth::user()->photo_url) : asset('images/profile-icon.png') }}" 
                    alt="Profil" 
                    class="profile-icon" 
                    onclick="toggleDropdown()"
                >
                <span>{{ Auth::user()->name }}</span>

                <div class="dropdown" id="dropdown">
                    <a href="{{ route('profile') }}">Profil</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit">Keluar</button>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</nav>

<script>
    function toggleDropdown() {
        document.getElementById('dropdown').classList.toggle('show');
    }

    document.addEventListener('click', function (event) {
        const dropdown = document.getElementById('dropdown');
        const profileIcon = document.querySelector('.profile-icon');
        if (!profileIcon.contains(event.target)) {
            dropdown.classList.remove('show');
        }
    });
</script>