<?php

namespace Core\Traits;

trait SoftDelete
{
    public function softDelete()
    {
        $date = new \DateTime();
        $date = $date->format('Y-m-d H:i:s');
        $this->deleted_at = $date;
    }

}