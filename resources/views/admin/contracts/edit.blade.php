<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crea Nuova Tipologia Contratto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                <form method="POST" action="{{ route('admin.contracts.store') }}">
                    @csrf

                    <div class="space-y-6">
                        <div>
                            <x-label for="name" :value="__('Nome Tipologia Contratto (es. Tempo Indeterminato)')" />
                            <x-input id="name" class="block mt-1 w-full" type="text" name="name"
                                :value="old('name')" required autofocus />
                            @error('name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <x-label for="daily_hours" :value="__('Ore di Lavoro Giornaliere')" />
                            <x-input id="daily_hours" class="block mt-1 w-full" type="number" name="daily_hours"
                                :value="old('daily_hours')" required min="1" max="24" />
                            @error('daily_hours')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <x-label for="pause_minutes" :value="__('Minuti di Pausa Giornaliera')" />
                            <x-input id="pause_minutes" class="block mt-1 w-full" type="number" name="pause_minutes"
                                :value="old('pause_minutes')" required min="0" />
                            @error('pause_minutes')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <x-label for="vacation_days_per_year" :value="__('Giorni di Ferie Annuali')" />
                            <x-input id="vacation_days_per_year" class="block mt-1 w-full" type="number"
                                name="vacation_days_per_year" :value="old('vacation_days_per_year')" required min="0" />
                            @error('vacation_days_per_year')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4 bg-blue-600 hover:bg-blue-700">
                                {{ __('Crea Contratto Tipo') }}
                            </x-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
