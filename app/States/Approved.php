<?php

namespace App\States;

class Approved extends DatabaseState
{
    public function status(): string
    {
        return 'approved';
    }
}
