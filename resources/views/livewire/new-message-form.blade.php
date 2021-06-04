<div>
    <div>
        <h1 class="my-3 text-3xl font-bold text-gray-700">New SMS Message</h1>
    </div>
    <div class="my-7">
        <form wire:submit.prevent="submit">
            <div class="mb-6">
                <label for="phone" class="block text-sm mb-2 text-gray-600">Phone Number (Use a verified caller ID if using Twilio free trial).</label>
                <input wire:model.lazy="phone" type="tel" name="phone" placeholder="Format: +447123456789" class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-emerald-100 focus:border-emerald-300" required/>
                @error('phone')
                    <div class="w-full text-red-600">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-6">
                <label for="body" class="block mb-2 text-sm text-gray-600">Your Message</label>
                <textarea wire:model.debounce.300ms="body" rows="5" name="body" placeholder="Type your message here..." class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-emerald-100 focus:border-emerald-300" required></textarea>
                @error('body')
                    <div class="w-full text-red-600">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-6">
                <button type="submit" class="w-full px-3 py-4 text-lg text-white font-bold bg-emerald-500 rounded-md focus:bg-emerald-700 focus:outline-none uppercase tracking-widest hover:bg-emerald-600">Send Message</button>
            </div>
            <p class="text-base text-center text-gray-400" id="result">
            </p>
        </form>
    </div>
    @if (session()->has('success'))
        <div class="px-4 py-2 text-xl bg-emerald-200 rounded-md">
            <p class="text-gray-700">{{ session('success') }}</p>
        </div>
    @elseif (session()->has('error'))
        <div class="px-4 py-2 text-xl bg-red-200 rounded-md">
            <p class="text-gray-700">{{ session('error') }}</p>
        </div>
    @endif
</div>