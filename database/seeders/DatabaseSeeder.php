<?php

namespace Database\Seeders;

use Storage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\PlayingCard;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $cards = $this->getCards();
        foreach($cards as $card) {
            PlayingCard::create($card);
        }
    }

    public function getCards()
    {
        $files = Storage::disk('static')->files('/images/cards');
        foreach($files as $file) 
        {
            $cards[] = [
                'image_url' => "/$file",
                'name' => $this->parseCardName($file),
                'group' => $this->parseCardGroup($file),
                'value' => $this->parseCardValue($file),
            ];
        }
        return $cards;
    }

    public function parseCardName($file)
    {
        $filename = str_replace(["images/cards/", ".png"],"", $file);
        if(Str::contains($filename, ['J', 'Q', 'K', 'A'])) {
            switch($filename[0]) {
                case "J":
                    return 'Jack';
                case "Q":
                    return 'Queen';
                case "K":
                    return 'King';
                case "A":
                    return 'Ace';
            }
        }
        return filter_var($filename, FILTER_SANITIZE_NUMBER_INT);
    }

    public function parseCardGroup($file)
    {
        $filename = str_replace(["images/cards/", ".png"],"", $file);
        if(Str::contains($filename, 'C')) {
            return 'Clubs';
        } elseif(Str::contains($filename, 'D')) {
            return 'Diamonds';
        } elseif(Str::contains($filename, 'H')) {
            return 'Hearts';
        }
        return 'Swords';
    }

    public function parseCardValue($file)
    {
        $filename = str_replace(["images/cards/", ".png"],"", $file);
        if(Str::contains($filename, ['J', 'Q', 'K', 'A'])) {
            if($filename[0] == "A") {
                return 'ace';
            }
            return 10;
        }
        return filter_var($filename, FILTER_SANITIZE_NUMBER_INT);
    }
}
