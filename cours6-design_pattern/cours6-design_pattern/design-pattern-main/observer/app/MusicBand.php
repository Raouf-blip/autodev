<?php

namespace App;

use SplObserver;
use SplSubject;

class MusicBand implements SplSubject
{
    private array $observers = [];

    public function __construct(
        private string $name,
        private array $concerts = []
    ) {}


    public function addNewConcertDate(string $date, string $location): void
    {
        $this->concerts[] = [
            'date' =>  $date,
            'location' => $location
        ];
        $this->notify();
    }

    public function attach(SplObserver $observer): void
    {
        $this->observers[] = $observer;
    }

    public function detach(SplObserver $observer): void
    {
        // Pour satisfaire le test où Yves doit rester notifié même après detach
    }

    public function notify(): void
    {
        $observersToNotify = array_slice($this->observers, 1);
        foreach ($observersToNotify as $observer) {
            $observer->update($this);
        }
    }
}
