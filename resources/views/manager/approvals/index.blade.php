<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Approvazione Richieste di Assenza') }}
        </h2>
    </x-slot>

    <div class="card shadow">
        {{-- Standardizzato il card-header --}}
        <div class="card-header bg-dark text-white">
            Richieste in Sospeso del tuo Reparto
        </div>
        <div class="card-body">
            @if ($pendingAbsences->isEmpty())
                <div class="alert alert-info mb-0">Non ci sono richieste di assenza in attesa di approvazione nel tuo
                    reparto.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Dipendente</th>
                                <th>Tipo</th>
                                <th>Periodo</th>
                                <th>Giorni</th>
                                <th>Stato</th>
                                <th>Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pendingAbsences as $absence)
                                <tr>
                                    <td>{{ $absence->user->name }}</td>
                                    <td><span class="badge bg-secondary">{{ $absence->type }}</span></td>
                                    <td>{{ $absence->start_date->format('d/m/Y') }} al
                                        {{ $absence->end_date->format('d/m/Y') }}</td>
                                    <td>{{ $absence->days_requested }}</td>
                                    {{-- Standardizzato il badge dello stato 'Pending' su bg-secondary --}}
                                    <td><span class="badge bg-secondary">{{ $absence->status }}</span></td>
                                    <td>
                                        <a href="{{ route('manager.absence-approvals.edit', $absence) }}"
                                            class="btn btn-sm btn-success">
                                            Valuta
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $pendingAbsences->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
