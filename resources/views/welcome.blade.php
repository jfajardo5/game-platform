<x-guest-layout>
    <div class="flex flex-col justify-center items-center">
        <img src="{{ mix('images/welcome-logo.png') }}" class="p-12 md:p-32 animate__animated animate__infinite animate__tada animate__slower">
        <div x-data="welcome()" class="flex flex-row flex-wrap space-around items-center justify-center">
            <button @click="login()" @mouseover="loginHover = true" @mouseover.away="loginHover = false" :class="{'animate__animated animate__infinite animate__pulse relative bg-gray-800 text-white p-3 m-2 px-14 rounded text-xl font-bold overflow-hidden' : loginHover, 'relative bg-gray-800 text-white p-3 m-2 px-14 rounded text-xl font-bold overflow-hidden' : !loginHover}">
                Log In
            </button>
            <button @click="register()" @mouseover="registerHover = true" @mouseover.away="registerHover = false" :class="{'animate__animated animate__infinite animate__pulse relative bg-gray-800 text-white p-3 m-2 px-12 rounded text-xl font-bold overflow-hidden' : registerHover, 'relative bg-gray-800 text-white p-3 m-2 px-12 rounded text-xl font-bold overflow-hidden' : !registerHover}">
                Register 
                <div class="ribbon bg-red-500 text-sm whitespace-no-wrap px-2">Free!</div>
            </button>
        </div>
    </div>
    <script>
        function welcome() {
            return {
                loginHover: false,
                registerHover: false,
                login() { window.location.href = '{{ route('login') }}' },
                register() { window.location.href = '{{ route('register') }}' },
            }
        }
    </script>
</x-guest-layout>
