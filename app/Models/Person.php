<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'persons';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'email',
        'name',
        'birth_date',
        'phone',
        'ip',
        'country',
    ];



    /**
     * Filter person data by year or month or both
     * @return string
     *
     */
    public function filterByYearOrMonth(): string
    {
        return 'HELLO';
    }

}
