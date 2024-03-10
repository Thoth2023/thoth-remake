<?php

namespace App\States;

use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

/**
 * Represents the base class for database states.
 */
abstract class DatabaseState extends State
{
    /**
     * Get the status of the state.
     *
     * @return string
     */
    abstract public function status(): string;

    /**
     * Get the state configuration.
     *
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
