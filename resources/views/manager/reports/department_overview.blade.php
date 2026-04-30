<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Report Reparto: ') }} {{ $manager->department->name ?? 'Non Assegnato' }}
        </h2>
    </x-slot>

    {{-- Definisci i mesi qui in modo che siano accessibili in tutta la vista --}}
    @php
        $months = [
            1 => 'Gennaio',
            2 => 'Febbraio',
            3 => 'Marzo',
            4 => 'Aprile',
            5 => 'Maggio',
            6 => 'Giugno',
            7 => 'Luglio',
            8 => 'Agosto',
            9 => 'Settembre',
            10 => 'Ottobre',
            11 => 'Novembre',
            12 => 'Dicembre',
        ];
        $currentMonth = request('month', now()->month);
        $currentYear = request('year', now()->year);
    @endphp

    @if ($manager->department_id)
        {{-- Sezione Filtro Mese/Anno --}}
        <div class="card shadow mb-4">
            <div class="card-header bg-dark text-white">
                Filtro Mese/Anno
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('manager.reports.departmentOverview') }}"
                    class="row g-3 align-items-end">
                    <div class="col-auto">
                        <label for="month" class="form-label">Mese</label>
                        <select name="month" id="month" class="form-select">
                            @foreach ($months as $k => $v)
                                <option value="{{ $k }}" {{ $currentMonth == $k ? 'selected' : '' }}>
                                    {{ $v }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-auto">
                        <label for="year" class="form-label">Anno</label>
                        <select name="year" id="year" class="form-select">
                            @for ($i = now()->year; $i >= now()->year - 3; $i--)
                                <option value="{{ $i }}" {{ $currentYear == $i ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">Filtra Report</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Sezione Statistiche di Reparto (Aggiunta per coerenza) --}}
        <div class="card shadow mb-4">
            <div class="card-header bg-dark text-white">
                Statistiche di Reparto per {{ $months[$currentMonth] }} {{ $currentYear }}
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-4 mb-3 mb-md-0">
                        <div class="p-3 border rounded bg-light">
                            <h5 class="text-secondary">Totale Dipendenti</h5>
                            <p class="h3 mb-0">{{ count($reportData) }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3 mb-md-0">
                        <div class="p-3 border rounded bg-light">
                            <h5 class="text-secondary">Ore Totali Lavorate</h5>
                            <p class="h3 mb-0 text-success">{{ array_sum(array_column($reportData, 'total_hours')) }}h
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 border rounded bg-light">
                            <h5 class="text-secondary">Giorni Totali Assenza</h5>
                            <p class="h3 mb-0 text-danger">
                                {{ array_sum(array_column($reportData, 'total_absence_days')) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sezione Dettaglio Presenze/Assenze --}}
        <div class="card shadow">
            <div class="card-header bg-info text-white">
                Dettaglio Presenze/Assenze
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Dipendente</th>
                                <th>Ore Lavorate Totali (h)</th>
                                <th>Giorni Assenza Approvati</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($reportData as $data)
                                <tr>
                                    <td>{{ $data['employee'] }}</td>
                                    <td class="text-success fw-bold">{{ $data['total_hours'] }}</td>
                                    <td class="text-danger">{{ $data['total_absence_days'] }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Nessun dipendente o dato di presenza trovato
                                        per questo reparto nel periodo selezionato.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-danger">Il tuo account Manager non è associato a nessun Reparto. Si prega di contattare
            l'Amministratore.</div>
    @endif
</x-app-layout>
