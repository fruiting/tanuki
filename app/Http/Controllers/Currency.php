<?php

namespace App\Http\Controllers;

use App\Helpers\TTL;
use App\Models\Currency as CurrencyModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

/**
 * Класс, описывающий контроллер для работы с валютой
 * Class Currency
 *
 * @package App\Http\Controllers
 */
class Currency extends Controller
{
    /**
     * Возаращает json с описанием валюты и ее курсом
     *
     * @param string $charCode Символьный код валюты
     *
     * @return JsonResponse
     */
    public function getSpecificCurrency(string $charCode): JsonResponse
    {
        $currency = Cache::remember('currency_' . $charCode, TTL::DAY, function () use ($charCode) {
            return CurrencyModel::where('code', $charCode)->first();
        });

        if ($currency) {
            $response = response()->json($currency, Response::HTTP_OK);
        } else {
            $response = response()->json([], Response::HTTP_NOT_FOUND);
        }

        return $response;
    }

    /**
     * Возвращает список всех валют в бд
     *
     * @return JsonResponse
     */
    public function getCurrenciesList(): JsonResponse
    {
        $currencies = Cache::remember('currencies_list', TTL::DAY, function () {
            return CurrencyModel::get();
        });

        return response()->json($currencies, Response::HTTP_OK);
    }
}
