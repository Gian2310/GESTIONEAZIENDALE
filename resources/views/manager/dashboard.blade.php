<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0 text-gray-800">
            {{ __('Dashboard Responsabile di Reparto') }}
        </h2>
    </x-slot>

    <div class="py-4"> {{-- Ridotto il padding verticale per Bootstrap --}}
        <div class="container"> {{-- Utilizzato container per Bootstrap --}}
            <div class="card shadow-sm mb-4"> {{-- Card per Bootstrap --}}
                <div class="card-body">
                    <h3 class="h3 mb-4">Benvenuto, {{ Auth::user()->name }}!</h3>
                    <p class="mb-4">Sei nella sezione Manager. Qui puoi gestire:</p>

                    <div class="row g-4"> {{-- Grid per Bootstrap --}}
                        <!-- Card 1: Approvazione Assenze -->
                        <div class="col-md-4"> {{-- Colonna per Bootstrap --}}
                            <div class="card h-100 border-primary"> {{-- Stile card per Bootstrap --}}
                                <div class="card-body">
                                    <h4 class="card-title text-primary">Approvazione Assenze</h4>
                                    <p class="card-text text-muted mt-2">Visualizza e approva o rifiuta le richieste di
                                        assenza dei tuoi dipendenti.</p>
                                    <a href="{{ route('manager.absence-approvals.index') }}"
                                        class="btn btn-primary btn-sm mt-3"> {{-- Pulsante Bootstrap --}}
                                        Vai alle Approvazioni
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Card 2: Reportistica Reparto -->
                        <div class="col-md-4">
                            <div class="card h-100 border-success">
                                <div class="card-body">
                                    <h4 class="card-title text-success">Report Reparto</h4>
                                    <p class="card-text text-muted mt-2">Visualizza la panoramica di presenze e assenze
                                        del tuo team.</p>
                                    <a href="{{ route('manager.reports.departmentOverview') }}"
                                        class="btn btn-success btn-sm mt-3">
                                        Visualizza Report
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Card 3: I Tuoi Dipendenti -->
                        <div class="col-md-4">
                            <div class="card h-100 border-warning">
                                <div class="card-body">
                                    <h4 class="card-title text-warning">Il Tuo Team</h4>
                                    <p class="card-text text-muted mt-2">Panoramica rapida dei dipendenti assegnati alla
                                        tua gestione.</p>
                                    {{-- Il link per i dettagli dei dipendenti non è definito. Per ora, lo lascio come un pulsante disabilitato o un link a '#' --}}
                                    <a href="#" class="btn btn-secondary btn-sm mt-3 disabled"
                                        aria-disabled="true">
                                        Vedi Dettagli (Presto!)
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
