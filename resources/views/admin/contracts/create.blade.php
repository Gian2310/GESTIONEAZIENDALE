<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifica Reparto: ') . $department->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                <form method="POST" action="{{ route('admin.departments.update', $department) }}">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <div>
                            <x-label for="name" :value="__('Nome Reparto')" />
                            <x-input id="name" class="block mt-1 w-full" type="text" name="name"
                                :value="old('name', $department->name)" required autofocus />
                            @error('name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <x-label for="description" :value="__('Descrizione')" />
                            <textarea id="description" name="description" rows="3"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">{{ old('description', $department->description) }}</textarea>
                            @error('description')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4 bg-green-600 hover:bg-green-700">
                                {{ __('Aggiorna Reparto') }}
                            </x-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
