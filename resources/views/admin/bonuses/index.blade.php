<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Gestione Premi di Produzione') }}
        </h2>
    </x-slot>

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header bg-{{ isset($bonus) ? 'warning' : 'primary' }} text-white">
                    {{ isset($bonus) ? 'Modifica Premio' : 'Aggiungi Nuovo Premio' }}
                </div>
                <div class="card-body">
                    <form method="POST"
                        action="{{ isset($bonus) ? route('admin.bonuses.update', $bonus) : route('admin.bonuses.store') }}">
                        @csrf
                        @if (isset($bonus))
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label for="name" class="form-label">Nome Premio</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                id="name" name="name" value="{{ old('name', $bonus->name ?? '') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="amount" class="form-label">Ammontare (€)</label>
                            <input type="number" step="0.01"
                                class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount"
                                value="{{ old('amount', $bonus->amount ?? '') }}" required>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="bonus_date" class="form-label">Data Assegnazione</label>
                            <input type="date" class="form-control @error('bonus_date') is-invalid @enderror"
                                id="bonus_date" name="bonus_date"
                                value="{{ old('bonus_date', $bonus->bonus_date ?? now()->format('Y-m-d')) }}" required>
                            @error('bonus_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="department_id" class="form-label">Reparto Associato (Opzionale)</label>
                            <select class="form-select @error('department_id') is-invalid @enderror" id="department_id"
                                name="department_id">
                                <option value="">Tutta l'Azienda (Globale)</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}"
                                        {{ old('department_id', $bonus->department_id ?? '') == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}</option>
                                @endforeach
                            </select>
                            @error('department_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Descrizione</label>
                            <textarea class="form-control" id="description" name="description">{{ old('description', $bonus->description ?? '') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-{{ isset($bonus) ? 'success' : 'primary' }}">
                            {{ isset($bonus) ? 'Aggiorna Premio' : 'Salva Premio' }}
                        </button>
                        @if (isset($bonus))
                            <a href="{{ route('admin.bonuses.index') }}" class="btn btn-secondary">Annulla</a>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    Lista Premi Registrati
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Nome</th>
                                    <th>Ammontare (€)</th>
                                    <th>Data</th>
                                    <th>Reparto</th>
                                    <th>Azioni</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($bonuses as $b)
                                    <tr>
                                        <td>{{ $b->name }}</td>
                                        <td>{{ number_format($b->amount, 2, ',', '.') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($b->bonus_date)->format('d/m/Y') }}</td>
                                        <td>{{ $b->department->name ?? 'Globale' }}</td>
                                        <td>
                                            <a href="{{ route('admin.bonuses.edit', $b) }}"
                                                class="btn btn-sm btn-outline-warning me-2">Modifica</a>
                                            <form action="{{ route('admin.bonuses.destroy', $b) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Sicuro di voler eliminare questo premio?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-sm btn-outline-danger">Elimina</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Nessun premio registrato.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $bonuses->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
