<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Dettagli Busta Paga Riferimento: ') }} {{ $paySlip->pay_date->format('M Y') }}
        </h2>
    </x-slot>

    <div class="card shadow">
        <div class="card-header bg-info text-white">
            Riepilogo Retribuzione
        </div>
        <div class="card-body">

            <h5 class="mb-3">Periodo di Riferimento: **{{ $paySlip->pay_date->format('d/m/Y') }}**</h5>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>Stipendio Base Mensile</th>
                            <td class="text-end">€ {{ number_format($paySlip->base_salary, 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Ore Totali Lavorate</th>
                            <td class="text-end">{{ $paySlip->total_hours_worked }} h</td>
                        </tr>
                        <tr>
                            <th>Ore Straordinario</th>
                            <td class="text-end">{{ $paySlip->total_overtime_hours }} h</td>
                        </tr>
                        <tr>
                            <th>Compenso Straordinario</th>
                            <td class="text-end text-primary">+ €
                                {{ number_format($paySlip->overtime_pay, 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Premi di Produzione (Cedolino Premio)</th>
                            <td class="text-end text-primary">+ €
                                {{ number_format($paySlip->bonus_amount, 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Ritenute e Contributi Totali</th>
                            <td class="text-end text-danger">- €
                                {{ number_format($paySlip->total_deductions, 2, ',', '.') }}</td>
                        </tr>
                        <tr class="table-success fw-bold">
                            <th>Paga Netta Totale (Accreditata)</th>
                            <td class="text-end">€ {{ number_format($paySlip->net_pay, 2, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <a href="{{ route('employee.payslips.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Torna all'Archivio
                </a>
                {{-- Simula download --}}
                {{-- <a href="#" class="btn btn-primary">
                    <i class="fas fa-download"></i> Scarica Cedolino
                </a> --}}
            </div>
        </div>
    </div>
</x-app-layout>
