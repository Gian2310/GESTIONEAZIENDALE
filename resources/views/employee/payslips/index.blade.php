<x-app-layout>
    <x-slot name="header">
        <h2 class="font-weight-bold text-xl text-gray-800 leading-tight">
            {{ __('Archivio Buste Paga e Premi') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body p-4">

                    <!-- Titolo della sezione -->
                    <h5 class="mb-4 text-lg font-weight-bold text-secondary">Le tue Buste Paga e Premi</h5>

                    <div class="card-body">
                        {{-- Controlla se ci sono buste paga da mostrare --}}
                        @if ($paySlips->isEmpty())
                            {{-- Alert Bootstrap per assenza dati --}}
                            <div class="alert alert-info" role="alert">
                                Non sono state caricate buste paga o premi per il tuo account.
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <thead class="bg-light">
                                        <tr>
                                            <th scope="col">
                                                Data Pagamento
                                            </th>
                                            <th scope="col">
                                                Mese/Anno di Riferimento
                                            </th>
                                            <th scope="col">
                                                Tipo
                                            </th>
                                            <th scope="col">
                                                Azioni
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($paySlips as $payslip)
                                            <tr>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($payslip->pay_date)->format('d/m/Y') }}
                                                </td>
                                                <td>
                                                    {{ $payslip->month . '/' . $payslip->year }}
                                                </td>
                                                <td>
                                                    {{ ucfirst($payslip->type) }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('employee.payslips.show', $payslip->id) }}"
                                                        class="btn btn-sm btn-primary d-inline-flex align-items-center">
                                                        {{-- Icona Eye (Bootstrap Icons) --}}
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" fill="currentColor"
                                                            class="bi bi-eye-fill me-1" viewBox="0 0 16 16">
                                                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                                                            <path
                                                                d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
                                                        </svg>
                                                        Visualizza
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            {{-- Paginazione (Assumendo che $payslips sia un'istanza di Paginator) --}}
                            <div class="mt-4">
                                {{ $paySlips->links('pagination::bootstrap-4') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>
