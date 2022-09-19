<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Iso extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'code', 'number', 'decimal', 'currency_locations', 'created_at', 'updated_at', 'deleted_at'
    ];

    function verificaSeExisteInformacaoGravada($code)
    {
        return Iso::where("code", $code)->first();
    }

    function salvarBusca($codigo)
    {
        // Verifica se já existe o código no banco de dados.
        if (!$this->verificaSeExisteInformacaoGravada($codigo['code'])) {
            $iso                     = new Iso();
            $iso->code               = $codigo['code'];
            $iso->number             = $codigo['number'];
            $iso->decimal            = $codigo['decimal'];
            $iso->currency           = $codigo['currency'];
            $iso->currency_locations = json_encode($codigo['currency_locations'], JSON_UNESCAPED_UNICODE);
            $iso->save();
        }
    }
}
