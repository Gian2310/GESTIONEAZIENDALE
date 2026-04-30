<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0 text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-body p-4">

                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{-- Messaggio di benvenuto generico --}}
                        <div class="alert alert-info border-start border-4 border-info d-flex align-items-center mb-4 p-3"
                            role="alert">
                            <div>
                                Benvenuto, **{{ Auth::user()->name }}**!
                                <p class="mt-1 mb-0">Il tuo ruolo attuale è: <span
                                        class="fw-bold text-uppercase">{{ Auth::user()->role }}</span>.</p>
                            </div>
                        </div>

                        {{-- SEZIONE AZIONI RAPIDE ADMIN --}}
                        @if (Auth::user()->role === 'admin')
                            <div class="mt-4 p-4 border-start border-4 border-primary bg-light rounded-3">
                                <h3 class="h5 text-primary mb-3">Azioni Rapide Amministratore</h3>
                                <p class="text-secondary mb-4 small">Accesso completo ai moduli di Anagrafica, HR e
                                    Reportistica.</p>

                                <div class="d-flex flex-wrap gap-2">
                                    {{-- Link 1: Gestione Dipendenti (Index) --}}
                                    <a href="{{ route('admin.employees.index') }}"
                                        class="btn btn-primary btn-sm text-uppercase fw-bold shadow-sm">
                                        Gestione Dipendenti
                                    </a>

                                    {{-- Link 2: Carica Busta Paga (Create) --}}
                                    <a href="{{ route('admin.payslips.create') }}"
                                        class="btn btn-success btn-sm text-uppercase fw-bold shadow-sm">
                                        Carica Busta Paga
                                    </a>

                                    {{-- Link 3: Report Costo Lavoro --}}
                                    <a href="{{ route('admin.reports.costOfLabor') }}"
                                        class="btn btn-warning btn-sm text-white text-uppercase fw-bold shadow-sm">
                                        Report Costo Lavoro
                                    </a>

                                    {{-- Aggiungere qui altri link rapidi se necessario --}}
                                </div>
                            </div>
                        @endif

                        {{-- SEZIONE AZIONI RAPIDE MANAGER (Se esiste il ruolo manager) --}}
                        @if (Auth::user()->role === 'manager')
                            <div class="mt-4 p-4 border-start border-4 border-warning bg-light rounded-3">
                                <h3 class="h5 text-warning mb-3">Azioni Rapide Manager</h3>
                                <p class="text-secondary mb-4 small">Gestione del Team, approvazioni e reportistica di
                                    reparto.</p>

                                <div class="d-flex flex-wrap gap-2">
                                    {{-- Link 1: Approvazione Assenze --}}
                                    <a href="{{ route('manager.absence-approvals.index') }}"
                                        class="btn btn-danger btn-sm text-uppercase fw-bold shadow-sm">
                                        Approvazione Assenze
                                    </a>

                                    {{-- Link 2: Report Reparto --}}
                                    <a href="{{ route('manager.reports.departmentOverview') }}"
                                        class="btn btn-info btn-sm text-white text-uppercase fw-bold shadow-sm">
                                        Report Reparto
                                    </a>
                                </div>
                            </div>
                        @endif

                        {{-- SEZIONE AZIONI RAPIDE DIPENDENTE (Tutti i ruoli vedono le proprie azioni) --}}
                        <div class="mt-4 p-4 border-start border-4 border-secondary bg-light rounded-3">
                            <h3 class="h5 text-secondary mb-3">Le Tue Azioni Personali</h3>
                            <p class="text-muted mb-4 small">Accedi rapidamente alle tue funzionalità più usate.</p>

                            <div class="d-flex flex-wrap gap-2">
                                {{-- Link 1: Timbrature --}}
                                <a href="{{ route('employee.timesheets.index') }}"
                                    class="btn btn-secondary btn-sm text-uppercase fw-bold shadow-sm">
                                    Timbrature
                                </a>

                                {{-- Link 2: Richiesta Assenza --}}
                                <a href="{{ route('employee.absences.create') }}"
                                    class="btn btn-secondary btn-sm text-uppercase fw-bold shadow-sm">
                                    Richiedi Assenza/Ferie
                                </a>

                                {{-- Link 3: Buste Paga --}}
                                <a href="{{ route('employee.payslips.index') }}"
                                    class="btn btn-secondary btn-sm text-uppercase fw-bold shadow-sm">
                                    Buste Paga/Premi
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
