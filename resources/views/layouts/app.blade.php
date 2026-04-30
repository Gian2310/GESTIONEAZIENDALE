<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Gestionale Aziendale') }}</title>

    <!-- Assicurati che questi percorsi siano corretti per Laravel/Vite -->
    @vite(['resources/js/app.js', 'resources/scss/app.scss'])

    <!-- Alpine.js (già incluso in app.js, ma a volte serve qui se usato in <head>) -->
    {{-- <script src="//unpkg.com/alpinejs" defer></script> --}}
</head>

<body class="bg-light">
    <!-- INIZIO HEADER/NAVBAR (Copia del tuo app.blade.php) -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand"
                    href="{{ route('dashboard') }}">{{ config('app.name', 'Gestionale Aziendale') }}</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                        {{-- Dashboard Link (Sempre visibile) --}}
                        <li class="nav-item">
                            <a class="nav-link @if (request()->routeIs('dashboard')) active @endif"
                                href="{{ route('dashboard') }}">Dashboard</a>
                        </li>

                        {{-- === 1. Menu Amministrativo: Anagrafica e Struttura === --}}
                        @if (Auth::user()->isAdmin())
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="adminRegistryDropdown"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Anagrafica
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="adminRegistryDropdown">
                                    <li><a class="dropdown-item" href="{{ route('admin.employees.index') }}">Gestione
                                            Dipendenti</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.departments.index') }}">Gestione
                                            Reparti</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.contracts.index') }}">Gestione
                                            Contratti</a></li>
                                </ul>
                            </li>

                            {{-- === 2. Menu Amministrativo: HR e Paghe/Premi === --}}
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="adminHRDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    HR & Paghe
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="adminHRDropdown">
                                    <li><a class="dropdown-item" href="{{ route('admin.bonuses.index') }}">Gestione
                                            Premi</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.payslips.create') }}">Carica
                                            Buste Paga</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    {{-- COLLEGAMENTO AGGIUNTO: Report Costo Lavoro (Requisito 5) --}}
                                    <li><a class="dropdown-item" href="{{ route('admin.reports.costOfLabor') }}">Report
                                            Costo Lavoro</a></li>
                                </ul>
                            </li>
                        @endif

                        {{-- === 3. Menu Manager/Supervisore === --}}
                        @if (Auth::user()->isManager() || Auth::user()->isAdmin())
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="managerDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Gestione Team
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="managerDropdown">
                                    {{-- COLLEGAMENTO AGGIUNTO: Approvazione Assenze (Requisito 3) --}}
                                    <li><a class="dropdown-item"
                                            href="{{ route('manager.absence-approvals.index') }}">Approvazione
                                            Assenze</a></li>
                                    {{-- COLLEGAMENTO AGGIUNTO: Report Reparto (Requisito 5) --}}
                                    <li><a class="dropdown-item"
                                            href="{{ route('manager.reports.departmentOverview') }}">Report Reparto</a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        {{-- === 4. Menu Personale (Self-Service) === --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="employeeDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Personale
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="employeeDropdown">
                                {{-- COLLEGAMENTO AGGIUNTO: Timbrature (Requisito 2) --}}
                                <li><a class="dropdown-item"
                                        href="{{ route('employee.timesheets.index') }}">Timbrature</a></li>
                                {{-- HO CORRETTO IL LINK: Assenze/Ferie (Requisito 3) --}}
                                <li><a class="dropdown-item"
                                        href="{{ route('employee.absences.index') }}">Assenze/Ferie</a></li>
                                <li><a class="dropdown-item" href="{{ route('employee.payslips.index') }}">Buste
                                        Paga/Premi</a></li>
                            </ul>
                        </li>
                    </ul>

                    {{-- === Dropdown Utente e Logout === --}}
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->name }} ({{ strtoupper(Auth::user()->role) }})
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profilo</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Log Out</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <!-- FINE HEADER/NAVBAR -->


    <!-- Header della pagina interna (breadcrumb/titolo) -->
    <header class="bg-white shadow-sm">
        <div class="container py-3">
            {{ $header ?? '' }}
        </div>
    </header>

    <!-- Contenuto principale -->
    <main class="py-4">
        <div class="container">
            {{-- Messaggi di Sessione per Successo e Errore --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{ $slot }}
        </div>
    </main>
</body>

</html>
