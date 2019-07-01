<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Balances extends Model
{

    public $timestamps = false;
    
    public function deposit (float $value) : Array {

        $this->amount += number_format ($value, 2, '.','');
        $deposit = $this->save();

        if ($deposit) 
            return [
                'sucess'    => true,
                'message'   => 'Recarga feita com sucesso'
            ];
        
        return [
            'sucess'    => false,
            'message'   => 'Não foi possível realizar a recarga'
        ];
    }
}
