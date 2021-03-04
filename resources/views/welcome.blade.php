<x-guest-layout>
    <div class="flex flex-col justify-center items-center">
        <img src="{{ mix('images/welcome-logo.png') }}" class="p-32">
        <div class="flex flex-row space-around">
            <button href="{{ route('login') }}" class='relative bg-gray-800 text-white p-3 m-2 px-14 rounded text-xl font-bold overflow-hidden'>
                Log In
            </button>
            <button href="{{ route('register') }}" class='relative bg-gray-800 text-white p-3 m-2 px-12 rounded text-xl font-bold overflow-hidden'>
                Register 
                <div class="ribbon bg-red-500 text-sm whitespace-no-wrap px-2">Free!</div>
            </button>
        </div>
    </div>
</x-guest-layout>
