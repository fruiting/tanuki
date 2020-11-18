<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Класс, описывающий модель валюты
 * Class Currency
 *
 * @package App\Models
 */
class Currency extends Model
{
    /** @var string $table Название таблицы */
    protected $table = 'currencies';

    /**
     * @var string[] $fillable
     *
     * Массив названий столбцов, доступных для изменения.
     * Будем считать, что на данный момент есть только два поля: символьный код валюты и его курс по отношению к рублю.
     */
    protected $fillable = ['code', 'course'];
}
