<?php

namespace App\States;

class Ready extends DatabaseState
{
    public function status(): string
    {
        return 'ready';
    }
}
