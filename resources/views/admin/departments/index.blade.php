<x-app-layout>
    <x-slot name="header">
        {{-- Aggiungo il link a Font Awesome qui per assicurarmi che le icone siano caricate --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
            xintegrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />

        <h2 class="h4 mb-0 text-gray-800">
            {{ __('Gestione Reparti Aziendali') }}
        </h2>
    </x-slot>

    <div class="row">
        {{-- COLONNA SINISTRA: Form Aggiunta/Modifica --}}
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header bg-{{ isset($department) ? 'warning' : 'primary' }} text-white">
                    <h6 class="mb-0">
                        <i class="fa-solid fa-building me-1"></i>
                        {{ isset($department) ? 'Modifica Reparto: ' . $department->name : 'Aggiungi Nuovo Reparto' }}
                    </h6>
                </div>
                <div class="card-body">
                    <form method="POST"
                        action="{{ isset($department) ? route('admin.departments.update', $department) : route('admin.departments.store') }}">
                        @csrf
                        @if (isset($department))
                            @method('PUT')
                        @endif

                        {{-- Campo Nome --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Nome Reparto') }}</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                id="name" name="name" value="{{ old('name', $department->name ?? '') }}"
                                required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Campo Descrizione (Aggiunto per completezza) --}}
                        <div class="mb-3">
                            <label for="description" class="form-label">{{ __('Descrizione') }}</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                rows="3">{{ old('description', $department->description ?? '') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Pulsanti Azione --}}
                        <div class="d-flex justify-content-between pt-2">
                            <button type="submit" class="btn btn-{{ isset($department) ? 'warning' : 'primary' }}">
                                <i class="fa-solid fa-floppy-disk me-1"></i>
                                {{ isset($department) ? 'Aggiorna' : 'Salva' }}
                            </button>
                            @if (isset($department))
                                {{-- Link Annulla per pulire il form di modifica --}}
                                <a href="{{ route('admin.departments.index') }}" class="btn btn-secondary">
                                    <i class="fa-solid fa-circle-xmark me-1"></i> {{ __('Annulla Modifica') }}
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- COLONNA DESTRA: Lista Reparti --}}
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0"><i class="fa-solid fa-list-ul me-1"></i> {{ __('Lista Reparti') }}</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">{{ __('ID') }}</th>
                                    <th scope="col">{{ __('Nome') }}</th>
                                    <th scope="col" class="text-center">{{ __('Dipendenti Attivi') }}</th>
                                    <th scope="col" class="text-center">{{ __('Azioni') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($departments as $dept)
                                    @php
                                        // Calcolo robusto del conteggio dei dipendenti
                                        // Usa la proprietà ottimizzata (employees_count) se esiste, altrimenti usa la relazione con l'operatore null-safe.
                                        $employeeCount = $dept->employees_count ?? ($dept->employees?->count() ?? 0);
                                    @endphp
                                    <tr>
                                        <td>{{ $dept->id }}</td>
                                        <td>{{ $dept->name }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-primary">
                                                {{ $employeeCount }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-inline-flex gap-2">
                                                {{-- Pulsante Modifica (Arancione) --}}
                                                <a href="{{ route('admin.departments.edit', $dept) }}"
                                                    class="btn btn-sm btn-warning" title="{{ __('Modifica') }}">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>

                                                {{-- Pulsante Elimina (Rosso) con Modale di Conferma --}}
                                                {{-- Disabilitato se ci sono dipendenti collegati --}}
                                                <button type="button" class="btn btn-sm btn-danger"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteDepartmentModal{{ $dept->id }}"
                                                    title="{{ __('Elimina') }}"
                                                    {{ $employeeCount > 0 ? 'disabled' : '' }}>
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- Modale di Conferma Eliminazione per ogni Reparto --}}
                                    <div class="modal fade" id="deleteDepartmentModal{{ $dept->id }}"
                                        tabindex="-1" aria-labelledby="deleteDepartmentModalLabel{{ $dept->id }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="deleteDepartmentModalLabel{{ $dept->id }}">
                                                        {{ __('Conferma Eliminazione') }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    {{ __('Sei sicuro di voler eliminare il reparto') }}
                                                    <strong>{{ $dept->name }}</strong>?
                                                    <p class="mt-2 text-danger">
                                                        {{ __('Questa azione è irreversibile. L\'eliminazione è consentita solo se il reparto non ha dipendenti associati.') }}
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">{{ __('Annulla') }}</button>
                                                    <form action="{{ route('admin.departments.destroy', $dept) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-danger">{{ __('Elimina Definitivamente') }}</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">{{ __('Nessun reparto registrato.') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{-- Assicurati che $departments sia paginato per usare links() --}}
                        {{ $departments->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
