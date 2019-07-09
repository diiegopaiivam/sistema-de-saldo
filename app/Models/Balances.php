<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\User;

class Balances extends Model
{

    public $timestamps = false;
    
    public function deposit (float $value) : Array {

        DB::beginTransaction();

        $totalBefore = $this->amount ? $this->amount : 0;
        $this->amount += number_format ($value, 2, '.','');
        $deposit = $this->save();

        $historic = auth()->user()->historics()->create([
            'type'          => 'I',
            'amount'        => $value,
            'total_before'  => $totalBefore,
            'total_after'   => $this->amount,
            'date'          => date('Ymd'),
        ]);

        if ($deposit && $historic) {

            DB::commit();

            return [
                'sucess'    => true,
                'message'   => 'Recarga feita com sucesso'
            ];
        } else {

            DB::rollback();
            return [
                'sucess'    => false,
                'message'   => 'Não foi possível realizar a recarga'
            ];
        }
    }

    public function withdrawn (float $value) : Array {

        if ($this->amount < $value) 
            return[
                'success' => false,
                'message' => 'Saldo Insuficiente',
            ];

        DB::beginTransaction();

        $totalBefore = $this->amount ? $this->amount : 0;
        $this->amount -= number_format ($value, 2, '.','');
        $withdrawn = $this->save();

        $historic = auth()->user()->historics()->create([
            'type'          => 'O',
            'amount'        => $value,
            'total_before'  => $totalBefore,
            'total_after'   => $this->amount,
            'date'          => date('Ymd'),
        ]);

        if ($withdrawn && $historic) {

            DB::commit();

            return [
                'sucess'    => true,
                'message'   => 'Saque feito com sucesso!'
            ];
        } else {

            DB::rollback();
            return [
                'sucess'    => false,
                'message'   => 'Não foi possível realizar o saque'
            ];
        }
    }

    public function transfer(float $value, $sender): Array {

        if ($this->amount < $value) 
            return[
                'success' => false,
                'message' => 'Saldo Insuficiente',
            ];

        DB::beginTransaction();

        /*Atualiza o proprio saldo*/

        $totalBefore = $this->amount ? $this->amount : 0;
        $this->amount -= number_format ($value, 2, '.','');
        $transfer = $this->save();

        $historic = auth()->user()->historics()->create([
            'type'                  => 'T',
            'amount'                => $value,
            'total_before'          => $totalBefore,
            'total_after'           => $this->amount,
            'date'                  => date('Ymd'),
            'user_id_transaction'   => $sender->id,
        ]);
        
        /*Atualiza o Saldo do Recebedor*/

        $senderBalance = $sender->balance()->firstOrCrate([]);
        $totalBeforeSender = $senderBalance->amount ? $senderBalance->amount : 0;
        $senderBalance->amount += number_format ($value, 2, '.','');
        $transferSender = $this->save();

        $historicSender = $sender->historics()->create([
            'type'                  => 'I',
            'amount'                => $value,
            'total_before'          => $totalBeforeSender,
            'total_after'           => $senderBalance->amount,
            'date'                  => date('Ymd'),
            'user_id_transaction'   => auth()->user()->id,
        ]);

        if ($transfer && $historic  && $transferSender && $historicSender) {

            DB::commit();

            return [
                'sucess'    => true,
                'message'   => 'Sucesso ao transferir!'
            ];
        } else {

            DB::rollback();
            return [
                'sucess'    => false,
                'message'   => 'Não foi possível realizar a transferência'
            ];
        }
    }


}
