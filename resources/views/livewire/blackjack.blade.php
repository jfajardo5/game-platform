<div x-data="frontEndLogic()" class="py-4">
    <div class="mx-auto overflow-hidden bg-white shadow-xl max-w-7xl sm:px-6 lg:px-8 sm:rounded-lg">
        <div>
            <span>{{ $flashMessage }}</span>
        </div>
        <div class="flex flex-row items-center justify-between">
            <span>Dealer Score: {{ $dealerScore }} pts</span>
            <span x-show="rounds > 0" class="animate__animated animate__fadeIn">Rounds: {{ $rounds }}</span>
            <span>Player Score: {{ $playerScore }} pts</span>
        </div>
        <div class="flex flex-row items-center justify-center">
            @foreach($dealerCards as $card)
                <div class="flex flex-col items-center justify-center text-center animate__animated animate__fadeIn">
                    <span class="text-lg">{{ $card->name . ' of ' . $card->group }}</span>
                    <img src="{{ $card->image_url }}" class="w-40">
                </div>
            @endforeach
        </div>
        <div class="flex flex-row items-center justify-center">
            @foreach($playerCards as $card)
                <div class="flex flex-col items-center justify-center text-center animate__animated animate__fadeIn">
                    <span class="text-lg">{{ $card->name . ' of ' . $card->group }}</span>
                    <img src="{{ $card->image_url }}" class="w-40">
                </div>
            @endforeach
        </div>
        <div class="flex flex-row items-center justify-center">
            <button x-bind:disabled="gameRunning" x-show="!gameIsOver" wire:click="hitRound()">Hit!</button>
            <button x-bind:disabled="gameRunning" x-show="rounds > 0 && !gameIsOver" wire:click="stand()">Stand</button>
            <button wire:click="mount()">Play Again!</button>
        </div>
    </div>
    <script>
        function frontEndLogic() {
            return {
                rounds: @entangle('rounds'),
                gameRunning: @entangle('gameRunning'),
                gameIsOver: @entangle('gameIsOver'),
            }
        }
    </script>
</div>

