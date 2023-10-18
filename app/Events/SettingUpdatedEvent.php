<?php

namespace App\Events;

class SettingUpdatedEvent extends Event
{
    var $key;
    var $data;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct( $key, $data )
    {
        $this->key  = $key;
        $this->data = $data;
    }
}
