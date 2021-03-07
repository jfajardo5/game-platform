<x-app-layout>
    <div x-data="dashboard()" class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex flex-col items-center justify-center overflow-hidden bg-white shadow-xl sm:rounded-lg">
            <a href="{{ route('play') }}">
                <img src="{{ mix('images/dashboard-logo.png') }}" class="p-8">
            </a>
            <button @click="leaderboard()" @mouseover="leaderboardHover = true" @mouseover.away="leaderboardHover = false" :class="{'animate__animated animate__infinite animate__pulse relative bg-gray-800 text-white p-3 m-2 px-14 rounded text-xl font-bold overflow-hidden my-8' : leaderboardHover, 'relative bg-gray-800 text-white p-3 m-2 px-14 rounded text-xl font-bold overflow-hidden my-8' : !leaderboardHover}">
                View Leaderboard!
            </button>
        </div>
    </div>
    <script>
        function dashboard() {
            return {
                leaderboardHover: false,
                leaderboard() { window.location.href = '{{ route('leaderboard') }}' }
            }
        }
    </script>
</x-app-layout>
