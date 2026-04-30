<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Gestione Contratti Applicati') }}
        </h2>
    </x-slot>

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header bg-{{ isset($contract) ? 'warning' : 'primary' }} text-white">
                    {{ isset($contract) ? 'Modifica Contratto: ' . $contract->name : 'Aggiungi Nuovo Contratto' }}
                </div>
                <div class="card-body">
                    <form method="POST"
                        action="{{ isset($contract) ? route('admin.contracts.update', $contract) : route('admin.contracts.store') }}">
                        @csrf
                        @if (isset($contract))
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label for="name" class="form-label">Nome Contratto</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                id="name" name="name" value="{{ old('name', $contract->name ?? '') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="daily_hours" class="form-label">Ore Giornaliere Standard</label>
                            <input type="number" class="form-control @error('daily_hours') is-invalid @enderror"
                                id="daily_hours" name="daily_hours"
                                value="{{ old('daily_hours', $contract->daily_hours ?? 8) }}" required>
                            @error('daily_hours')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="pause_minutes" class="form-label">Minuti Pausa Lavoro</label>
                            <input type="number" class="form-control @error('pause_minutes') is-invalid @enderror"
                                id="pause_minutes" name="pause_minutes"
                                value="{{ old('pause_minutes', $contract->pause_minutes ?? 30) }}" required>
                            @error('pause_minutes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="vacation_days_per_year" class="form-label">Giorni Ferie Annuali</label>
                            <input type="number"
                                class="form-control @error('vacation_days_per_year') is-invalid @enderror"
                                id="vacation_days_per_year" name="vacation_days_per_year"
                                value="{{ old('vacation_days_per_year', $contract->vacation_days_per_year ?? 26) }}"
                                required>
                            @error('vacation_days_per_year')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Descrizione</label>
                            <textarea class="form-control" id="description" name="description">{{ old('description', $contract->description ?? '') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-{{ isset($contract) ? 'success' : 'primary' }}">
                            {{ isset($contract) ? 'Aggiorna Contratto' : 'Salva Contratto' }}
                        </button>
                        @if (isset($contract))
                            <a href="{{ route('admin.contracts.index') }}" class="btn btn-secondary">Annulla</a>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    Lista Contratti
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Nome</th>
                                    <th>Ore/Giorno</th>
                                    <th>Pausa (Min)</th>
                                    <th>Ferie/Anno</th>
                                    <th>Azioni</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($contracts as $c)
                                    <tr>
                                        <td>{{ $c->name }}</td>
                                        <td>{{ $c->daily_hours }}</td>
                                        <td>{{ $c->pause_minutes }}</td>
                                        <td>{{ $c->vacation_days_per_year }}</td>
                                        <td>
                                            <a href="{{ route('admin.contracts.edit', $c) }}"
                                                class="btn btn-sm btn-outline-warning me-2">Modifica</a>
                                            <form action="{{ route('admin.contracts.destroy', $c) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Sicuro di voler eliminare {{ $c->name }}?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-sm btn-outline-danger">Elimina</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Nessun contratto registrato.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $contracts->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
