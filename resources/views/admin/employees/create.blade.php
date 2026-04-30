<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0 text-gray-800">
            {{ __('Aggiungi Nuovo Dipendente') }}
        </h2>
    </x-slot>

    <div class="row">
        <div class="col-lg-10 col-xl-8 mx-auto">
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Dettagli del Nuovo Dipendente</h5>
                </div>
                <div class="card-body">
                    {{-- Form di Creazione Dipendente --}}
                    <form method="POST" action="{{ route('admin.employees.store') }}">
                        @csrf

                        {{-- SEZIONE 1: Informazioni Personali Base --}}
                        <h6 class="border-bottom pb-2 mb-3 mt-4 text-primary">Informazioni Anagrafiche</h6>
                        <div class="row g-3">
                            {{-- Nome --}}
                            <div class="col-md-6">
                                <label for="first_name" class="form-label">Nome *</label>
                                <input id="first_name" type="text" name="first_name"
                                    class="form-control @error('first_name') is-invalid @enderror"
                                    value="{{ old('first_name') }}" required autofocus>
                                @error('first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Cognome --}}
                            <div class="col-md-6">
                                <label for="last_name" class="form-label">Cognome *</label>
                                <input id="last_name" type="text" name="last_name"
                                    class="form-control @error('last_name') is-invalid @enderror"
                                    value="{{ old('last_name') }}" required>
                                @error('last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Codice Fiscale --}}
                            <div class="col-md-6">
                                <label for="fiscal_code" class="form-label">Codice Fiscale *</label>
                                <input id="fiscal_code" type="text" name="fiscal_code"
                                    class="form-control @error('fiscal_code') is-invalid @enderror"
                                    value="{{ old('fiscal_code') }}" required maxlength="16">
                                @error('fiscal_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Data di Assunzione --}}
                            <div class="col-md-6">
                                <label for="hiring_date" class="form-label">Data di Assunzione *</label>
                                <input id="hiring_date" type="date" name="hiring_date"
                                    class="form-control @error('hiring_date') is-invalid @enderror"
                                    value="{{ old('hiring_date') }}" required>
                                @error('hiring_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- SEZIONE 2: Credenziali e Ruolo --}}
                        <h6 class="border-bottom pb-2 mb-3 mt-4 text-primary">Accesso e Ruolo</h6>
                        <div class="row g-3">
                            {{-- Email --}}
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email *</label>
                                <input id="email" type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div class="col-md-6">
                                <label for="password" class="form-label">Password *</label>
                                <input id="password" type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror" required
                                    autocomplete="new-password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Password Confirmation (Necessaria per 'password|confirmed' nel controller) --}}
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">Conferma Password *</label>
                                <input id="password_confirmation" type="password" name="password_confirmation"
                                    class="form-control" required autocomplete="new-password">
                            </div>

                            {{-- Ruolo --}}
                            <div class="col-md-6">
                                <label for="role" class="form-label">Ruolo *</label>
                                <select id="role" name="role"
                                    class="form-select @error('role') is-invalid @enderror" required>
                                    <option value="" disabled selected>Seleziona un ruolo</option>
                                    <option value="employee" {{ old('role') == 'employee' ? 'selected' : '' }}>
                                        Dipendente</option>
                                    <option value="manager" {{ old('role') == 'manager' ? 'selected' : '' }}>Manager
                                    </option>
                                    {{-- L'Admin non è un ruolo gestibile dalla funzione store del tuo controller ripristinato --}}
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- SEZIONE 3: Dettagli Lavorativi --}}
                        <h6 class="border-bottom pb-2 mb-3 mt-4 text-primary">Dettagli Contratto e Organizzazione</h6>
                        <div class="row g-3">
                            {{-- Reparto --}}
                            <div class="col-md-6">
                                <label for="department_id" class="form-label">Reparto *</label>
                                <select id="department_id" name="department_id"
                                    class="form-select @error('department_id') is-invalid @enderror" required>
                                    <option value="" disabled selected>Seleziona un reparto</option>
                                    {{-- La variabile $departments è passata dal Controller --}}
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}"
                                            {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('department_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tipo di Contratto --}}
                            <div class="col-md-6">
                                <label for="contract_id" class="form-label">Tipo di Contratto *</label>
                                <select id="contract_id" name="contract_id"
                                    class="form-select @error('contract_id') is-invalid @enderror" required>
                                    <option value="" disabled selected>Seleziona un contratto</option>
                                    {{-- La variabile $contracts è passata dal Controller --}}
                                    @foreach ($contracts as $contract)
                                        <option value="{{ $contract->id }}"
                                            {{ old('contract_id') == $contract->id ? 'selected' : '' }}>
                                            {{ $contract->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('contract_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Stipendio Base --}}
                            <div class="col-md-6">
                                <label for="base_salary" class="form-label">Stipendio Base Lordo (Mensile) *</label>
                                <div class="input-group">
                                    <span class="input-group-text">€</span>
                                    <input id="base_salary" type="number" name="base_salary"
                                        class="form-control @error('base_salary') is-invalid @enderror"
                                        value="{{ old('base_salary') }}" required min="0" step="0.01">
                                </div>
                                @error('base_salary')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>


                        {{-- Pulsanti Azione --}}
                        <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                            <a href="{{ route('admin.employees.index') }}" class="btn btn-secondary me-2">Annulla</a>
                            <button type="submit" class="btn btn-primary">
                                Salva Dipendente
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
