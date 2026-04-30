<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Timbrature e Rilevazione Presenze') }}
        </h2>
    </x-slot>

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Registra Presenza</h5>
        </div>
        <div class="card-body">
            @if ($openTimesheet)
                <div class="alert alert-warning">
                    Hai una timbratura aperta da: <strong>{{ $openTimesheet->clock_in->format('d/m/Y H:i:s') }}</strong>
                </div>
                <form method="POST" action="{{ route('employee.timesheets.clockOut') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-lg">
                        <i class="fas fa-sign-out-alt"></i> Registra Uscita
                    </button>
                </form>
            @else
                <form method="POST" action="{{ route('employee.timesheets.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="notes" class="form-label">Note (Opzionale)</label>
                        <input type="text" class="form-control" id="notes" name="notes">
                    </div>
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="fas fa-sign-in-alt"></i> Registra Ingresso
                    </button>
                </form>
            @endif
        </div>
    </div>

    <h3 class="mt-4">Storico Timbrature</h3>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-light">
                <tr>
                    <th>Data</th>
                    <th>Ingresso</th>
                    <th>Uscita</th>
                    <th>Ore Lavorate</th>
                    <th>Straordinari</th>
                    <th>Note</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($timesheets as $ts)
                    <tr>
                        <td>{{ $ts->clock_in->format('d/m/Y') }}</td>
                        <td>{{ $ts->clock_in->format('H:i:s') }}</td>
                        <td>{{ $ts->clock_out ? $ts->clock_out->format('H:i:s') : 'N/D' }}</td>
                        <td>{{ $ts->hours_worked ?? 'In Corso' }}</td>
                        <td>{{ $ts->overtime_hours ?? '0.00' }}</td>
                        <td>{{ $ts->notes }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Nessuna timbratura trovata.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $timesheets->links('pagination::bootstrap-5') }}
    </div>
</x-app-layout>
