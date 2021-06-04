<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Messages') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-6">
                @if ($messages->count())
                    @foreach ($messages as $message)
                        <livewire:message :message="$message" :wire:key="$message->id"/>
                    @endforeach
                    {{ $messages->links() }}
                @else
                    <div class="w-full text-center">
                        <p class="text-gray-600">
                            You have no sent messages.
                            <a href="{{ route('new-message') }}" class="text-emerald-500">Send a message?</a> 
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>