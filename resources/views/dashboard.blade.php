<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col justify-center bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <h1 class="text-4xl text-center p-8">Welcome!</h1>
                <div class="">
                    <a href="{{ route('play') }}">Play!</a>
                    <a href="/leaderboard">View Leaderboard</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
