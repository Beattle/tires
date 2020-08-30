<?php

namespace app;

use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;
class Tires extends Model
{
    //

    protected $table = 'tires';
    protected $primaryKey = 'id';

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
        return $this->belongsTo('App\Vendor','vendor_id');
    }

    public function model()
    {
        return $this->belongsTo('App\CarModel','model_id');
    }
}
