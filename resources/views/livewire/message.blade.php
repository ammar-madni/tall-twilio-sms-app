<div class="space-y-6">
    @if ($messages->count())
        @foreach ($messages as $message)
            <div class="bg-white max-w-xl mx-auto overflow-hidden shadow-sm sm:rounded-lg" wire:key="{{ $message->id }}" wire:poll.1000ms>
                <div class="px-6 bg-white border-b border-gray-200">
                    <div class="divide-y">
                        <div class="flex justify-between items-center py-4">
                            <p class="font-bold text-gray-700">
                                {{ $message->user->name }}
                            </p>
                            @if ($message->status == 'sent'||$message->status == 'delivered')
                                <p class="px-3 py-1 bg-emerald-500 text-sm tracking-widest uppercase text-gray-100 rounded">{{ $message->status }}</p>
                            @elseif ($message->status == 'failed'||$message->status == 'undelivered')
                                <p class="px-3 py-1 bg-red-500 text-sm tracking-widest uppercase text-gray-100 rounded" >{{ $message->status }}</p>        
                            @else
                                <p class="px-3 py-1 bg-gray-900 text-sm tracking-widest uppercase text-gray-100 rounded">{{ $message->status }}</p>
                            @endif
                        </div>
                        <div class="flex flex-col">
                            <div class="flex justify-between items-center py-4">
                                <span class="text-sm test-gray-500">
                                    To: {{ $message->phone }}
                                </span>
                                <span class="text-sm test-gray-500">
                                    {{ $message->created_at }}
                                </span>
                            </div>
                            <div class="">
                                <p class="py-4 text-gray-600">"{{ $message->body }}"</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        {{ $messages->links('custom-pagination') }}
    @else
        <div class="w-full text-center">
            <p class="text-gray-600">
                You have no sent messages.
                <a href="{{ route('new-message') }}" class="text-emerald-500">Send a message?</a> 
            </p>
        </div>
    @endif
</div>