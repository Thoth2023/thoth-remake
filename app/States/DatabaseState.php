<?php

namespace App\States;

use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class DatabaseState extends State
{
    abstract public function status(): string;

    /**
     * @return StateConfig
     */
    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Proposed::class)
            ->allowTransition(Proposed::class, Approved::class)
            ->allowTransition(Proposed::class, Rejected::class)
            ->allowTransition(Approved::class, Ready::class);
    }
}
