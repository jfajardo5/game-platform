<x-app-layout>
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex flex-col justify-center overflow-hidden bg-white shadow-xl sm:rounded-lg">
            <h1 class="p-8 text-4xl text-center">Welcome!</h1>
            <div class="">
                <a href="{{ route('play') }}">Play!</a>
                <a href="/leaderboard">View Leaderboard</a>
            </div>
        </div>
    </div>
</x-app-layout>
