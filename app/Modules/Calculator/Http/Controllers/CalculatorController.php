<?php

namespace App\Modules\Calculator\Http\Controllers;

use App\Modules\Calculator\Http\Requests\CalculatorRequest;
use Inertia\Inertia;
use App\Enums\Operation;
use App\Modules\Calculator\Models\Calculator;
use App\Modules\Calculator\Services\CalculatorService;

class CalculatorController
{
    protected $calculatorService;

    /**
     * CalculatorController constructor
     */
    public function __construct(CalculatorService $calculatorService)
    {
        $this->calculatorService = $calculatorService;
    }
    /**
     * Display the module calculator screen
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Calculator::Calculator', [
            'operations' => Operation::values(),
            'calculations' => Calculator::latest()->take(10)->get(),
        ]);
    }

    public function calculator(CalculatorRequest $request)
    {
        try {
            $result = $this->calculatorService->calculator($request->validated());
            return redirect()->route('calculator.index')->with('result', $result);
        } catch (\Exception $e){
            return redirect()->route('calculator.index')->withErrors(['error' => $e->getMessage()]);
        }
    }
}
