<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold d-flex justify-content-between align-items-center">
            {{ __('Mio Saldo e Richieste Assenze') }}
            <a href="{{ route('employee.absences.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nuova Richiesta
            </a>
        </h2>
    </x-slot>

    <div class="card shadow">
        <div class="card-header bg-secondary text-white">
            Storico Richieste
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Tipo</th>
                            <th>Inizio</th>
                            <th>Fine</th>
                            <th>Giorni</th>
                            <th>Stato</th>
                            <th>Azioni</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($absences as $absence)
                            @php
                                $badgeColor =
                                    [
                                        'Pending' => 'warning',
                                        'Approved' => 'success',
                                        'Rejected' => 'danger',
                                    ][$absence->status] ?? 'info';
                            @endphp
                            <tr>
                                <td>{{ $absence->type }}</td>
                                <td>{{ $absence->start_date->format('d/m/Y') }}</td>
                                <td>{{ $absence->end_date->format('d/m/Y') }}</td>
                                <td>{{ $absence->days_requested }}</td>
                                <td><span class="badge bg-{{ $badgeColor }}">{{ $absence->status }}</span></td>
                                <td>
                                    <a href="{{ route('employee.absences.show', $absence) }}"
                                        class="btn btn-sm btn-info text-white">Dettagli</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Nessuna richiesta di assenza trovata.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $absences->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</x-app-layout>
