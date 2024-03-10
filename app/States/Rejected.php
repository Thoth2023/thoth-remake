<?php

namespace App\States;

class Rejected extends DatabaseState
{
    public function status(): string
    {
        return 'rejected';
    }
}
