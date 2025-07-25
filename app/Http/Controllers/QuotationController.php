<?php

namespace App\Http\Controllers;

use App\DTOs\CalculateQuotationTotalDTO;
use App\Exceptions\AgeLoadException;
use App\Http\Requests\StoreQuotationRequest;
use App\Http\Resources\QuatationResource;
use App\Models\Currency;
use App\Models\Quotation;
use App\Services\QuotationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class QuotationController extends Controller
{
    public function __construct(private QuotationService $quotationService) {}

    public function index(): JsonResponse
    {
        $quotations = request()->user()->quotations()->with('currency')->get();

        return response()->json(QuatationResource::collection($quotations));
    }

    public function store(StoreQuotationRequest $request): JsonResponse
    {
        $currency = Currency::where('code', $request->currency_id)->first();
        $dto = new CalculateQuotationTotalDTO(
            age: $request->age,
            start_date: $request->start_date,
            end_date: $request->end_date,
        );

        try {
            $total = $this->quotationService->calculateTotal($dto);
        } catch (AgeLoadException $e) {
            throw ValidationException::withMessages([
                'age' => $e->getMessage(),
            ]);
        }

        $quotation = $request->user()->quotations()->create([
            'currency_id' => $currency->id,
            'age' => $request->age,
            'total' => $total,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return response()->json(new QuatationResource($quotation));
    }

    public function show(Quotation $quotation): JsonResponse
    {
        return response()->json(new QuatationResource($quotation));
    }
}
