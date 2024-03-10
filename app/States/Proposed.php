<?php

namespace App\States;

class Proposed extends DatabaseState
{
    public function status(): string
    {
        return 'proposed';
    }
}
