<?php

namespace App\Services;

use LogicException;

/**
 * Класс, описывающий логику работы запросов через cURL
 * Class Curl
 *
 * @package App\Services
 */
class Curl
{
    /** @var string $link Ссылка для подключения */
    private $link;

    /** @var int|null $timeout Таймаут для отключения в секундах */
    private $timeout;

    /**
     * Curl constructor.
     *
     * @param string $link Ссылка для подключения
     * @param int|null $timeout Таймаут для отключения в секундах
     */
    public function __construct(string $link, int $timeout = null)
    {
        $this->link = $link;
        $this->timeout = $timeout;
    }

    /**
     * Реализует запрос
     *
     * @return mixed
     */
    public function makeRequest()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->link);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if ($this->timeout) {
            curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        }

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
}