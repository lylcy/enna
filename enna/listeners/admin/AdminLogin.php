<?php


namespace enna\listeners\admin;


use enna\interfaces\ListenerInterface;

class AdminLogin implements ListenerInterface
{
    public function handle($event): void
    {
        [$admin, $token] = $event;
    }

}