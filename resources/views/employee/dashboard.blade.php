<x-app-layout>
    <x-slot name="header">
        <h2 class="font-weight-bold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Dipendente') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h5 class="mb-4 text-lg font-weight-bold text-secondary">Benvenuto, {{ Auth::user()->name }}!</h5>

                    <p class="lead">
                        Questo è il tuo cruscotto personale. Qui puoi gestire le tue attività principali:
                    </p>

                    <div class="row mt-4
">

                        <div class="col-md-4 mb-4">
                            <div class="card h-100 border-left-primary shadow">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Timbrature
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">Registra Presenza</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                    <a href="{{ route('employee.timesheets.index') }}"
                                        class="btn btn-sm btn-primary mt-3">Vai alla Timbratura</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="card h-100 border-left-success shadow">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Documenti
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">Buste Paga & Premi</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-file-invoice-dollar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                    <a href="{{ route('employee.payslips.index') }}"
                                        class="btn btn-sm btn-success mt-3">Visualizza Documenti</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="card h-100 border-left-warning shadow">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Assenze
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">Richiedi Ferie/Permessi
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar-times fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                    <a href="{{ route('employee.absences.index') }}"
                                        class="btn btn-sm btn-warning mt-3 text-white">Gestisci Assenze</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


</x-app-layout>
