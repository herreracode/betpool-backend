<?php

namespace App\Models\Common\Traits;


trait HasTimestamp
{

    public function getCreateAt()
    {

        return $this->{static::CREATED_AT};
    }

    public function getUpdateAt()
    {

        return $this->{static::CREATED_AT};
    }

}
