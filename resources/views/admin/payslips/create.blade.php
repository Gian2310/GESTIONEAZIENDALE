<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Carica Dati Busta Paga Mensile') }}
        </h2>
    </x-slot>

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            Input Dati Mensili
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.payslips.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="user_id" class="form-label">Dipendente</label>
                        <select class="form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id"
                            required>
                            <option value="">Seleziona Dipendente</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}"
                                    {{ old('user_id') == $employee->id ? 'selected' : '' }}>{{ $employee->name }}
                                    ({{ $employee->fiscal_code }})</option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="pay_date" class="form-label">Mese Riferimento / Data Pagamento</label>
                        <input type="date" class="form-control @error('pay_date') is-invalid @enderror"
                            id="pay_date" name="pay_date" value="{{ old('pay_date', now()->format('Y-m-d')) }}"
                            required>
                        @error('pay_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <h5 class="mt-4">Dettagli Retributivi</h5>

                    <div class="col-md-4">
                        <label for="base_salary" class="form-label">Stipendio Base Lordo (€)</label>
                        <input type="number" step="0.01"
                            class="form-control @error('base_salary') is-invalid @enderror" id="base_salary"
                            name="base_salary" value="{{ old('base_salary') }}" required>
                        @error('base_salary')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="total_hours_worked" class="form-label">Ore Totali Lavorate</label>
                        <input type="number" step="0.01"
                            class="form-control @error('total_hours_worked') is-invalid @enderror"
                            id="total_hours_worked" name="total_hours_worked" value="{{ old('total_hours_worked') }}"
                            required>
                        @error('total_hours_worked')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="total_overtime_hours" class="form-label">Ore Straordinario</label>
                        <input type="number" step="0.01"
                            class="form-control @error('total_overtime_hours') is-invalid @enderror"
                            id="total_overtime_hours" name="total_overtime_hours"
                            value="{{ old('total_overtime_hours', 0) }}">
                        @error('total_overtime_hours')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="overtime_pay" class="form-label">Compenso Straordinario (€)</label>
                        <input type="number" step="0.01"
                            class="form-control @error('overtime_pay') is-invalid @enderror" id="overtime_pay"
                            name="overtime_pay" value="{{ old('overtime_pay', 0) }}">
                        @error('overtime_pay')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="bonus_amount" class="form-label">Premi di Produzione (€)</label>
                        <input type="number" step="0.01"
                            class="form-control @error('bonus_amount') is-invalid @enderror" id="bonus_amount"
                            name="bonus_amount" value="{{ old('bonus_amount', 0) }}">
                        @error('bonus_amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="total_deductions" class="form-label">Ritenute/Contributi Totali (€)</label>
                        <input type="number" step="0.01"
                            class="form-control @error('total_deductions') is-invalid @enderror" id="total_deductions"
                            name="total_deductions" value="{{ old('total_deductions', 0) }}">
                        @error('total_deductions')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="net_pay" class="form-label">Paga Netta Finale (€)</label>
                        <input type="number" step="0.01" class="form-control @error('net_pay') is-invalid @enderror"
                            id="net_pay" name="net_pay" value="{{ old('net_pay') }}" required>
                        @error('net_pay')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="payslip_file" class="form-label">Carica Cedolino (Simulato - PDF)</label>
                        <input type="file" class="form-control @error('payslip_file') is-invalid @enderror"
                            id="payslip_file" name="payslip_file">
                        @error('payslip_file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-upload"></i> Carica Busta Paga
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
