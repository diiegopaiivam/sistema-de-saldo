<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class Historic extends Model
{
    protected $fillable = [
        'type',
        'amount',
        'total_before',
        'total_after',
        'user_id_transaction',
        'date'
    ];

    public function type($type = null){

        $types = [
            'I' => 'Entrada',
            'O' => 'Saque',
            'T' => 'Transferência',
        ];

        if (!$types) {
            return $types;
        }

        return $types [$type];
    }

    public function getDateAttribute($value){

        return Carbon::parse($value)->format('d/m/Y');

    }
}
