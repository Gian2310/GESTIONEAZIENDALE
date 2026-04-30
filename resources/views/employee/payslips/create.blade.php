<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Carica Busta Paga / Dati Salariali') }}
        </h2>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                {{-- Card Header standardizzato: bg-dark text-white --}}
                <div class="card-header bg-dark text-white">
                    Inserimento Dati Pagamento
                </div>
                <div class="card-body">

                    <form action="{{ route('admin.payslips.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            {{-- 1. Selezione Dipendente --}}
                            <div class="col-md-6 mb-3">
                                <label for="user_id" class="form-label">Dipendente</label>
                                <select class="form-select @error('user_id') is-invalid @enderror" id="user_id"
                                    name="user_id" required>
                                    <option value="" disabled selected>Seleziona un dipendente</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}"
                                            {{ old('user_id') == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->surname }} {{ $employee->name }} (ID: {{ $employee->id }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- 2. Data di Pagamento --}}
                            <div class="col-md-6 mb-3">
                                <label for="pay_date" class="form-label">Data di Pagamento (Effettiva)</label>
                                <input type="date" class="form-control @error('pay_date') is-invalid @enderror"
                                    id="pay_date" name="pay_date" value="{{ old('pay_date', date('Y-m-d')) }}"
                                    required>
                                @error('pay_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <h5 class="mt-4 mb-3 text-primary">Dettagli Salariali</h5>

                        <div class="row">
                            {{-- 3. Salario Base --}}
                            <div class="col-md-4 mb-3">
                                <label for="base_salary" class="form-label">Salario Base (€)</label>
                                <input type="number" step="0.01"
                                    class="form-control @error('base_salary') is-invalid @enderror" id="base_salary"
                                    name="base_salary" value="{{ old('base_salary') }}" required min="0">
                                @error('base_salary')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- 4. Ore Lavorate --}}
                            <div class="col-md-4 mb-3">
                                <label for="total_hours_worked" class="form-label">Ore Totali Lavorate</label>
                                <input type="number" step="0.1"
                                    class="form-control @error('total_hours_worked') is-invalid @enderror"
                                    id="total_hours_worked" name="total_hours_worked"
                                    value="{{ old('total_hours_worked') }}" required min="0">
                                @error('total_hours_worked')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- 5. Ore Straordinario --}}
                            <div class="col-md-4 mb-3">
                                <label for="total_overtime_hours" class="form-label">Ore Straordinario</label>
                                <input type="number" step="0.1"
                                    class="form-control @error('total_overtime_hours') is-invalid @enderror"
                                    id="total_overtime_hours" name="total_overtime_hours"
                                    value="{{ old('total_overtime_hours', 0) }}" min="0">
                                @error('total_overtime_hours')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <h5 class="mt-4 mb-3 text-success">Guadagni Aggiuntivi</h5>

                        <div class="row">
                            {{-- 6. Paga Straordinario --}}
                            <div class="col-md-6 mb-3">
                                <label for="overtime_pay" class="form-label">Paga Straordinario Netta (€)</label>
                                <input type="number" step="0.01"
                                    class="form-control @error('overtime_pay') is-invalid @enderror" id="overtime_pay"
                                    name="overtime_pay" value="{{ old('overtime_pay', 0) }}" min="0">
                                @error('overtime_pay')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- 7. Bonus / Premi --}}
                            <div class="col-md-6 mb-3">
                                <label for="bonus_amount" class="form-label">Bonus/Premio Netto (€)</label>
                                <input type="number" step="0.01"
                                    class="form-control @error('bonus_amount') is-invalid @enderror" id="bonus_amount"
                                    name="bonus_amount" value="{{ old('bonus_amount', 0) }}" min="0">
                                @error('bonus_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <h5 class="mt-4 mb-3 text-danger">Detrazioni</h5>

                        {{-- 8. Totale Detrazioni --}}
                        <div class="mb-3">
                            <label for="total_deductions" class="form-label">Totale Detrazioni (€)</label>
                            <input type="number" step="0.01"
                                class="form-control @error('total_deductions') is-invalid @enderror"
                                id="total_deductions" name="total_deductions" value="{{ old('total_deductions', 0) }}"
                                min="0">
                            @error('total_deductions')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <h5 class="mt-4 mb-3 text-info">Pagamento Finale</h5>

                        {{-- 9. Paga Netta Finale (Net Pay) --}}
                        <div class="mb-4">
                            <label for="net_pay" class="form-label">Paga Netta Finale (€)</label>
                            <input type="number" step="0.01"
                                class="form-control form-control-lg @error('net_pay') is-invalid @enderror"
                                id="net_pay" name="net_pay" value="{{ old('net_pay') }}" required min="0">
                            @error('net_pay')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <button type="submit" class="btn btn-success btn-lg w-100">
                            <i class="fas fa-save me-2"></i> Salva Busta Paga
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    {{-- Non è necessario il link a Font Awesome qui se è già nel layout principale --}}
</x-app-layout>
