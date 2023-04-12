<?php

namespace App\Models;

use Core\Model;
use Core\Traits\SoftDelete;
use Core\Traits\HasTimestamps;

class Blog extends Model
{
    use HasTimestamps,
        SoftDelete;
}