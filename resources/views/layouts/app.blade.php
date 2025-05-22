<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>ToDoList</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Google Fonts - Nunito -->
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet" />

    <style>
        body {
            display: flex;
            min-height: 100vh;
            font-family: 'Nunito', sans-serif;
            background-color: #f9fbfd;
        }

        .sidebar {
            width: 220px;
            background-color: #343a40;
            color: white;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
        }

        .sidebar h4 {
            padding: 1rem;
            text-align: center;
            border-bottom: 1px solid #495057;
            margin-bottom: 0;
        }

        .sidebar a {
            display: block;
            padding: 0.75rem 1rem;
            color: white;
            text-decoration: none;
            border-left: 4px solid transparent;
            transition: background-color 0.3s, border-left-color 0.3s;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #495057;
            border-left-color: #0d6efd;
            color: #0d6efd;
            font-weight: 600;
        }

        .main-content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .navbar {
            border-bottom: 1px solid #dee2e6;
        }

        .content-wrapper {
            padding: 20px;
            flex-grow: 1;
        }

        .dropdown-item span {
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

    {{-- Ambil notifikasi --}}
    @php
        use App\Models\Tugas;
        use App\Models\Catatan;

        $tugasBaru = Tugas::latest()->take(5)->get();
        $catatanBaru = Catatan::latest()->take(5)->get();
    @endphp

    @auth
    <div class="sidebar">
        <h4>Dashboard</h4>
        <a href="{{ url('/dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">🏠 Dashboard</a>
        <a href="{{ route('tugas.index') }}" class="{{ request()->is('tugas*') ? 'active' : '' }}">📝 Daftar Tugas</a>
        <a href="{{ url('/kategori') }}" class="{{ request()->is('kategori*') ? 'active' : '' }}">📂 Kategori</a>
        <a href="{{ route('catatan.index') }}" class="{{ request()->is('catatan*') ? 'active' : '' }}">🗒️ Catatan</a>
    </div>
@endauth

   

    <div class="main-content">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm px-4">
            <div class="container-fluid">
                <a class="navbar-brand fw-bold text-primary" href="{{ url('/') }}">
                    ToDoList
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto align-items-center">
                        <!-- Notifikasi Tugas -->
                        <li class="nav-item dropdown me-3">
                            <a class="nav-link position-relative" href="#" id="notifDropdownTugas" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-bell fs-5"></i>
                                @if($tugasBaru->count() > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $tugasBaru->count() }}
                                    </span>
                                @endif
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm p-2 rounded-3" aria-labelledby="notifDropdownTugas" style="min-width: 300px;">
                                <h6 class="dropdown-header text-primary">Tugas Terbaru</h6>
                                @forelse($tugasBaru as $tugas)
                                    <li>
                                        <a class="dropdown-item d-flex justify-content-between align-items-center" href="{{ route('tugas.show', $tugas->id) }}">
                                            <span class="text-truncate" style="max-width: 80%;">{{ $tugas->judul }}</span>
                                            <span class="badge {{ $tugas->status == 'selesai' ? 'bg-success' : 'bg-warning text-dark' }} rounded-pill">
                                                {{ ucfirst($tugas->status) }}
                                            </span>
                                        </a>
                                    </li>
                                @empty
                                    <li><span class="dropdown-item text-muted">Tidak ada tugas baru.</span></li>
                                @endforelse
                            </ul>
                        </li>

                        <!-- Notifikasi Catatan -->
                        <li class="nav-item dropdown me-3">
                            <a class="nav-link position-relative" href="#" id="notifDropdownCatatan" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-journal-text fs-5"></i>
                                @if($catatanBaru->count() > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $catatanBaru->count() }}
                                    </span>
                                @endif
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm p-2 rounded-3" aria-labelledby="notifDropdownCatatan" style="min-width: 300px;">
                                <h6 class="dropdown-header text-primary">Catatan Terbaru</h6>
                                @forelse($catatanBaru as $catatan)
                                    <li>
                                        <a class="dropdown-item text-truncate" href="{{ route('catatan.index') }}">
                                            {{ Str::limit($catatan->judul, 40) }}
                                        </a>
                                    </li>
                                @empty
                                    <li><span class="dropdown-item text-muted">Tidak ada catatan baru.</span></li>
                                @endforelse
                            </ul>
                        </li>

                        <!-- User Dropdown -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                   aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <div class="content-wrapper">
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @stack('scripts')
</body>
</html>
