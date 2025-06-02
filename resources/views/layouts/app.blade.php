<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tech Jobs</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">

    <!-- FilePond CSS (optional if you're using FilePond elsewhere) -->
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-dark border-bottom border-body" data-bs-theme="dark">
        <div class="container">
            <a class="navbar-brand text-white" href="/">Tech Jobs</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/"><b>Home</b></a>
                    </li>
                     <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/dashboard"><b>Dashboard</b></a>
                    </li>
                   


                    <!-- Vertical Divider -->
                    <li class="nav-item mx-2">
                        <div class="vr h-100 bg-white opacity-10"></div>
                    </li>

                    @auth
                        @php
                            $user = Auth::user();
                            $initials = collect(explode(' ', $user->name))
                                ->map(fn($n) => strtoupper($n[0]))
                                ->join('');
                        @endphp

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                @if ($user->profile_pic)
                                    <img src="{{ Storage::url($user->profile_pic) }}" width="40" height="30"
                                        class="rounded-circle" alt="Profile">
                                @else
                                    <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center"
                                        style="width: 40px; height: 30px; font-weight: bold;">
                                        {{ $initials }}
                                    </div>
                                @endif
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><span class="dropdown-item-text fw-bold">{{ $user->name }}</span></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="{{ route('job.applied') }}">Job applied</a></li>

                                <li><a class="dropdown-item" href="{{ route('seeker.profile') }}">Profile</a></li>
                                <li><a class="dropdown-item" href="#" id="logout">Logout</a></li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('create.Seeker') }}">Job Seeker</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('create.employer') }}">Employer</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hidden Logout Form -->
    <form id="form-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <!-- Content Section -->
    <div class="container mt-4">
        @yield('content')
    </div>

    <!-- Bootstrap Bundle (with Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous">
    </script>

    <!-- FilePond JS (if needed) -->
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>

    <!-- Logout Script -->
    <script>
        document.getElementById('logout')?.addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('form-logout').submit();
        });
    </script>
</body>

</html>
