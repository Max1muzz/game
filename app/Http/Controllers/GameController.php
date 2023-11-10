<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class GameController extends Controller
{
    public function index(): View
    {
        // Get the card from the cache and create another variables
        $card = $this->getCard();
        $score = 0;
        $lives = 3;
        $high_score = $this->getHighScore();

        Cache::put('score', $score);
        Cache::put('lives', $lives);

        return view('game', ['card' => $card, 'score' => $score, 'lives' => $lives, 'high_score' => $high_score]);
    }

    public function command($command)
    {
        // Create all variables
        $lastCard = Cache::get('lastCard');
        $card = $this->getCard();
        $score = Cache::get('score');
        $lives = Cache::get('lives');
        $high_score = $this->getHighScore();

        // Check the command
        if ($command == 'shuffle') {

            // shuffle the cards
            Cache::forget('cards');

            return \redirect()->route('index');

        } else if ($command == 'higher') {
            // compare the cards
            $compare = $this->onNumber($card['value']) > $this->onNumber($lastCard['value']);
        } else if ($command == 'lower') {
            // compare the cards
            $compare = $this->onNumber($card['value']) < $this->onNumber($lastCard['value']);
        } else {
            // if the command is invalid
            return view('game', ['card' => $card, 'result' => 'Invalid command!']);
        }
        // make the score
        if (isset($compare) && $compare) {
            $score++;
            Cache::put('score', $score);
            // check if the score is higher than the high score
            if ($score > $high_score) {
                $high_score = $score;
                Cache::put('high_score', $high_score);
            }

        } else {
            $lives--;
            // check if the lives is 0, you lose
            if ($lives == 0) {
                Cache::forget('cards');

                return view('game', ['card' => $card, 'result' => 'You lose!']);
            }
            Cache::put('lives', $lives);
        }

        return view('game', ['card' => $card, 'score' => $score, 'lives' => $lives, 'high_score' => $high_score]);
    }

    public function getCard(): array
    {
        $cards = Cache::get('cards');
        if (empty($cards)) {
            $cards = $this->GetCards();

            if ($cards == null) {
                return [];
            }
        }
        // Get the first card and put it in the last position
        [$keys] = Arr::divide($cards);
        $card = Arr::pull($cards, $keys[0]);
        $cards = Arr::add($cards, $keys[0], $card);
        // Put it in the cache
        Cache::put('lastCard', $card);
        Cache::put('cards', $cards);

        return $card;
    }

    public function getCards(): array
    {
        // Get the cards from the API
        $response = Http::get('https://higherorlower-api.netlify.app/json');
        if (!empty($response->json())) {
            // Shuffle the cards
            $cards = Arr::shuffle($response->json());
            Cache::put('cards', $cards);
        } else {
            $cards = null;
        }

        return $cards;
    }

    // Convert the value of the card to number
    public function onNumber($value): int
    {
        if ($value == 'A') {
            return 1;
        } else if ($value == 'jack') {
            return 11;
        } else if ($value == 'queen') {
            return 12;
        } else if ($value == 'king') {
            return 13;
        } else {
            return $value;
        }
    }

    public function getHighScore(): int
    {
        $high_score = Cache::get('high_score');
        if (empty($high_score)) {
            $high_score = 0;
            Cache::put('high_score', $high_score);
        }

        return $high_score;
    }
}
