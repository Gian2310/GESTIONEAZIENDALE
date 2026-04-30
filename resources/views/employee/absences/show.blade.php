<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Dettagli Richiesta Assenza') }}
        </h2>
    </x-slot>

    <div class="card shadow">
        <div class="card-header bg-secondary text-white">
            Dettagli Richiesta
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4"><strong>Tipo:</strong></div>
                <div class="col-md-8">{{ $absence->type }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><strong>Periodo:</strong></div>
                <div class="col-md-8">{{ $absence->start_date->format('d/m/Y') }} al
                    {{ $absence->end_date->format('d/m/Y') }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><strong>Giorni Richiesti:</strong></div>
                <div class="col-md-8">{{ $absence->days_requested }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><strong>Stato Attuale:</strong></div>
                <div class="col-md-8"><span
                        class="badge bg-{{ ['Pending' => 'warning', 'Approved' => 'success', 'Rejected' => 'danger'][$absence->status] ?? 'info' }}">{{ $absence->status }}</span>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><strong>Motivazione:</strong></div>
                <div class="col-md-8">{{ $absence->reason ?? 'Non specificata.' }}</div>
            </div>

            @if ($absence->manager_notes)
                <hr>
                <h5>Note del Manager</h5>
                <p class="alert alert-light">{{ $absence->manager_notes }}</p>
            @endif

            <div class="mt-4">
                <a href="{{ route('employee.absences.index') }}" class="btn btn-secondary">Torna all'Archivio</a>
            </div>
        </div>
    </div>
</x-app-layout>
