<?php

namespace App\Modules\Calculator\Services;

use App\Enums\Operation;
use App\Modules\Calculator\Models\Calculator;

class CalculatorService
{

    public function calculator($request)
    {
        $operations = [
            Operation::ADDITION->value => fn($a, $b) => $a + $b,
            Operation::SUBTRACTION->value => fn($a, $b) => $a - $b,
            Operation::MULTIPLICATION->value => fn($a, $b) => $a * $b,
            Operation::DIVISION->value => function ($a, $b) {
                throw_if($b == 0, \Exception::class, 'Division by zero is not possible.');
                return $a / $b;
            },
        ];
        // Exécution de l'opération
        $result = $operations[$request['operation']]($request['firstNb'], $request['secondNb']);
        
        // Sauvegarde dans la base de données
        Calculator::create([
            'num1' => $request['firstNb'],
            'num2' => $request['secondNb'],
            'operation' => $request['operation'],
            'result' => $result,
        ]);
        return $result;
    }
}
