<?php

namespace app;

use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class CarModel extends Model
{
    //

    protected $table = 'model';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public static function getTableName()
    {
        return (new static)->getTable();
    }

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function vendor()
    {
        return $this->belongsTo('App\Vendor');
    }

}
