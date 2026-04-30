<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0 text-gray-800">
            {{ __('Modifica Dipendente') }}: {{ $employee->first_name }} {{ $employee->last_name }}
        </h2>
    </x-slot>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    {{ __('Dettagli del Dipendente') }}
                </div>
                <div class="card-body">
                    {{-- Form per l'aggiornamento dei dati del dipendente. 
                         Usa il metodo PUT/PATCH per l'aggiornamento. --}}
                    <form action="{{ route('admin.employees.update', $employee) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Sezione Dati Personali --}}
                        <fieldset class="mb-4 p-3 border rounded">
                            <legend class="float-none w-auto px-2 fs-6">{{ __('Dati Personali') }}</legend>
                            <div class="row g-3">
                                {{-- Nome --}}
                                <div class="col-md-6">
                                    <label for="first_name" class="form-label">{{ __('Nome') }}</label>
                                    <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                        id="first_name" name="first_name"
                                        value="{{ old('first_name', $employee->first_name) }}" required>
                                    @error('first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Cognome --}}
                                <div class="col-md-6">
                                    <label for="last_name" class="form-label">{{ __('Cognome') }}</label>
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                        id="last_name" name="last_name"
                                        value="{{ old('last_name', $employee->last_name) }}" required>
                                    @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row g-3 mt-1">
                                {{-- Email --}}
                                <div class="col-md-6">
                                    <label for="email" class="form-label">{{ __('Email') }}</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email', $employee->email) }}"
                                        required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Data di Nascita (Esempio) --}}
                                <div class="col-md-6">
                                    <label for="date_of_birth" class="form-label">{{ __('Data di Nascita') }}</label>
                                    <input type="date"
                                        class="form-control @error('date_of_birth') is-invalid @enderror"
                                        id="date_of_birth" name="date_of_birth"
                                        value="{{ old('date_of_birth', optional($employee->date_of_birth)->format('Y-m-d')) }}">
                                    @error('date_of_birth')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </fieldset>

                        {{-- Sezione Dati Aziendali --}}
                        <fieldset class="mb-4 p-3 border rounded">
                            <legend class="float-none w-auto px-2 fs-6">{{ __('Ruolo e Reparto') }}</legend>
                            <div class="row g-3">
                                {{-- Ruolo --}}
                                <div class="col-md-6">
                                    <label for="role" class="form-label">{{ __('Ruolo') }}</label>
                                    <select id="role" name="role"
                                        class="form-select @error('role') is-invalid @enderror" required>
                                        <option value="employee"
                                            {{ old('role', $employee->role) == 'employee' ? 'selected' : '' }}>
                                            {{ __('Dipendente Standard') }}</option>
                                        <option value="manager"
                                            {{ old('role', $employee->role) == 'manager' ? 'selected' : '' }}>
                                            {{ __('Manager') }}</option>
                                        <option value="admin"
                                            {{ old('role', $employee->role) == 'admin' ? 'selected' : '' }}>
                                            {{ __('Amministratore') }}</option>
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Reparto --}}
                                <div class="col-md-6">
                                    <label for="department_id" class="form-label">{{ __('Reparto') }}</label>
                                    <select id="department_id" name="department_id"
                                        class="form-select @error('department_id') is-invalid @enderror" required>
                                        <option value="">{{ __('Seleziona Reparto') }}</option>
                                        {{-- Assumi che $departments sia passata dal Controller --}}
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}"
                                                {{ old('department_id', $employee->department_id) == $department->id ? 'selected' : '' }}>
                                                {{ $department->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('department_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </fieldset>


                        {{-- Sezione Password (Opzionale) --}}
                        <fieldset class="mb-4 p-3 border rounded">
                            <legend class="float-none w-auto px-2 fs-6">{{ __('Cambia Password (Opzionale)') }}
                            </legend>
                            <p class="text-muted small">Lascia i campi vuoti per mantenere la password attuale.</p>
                            <div class="row g-3">
                                {{-- Nuova Password --}}
                                <div class="col-md-6">
                                    <label for="password" class="form-label">{{ __('Nuova Password') }}</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Conferma Password --}}
                                <div class="col-md-6">
                                    <label for="password_confirmation"
                                        class="form-label">{{ __('Conferma Nuova Password') }}</label>
                                    <input type="password"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        id="password_confirmation" name="password_confirmation">
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </fieldset>


                        {{-- Pulsanti di Azione (Ottimizzati) --}}
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            {{-- Pulsante Annulla/Indietro --}}
                            <a href="{{ route('admin.employees.index') }}" class="btn btn-secondary">
                                <i class="fa-solid fa-circle-xmark me-1"></i> {{ __('Annulla') }}
                            </a>

                            {{-- Pulsante Salva Modifiche --}}
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-floppy-disk me-1"></i> {{ __('Salva Modifiche') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
