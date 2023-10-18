<?php

namespace App\Models;

use DateTimeInterface;
use Jenssegers\Mongodb\Eloquent\Model;

class BaseMongoModel extends Model
{
    protected $connection = 'mongodb';

   /**
     * Prepare a date for array / JSON serialization.
     *
     * @param DateTimeInterface $date
     * @return string
     */
     protected function serializeDate( DateTimeInterface $date )
    {
        return $date->format( 'Y-m-d H:i:s' );
    }
}
