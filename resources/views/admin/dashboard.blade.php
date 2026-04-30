<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Amministratore') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <h3 class="text-xl font-bold text-blue-600 mb-6">{{ __('Riepilogo HR & Stato Aziendale') }}</h3>

                {{-- STATISTICHE PRINCIPALI --}}
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

                    {{-- Dipendenti Attivi --}}
                    <div class="bg-white p-5 rounded-lg shadow-lg border-l-4 border-blue-500">
                        <p class="text-sm font-medium text-gray-500">{{ __('DIPENDENTI ATTIVI') }}</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($totalEmployees) }}</p>
                    </div>

                    {{-- Assenti Oggi --}}
                    <div class="bg-white p-5 rounded-lg shadow-lg border-l-4 border-red-500">
                        <p class="text-sm font-medium text-gray-500">{{ __('ASSENTI OGGI') }}</p>
                        <p class="text-3xl font-bold text-red-600 mt-1">{{ number_format($absentToday) }}</p>
                    </div>

                    {{-- Contratti in Scadenza --}}
                    <div class="bg-white p-5 rounded-lg shadow-lg border-l-4 border-yellow-500">
                        <p class="text-sm font-medium text-gray-500">{{ __('CONTRATTI IN SCADENZA (30GG)') }}</p>
                        <p class="text-3xl font-bold text-yellow-600 mt-1">{{ number_format($contractsExpiring) }}</p>
                    </div>

                    {{-- Costo del Lavoro Totale (Mensile) --}}
                    <div class="bg-white p-5 rounded-lg shadow-lg border-l-4 border-green-500">
                        <p class="text-sm font-medium text-gray-500">{{ __('COSTO DEL LAVORO TOTALE (MENSILE)') }}</p>
                        <p class="text-3xl font-bold text-green-600 mt-1">€
                            {{ number_format($monthlyCost, 2, ',', '.') }}</p>
                    </div>
                </div>

                {{-- GRAFICI E ULTIME AZIONI --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                    {{-- Grafico: Dipendenti per Reparto --}}
                    <div class="bg-white p-5 rounded-lg shadow-lg">
                        <h4 class="text-lg font-semibold mb-3">{{ __('Dipendenti per Reparto') }}</h4>
                        <canvas id="departmentChart" height="200"></canvas>
                        <p class="text-sm text-gray-500 mt-3">
                            {{ __('Qui puoi visualizzare visivamente come la forza lavoro è distribuita nei vari reparti (es. Sviluppo: 40%, Vendite: 30%, Amministrazione: 20%, ecc.).') }}
                        </p>
                    </div>

                    {{-- Tabella: Ultime Timbrature --}}
                    <div class="bg-white p-5 rounded-lg shadow-lg">
                        <h4 class="text-lg font-semibold mb-3">{{ __('Ultime 5 Timbrature o Eccezioni') }}</h4>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Dipendente') }}</th>
                                        <th scope="col"
                                            class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Data/Ora') }}</th>
                                        <th scope="col"
                                            class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Tipo Evento') }}</th>
                                        <th scope="col"
                                            class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Stato') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($recentTimesheets as $timesheet)
                                        <tr>
                                            <td class="px-3 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $timesheet->user->name ?? 'N/A' }}</td>
                                            <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $timesheet->clock_in->format('d/m/Y H:i') }}</td>
                                            <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $timesheet->clock_out ? __('Uscita') : __('Ingresso') }}
                                            </td>
                                            <td class="px-3 py-4 whitespace-nowrap text-sm">
                                                @php
                                                    $status = $timesheet->status ?? 'Regolare';
                                                    $badgeClass = match ($status) {
                                                        'Regolare' => 'bg-green-100 text-green-800',
                                                        'In Ritardo' => 'bg-yellow-100 text-yellow-800',
                                                        'Uscita Anticipata' => 'bg-red-100 text-red-800',
                                                        default => 'bg-gray-100 text-gray-800',
                                                    };
                                                @endphp
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeClass }}">
                                                    {{ __($status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-3 py-4 text-center text-sm text-gray-500">
                                                {{ __('Nessuna timbratura recente trovata.') }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Script per Chart.js (Grafico a barre) --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chartData = @json($chartData);
            const chartLabels = @json($chartLabels);

            const ctx = document.getElementById('departmentChart').getContext('2d');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: chartLabels,
                    datasets: [{
                        label: 'Dipendenti',
                        data: chartData,
                        backgroundColor: [
                            'rgba(59, 130, 246, 0.6)', // blue
                            'rgba(16, 185, 129, 0.6)', // green
                            'rgba(245, 158, 11, 0.6)', // yellow
                            'rgba(239, 68, 68, 0.6)', // red
                            'rgba(147, 51, 234, 0.6)', // purple
                        ],
                        borderColor: [
                            'rgba(59, 130, 246, 1)',
                            'rgba(16, 185, 129, 1)',
                            'rgba(245, 158, 11, 1)',
                            'rgba(239, 68, 68, 1)',
                            'rgba(147, 51, 234, 1)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Numero di Dipendenti'
                            },
                            // Assicura che le etichette siano numeri interi
                            ticks: {
                                precision: 0
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
