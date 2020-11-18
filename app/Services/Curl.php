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
    /** @var mixed $response Ответ, полученный через cURL */
    private $response;

    /**
     * Реализует запрос
     *
     * @param string $link Ссылка для подключения
     * @param int|null $timeout Таймаут для отключения в секундах
     *
     * @return self
     */
    public function makeRequest(string $link, int $timeout = null): self
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $link);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if ($timeout) {
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        }

        $this->response = curl_exec($ch);
        curl_close($ch);

        return $this;
    }

    /**
     * Возвращает ответ в виде строки
     *
     * @return string
     */
    public function getString(): string
    {
        if (is_string($this->response)) {
            return $this->response;
        } else {
            throw new LogicException('Ответ должен быть в виде строки');
        }
    }
}