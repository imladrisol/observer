<?php

interface SplSubjectI
{
    public function attach(SplObserverI $observer);

    public function detach(SplObserverI $observer);

    public function notify();
}

interface SplObserverI
{
    public function update(SplSubjectI $subject);
}

class Subject implements SplSubjectI
{
    public $is_storm;
    private $observers;

    public function __construct()
    {
        $this->observers = new SplObjectStorage;
    }

    public function attach(SplObserverI $observer): void
    {
        echo "Subject: Attached an observer.\n";
        $this->observers->attach($observer);
    }

    public function detach(SplObserverI $observer): void
    {
        $this->observers->detach($observer);
        echo "Subject: Detached an observer.\n";
    }

    public function notify(): void
    {
        echo "Subject: Notifying observers...\n";
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }

    public function someBusinessLogic(): void
    {
        echo "\nSubject: I'm doing something important.\n";
        $this->is_storm = true;

        echo "Subject: Storm has become\n";
        $this->notify();
    }
}


class School implements SplObserverI
{
    public function update(SplSubjectI $subject): void
    {
        if ($subject->is_storm) {
            echo "School: Reacted to the event.\n";
        }
    }
}

class Airport implements SplObserverI
{
    public function update(SplSubjectI $subject): void
    {
        if ($subject->is_storm) {
            echo "Airport: Reacted to the event.\n";
        }
    }
}

$subject = new Subject;

$o1 = new School;
$subject->attach($o1);

$o2 = new Airport;
$subject->attach($o2);

$subject->someBusinessLogic();

$subject->detach($o2);

$subject->someBusinessLogic();