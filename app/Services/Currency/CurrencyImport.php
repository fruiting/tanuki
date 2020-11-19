<?php

namespace App\Services\Currency;

use App\Models\Currency;
use App\Services\Curl;
use Exception;
use Illuminate\Support\Facades\DB;
use SimpleXMLElement;

/**
 * Класс, описывающий логику импорта курсов валют
 * Class CurrencyImport
 *
 * @package App\Services\Currency
 */
class CurrencyImport
{
    /** @var string Ссылка на xml центробанка с курсами валют на текущий день */
    private const CB_XML = 'http://www.cbr.ru/scripts/XML_daily.asp?date_req=';

    /**
     * @var string[]
     *
     * Массив с необходимыми для импорта кодами валют.
     * @todo Это в идеале нужно хранить в бд и перед импортом получать оттуда необходимые коды
     */
    private const NECESSARY_CURRENCIES = [
        'USD',
    ];

    /**
     * Реализует импорт
     *
     * @param string $date Дата, за которую надо взять курсы валют
     *
     * @return void
     */
    public static function import(string $date): void
    {
        DB::transaction(function() use ($date) {
            try {
                $response = (new Curl(self::CB_XML . $date, 5))->makeRequest();
                $currencies = new SimpleXMLElement($response);

                foreach ($currencies as $currency) {
                    $charCode = ((array)$currency->CharCode)[0];
                    if (in_array($charCode, self::NECESSARY_CURRENCIES)) {
                        $dbCurrency = Currency::where('code', $charCode)->first();
                        $fields = [
                            'code' => $charCode,
                            'course' => ((array)$currency->Value)[0],
                        ];

                        if ($dbCurrency) {
                            Currency::update($fields);
                        } else {
                            Currency::create($fields);
                        }
                    }
                }
            } catch (Exception $exception) {
                logger()->error('Произошла ошибка при импорте валют: ' . $exception->getMessage());
            }
        });
    }
}
