<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Message') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white max-w-xl mx-auto overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 lg:p-12 bg-white border-b border-gray-200">
                    <livewire:new-message-form />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
