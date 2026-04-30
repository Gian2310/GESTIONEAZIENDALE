<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0 text-gray-800 d-flex justify-content-between align-items-center">
            {{ __('Gestione Dipendenti') }}
            <a href="{{ route('admin.employees.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus fa-sm me-1"></i> Aggiungi Dipendente
            </a>
        </h2>
    </x-slot>

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Elenco Dipendenti</h6>
                </div>
                <div class="card-body">

                    {{-- Sezione Messaggi di Stato --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Form di Ricerca --}}
                    <form method="GET" action="{{ route('admin.employees.index') }}" class="mb-4">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control"
                                placeholder="Cerca per nome, cognome o email..." value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary" type="submit">Cerca</button>
                            @if (request('search'))
                                <a href="{{ route('admin.employees.index') }}" class="btn btn-outline-danger">Reset</a>
                            @endif
                        </div>
                    </form>

                    {{-- Tabella Dipendenti --}}
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nome Completo</th>
                                    <th>Email</th>
                                    <th>Ruolo</th>
                                    <th>Reparto</th>
                                    <th>Data Assunzione</th>
                                    <th class="text-center">Azioni</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($employees as $employee)
                                    <tr>
                                        <td>{{ $employee->first_name }} {{ $employee->last_name }}</td>
                                        <td>{{ $employee->email }}</td>
                                        <td>
                                            @if ($employee->role == 'admin')
                                                <span class="badge bg-danger">Amministratore</span>
                                            @elseif ($employee->role == 'manager')
                                                <span class="badge bg-warning text-dark">Manager</span>
                                            @else
                                                <span class="badge bg-secondary">Dipendente</span>
                                            @endif
                                        </td>
                                        <td>{{ $employee->department->name ?? 'N/A' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($employee->hiring_date)->format('d/m/Y') }}</td>
                                        <td class="text-center">
                                            {{-- MODIFICA (Pulsante con testo) --}}
                                            <a href="{{ route('admin.employees.edit', $employee) }}"
                                                class="btn btn-warning btn-sm me-2" title="Modifica">
                                                <i class="fas fa-edit me-1"></i> Modifica
                                            </a>
                                            {{-- ELIMINA (Pulsante con testo) --}}
                                            <form action="{{ route('admin.employees.destroy', $employee) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Sei sicuro di voler eliminare questo dipendente? Questa azione è irreversibile.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Elimina">
                                                    <i class="fas fa-trash me-1"></i> Elimina
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Nessun dipendente trovato.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Paginazione --}}
                    <div class="mt-3">
                        {{ $employees->links('pagination::bootstrap-5') }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
