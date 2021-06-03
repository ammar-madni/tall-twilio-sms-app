<x-default-layout>
    <div class="relative flex items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-900 py-4 sm:pt-0">

        <div class="max-w-6xl mx-auto space-y-14 sm:px-6 lg:px-8">
            <h2 class="text-center text-2xl md:text-4xl lg:text-6xl">Tall Twilio SMS App</h2>
                <div class="flex justify-center space-x-6">
                    @auth
                        <a href="{{ url('/messages') }}" class="inline-flex text-white bg-emerald-500 border-0 py-2 px-6 focus:outline-none hover:bg-emerald-600 rounded text-lg">Sent Messages</a>
                        <a href="{{ url('/new-message') }}" class="inline-flex bg-white text-gray-900 border-0 py-2 px-6 focus:outline-none hover:bg-gray-50 rounded text-lg">New Message</a>
                    @else
                        <a href="{{ url('/login') }}" class="inline-flex text-white bg-emerald-500 border-0 py-2 px-6 focus:outline-none hover:bg-emerald-600 rounded text-lg">Log In</a>
                        <a href="{{ url('/register') }}" class="inline-flex bg-white text-gray-900 border-0 py-2 px-6 focus:outline-none hover:bg-gray-50 rounded text-lg">Register</a>
                    @endauth
                </div>
        </div>
    </div>
</x-default-layout>