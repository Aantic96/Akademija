<?php

namespace Core\Traits;

use Core\Connection;
use Core\Model;

trait HasTimestamps
{
    public function setCreatedTimestamps(): void
    {
        $date = new \DateTime();
        $date = $date->format('Y-m-d H:i:s');
        $this->created_at = $date;
        $this->updated_at = $date;
    }

    public function setUpdatedTimestamps(): void
    {
        $date = new \DateTime();
        $date = $date->format('Y-m-d H:i:s');
        $this->updated_at = $date;
    }
}