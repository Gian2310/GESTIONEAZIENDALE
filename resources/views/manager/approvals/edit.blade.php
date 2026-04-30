<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Valutazione Richiesta Assenza') }}
        </h2>
    </x-slot>

    <div class="card shadow">
        {{-- Standardizzato il card-header --}}
        <div class="card-header bg-dark text-white">
            Dettagli Richiesta di: **{{ $absence->user->name }}**
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4"><strong>Tipo:</strong></div>
                {{-- Uso di una badge più neutra, se si vuole uniformità --}}
                <div class="col-md-8"><span class="badge bg-secondary">{{ $absence->type }}</span></div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><strong>Periodo:</strong></div>
                <div class="col-md-8">{{ $absence->start_date->format('d/m/Y') }} al
                    {{ $absence->end_date->format('d/m/Y') }} ({{ $absence->days_requested }} giorni)</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><strong>Motivazione:</strong></div>
                <div class="col-md-8">{{ $absence->reason ?? 'Nessuna motivazione fornita.' }}</div>
            </div>

            <hr>

            <h4>Decisione del Manager</h4>
            <form method="POST" action="{{ route('manager.absence-approvals.update', $absence) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Stato:</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="approve" value="Approved"
                            required>
                        <label class="form-check-label text-success" for="approve">
                            Approvata
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="reject" value="Rejected">
                        <label class="form-check-label text-danger" for="reject">
                            Rifiutata
                        </label>
                    </div>
                    @error('status')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="manager_notes" class="form-label">Note del Manager (Opzionale)</label>
                    <textarea class="form-control" id="manager_notes" name="manager_notes" rows="3">{{ old('manager_notes', $absence->manager_notes) }}</textarea>
                    @error('manager_notes')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check-circle"></i> Conferma Decisione
                    </button>
                    <a href="{{ route('manager.absence-approvals.index') }}" class="btn btn-secondary">Torna alla
                        Lista</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
