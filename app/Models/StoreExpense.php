<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class StoreExpense extends Model
{

    use HasFactory;


    protected $table = 'store_expense';

    public function subCategory()
    {
        return $this->hasMany(SubCategory::class, 'maincategory_id');
    }

    
}
