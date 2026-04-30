<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Richiesta Ferie, Permessi o Malattia') }}
        </h2>
    </x-slot>

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            Saldo stimato Ferie/Permessi Residui: **{{ $vacationBalance ?? 'N/D' }} giorni**
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('employee.absences.store') }}">
                @csrf

                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="type" class="form-label">Tipo di Assenza</label>
                        <select class="form-select @error('type') is-invalid @enderror" id="type" name="type"
                            required>
                            <option value="">Seleziona Tipo</option>
                            <option value="Ferie" {{ old('type') == 'Ferie' ? 'selected' : '' }}>Ferie</option>
                            <option value="Permesso" {{ old('type') == 'Permesso' ? 'selected' : '' }}>Permesso</option>
                            <option value="Malattia" {{ old('type') == 'Malattia' ? 'selected' : '' }}>Malattia
                                (Richiede certificato)</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="start_date" class="form-label">Data Inizio</label>
                        <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                            id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                        @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="end_date" class="form-label">Data Fine</label>
                        <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                            id="end_date" name="end_date" value="{{ old('end_date') }}" required>
                        @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="reason" class="form-label">Motivazione/Dettagli</label>
                        <textarea class="form-control @error('reason') is-invalid @enderror" id="reason" name="reason" rows="4">{{ old('reason') }}</textarea>
                        @error('reason')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-paper-plane"></i> Invia Richiesta
                    </button>
                    <a href="{{ route('employee.absences.index') }}" class="btn btn-secondary">Annulla</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
