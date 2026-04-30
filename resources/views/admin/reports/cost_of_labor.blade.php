<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Report Costo del Lavoro per Anno') }} (Solo Admin)
        </h2>
    </x-slot>

    <div class="card shadow mb-4">
        <div class="card-header bg-dark text-white">
            Filtro Anno
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.reports.costOfLabor') }}" class="row g-3 align-items-end">
                <div class="col-auto">
                    <label for="year" class="form-label">Seleziona Anno</label>
                    <select name="year" id="year" class="form-select">
                        @for ($i = now()->year; $i >= now()->year - 5; $i--)
                            <option value="{{ $i }}"
                                {{ request('year', now()->year) == $i ? 'selected' : '' }}>{{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Filtra</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            Riepilogo Costo del Lavoro per l'anno {{ request('year', now()->year) }}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-end">
                    <thead class="table-light">
                        <tr>
                            <th class="text-start">Mese</th>
                            <th>Stipendi Base (€)</th>
                            <th>Straordinari (€)</th>
                            <th>Premi (€)</th>
                            <th>Ritenute/Contributi (€)</th>
                            <th>Costo Netto Totale (€)</th>
                        </tr>
                    </thead>
                    <tbody>
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
                            $totals = ['base' => 0, 'overtime' => 0, 'bonus' => 0, 'net' => 0];
                        @endphp

                        @foreach ($monthlyCost as $monthNum => $data)
                            @php
                                $deductions =
                                    $data['total_base_salary'] +
                                    $data['total_overtime_pay'] +
                                    $data['total_bonus'] -
                                    $data['total_net_pay'];

                                $totals['base'] += $data['total_base_salary'];
                                $totals['overtime'] += $data['total_overtime_pay'];
                                $totals['bonus'] += $data['total_bonus'];
                                $totals['net'] += $data['total_net_pay'];
                            @endphp
                            <tr>
                                <td class="text-start">{{ $months[$monthNum] }}</td>
                                <td>{{ number_format($data['total_base_salary'], 2, ',', '.') }}</td>
                                <td>{{ number_format($data['total_overtime_pay'], 2, ',', '.') }}</td>
                                <td>{{ number_format($data['total_bonus'], 2, ',', '.') }}</td>
                                <td class="text-danger">{{ number_format($deductions, 2, ',', '.') }}</td>
                                <td class="fw-bold">{{ number_format($data['total_net_pay'], 2, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="table-success fw-bold">
                            <td class="text-start">Totale Anno {{ request('year', now()->year) }}</td>
                            <td>{{ number_format($totals['base'], 2, ',', '.') }}</td>
                            <td>{{ number_format($totals['overtime'], 2, ',', '.') }}</td>
                            <td>{{ number_format($totals['bonus'], 2, ',', '.') }}</td>
                            <td>{{ number_format($totals['base'] + $totals['overtime'] + $totals['bonus'] - $totals['net'], 2, ',', '.') }}
                            </td>
                            <td>{{ number_format($totals['net'], 2, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
