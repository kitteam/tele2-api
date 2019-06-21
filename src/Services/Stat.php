<?php

namespace Tele2API\Services;

trait Stat
{
    /**
     * Получение общей статистики
     *
     * Если необязательный параметр number указан, API ищет статистику по номеру,
     * если не указан – статистику по компании.
     *
     * unix timestamp начало временного интервала
     * @param string $start
     *
     * unix timestamp конец временного интервала
     * @param string $end
     *
     * Номер абонента АТС (в формате 7ХХХХХХХХХХ), необязательный параметр
     * @param string $number
     *
     * @return array
     * [{
     *      "successCallCount":582,
     *      "commonCallDuration":54572,
     *      "lostCallCount":345,
     *      "averageCallDuration":93,
     *      "averageCallCountPerHour":12.12,
     *      "maxCallDuration":395,
     *      "transferCallCount":0,
     *      "transferCallDuration":0,
     *      "averageTransferCallDuration":0,
     *      "hangupACallCount":150,
     *      "hangupBCallCount":124,
     *      "uniqueCallCount":541,
     *      "redialCount":386,
     *      "internalCallCount":0,
     *      "internalCallDuration":0,
     *      "averageInternalCallDuration":0
     * }], где
     * successCallCount - кол-во отвеченных вызовов;
     * commonCallDuration - общая длительность вызовов, в секундах;
     * lostCallCount - кол-во неотвеченных вызовов;
     * averageCallDuration - средняя продолжительность вызова, в секундах;
     * averageCallCountPerHour - среднее кол-во вызовов в час;
     * maxCallDuration - максимальная длительность вызова, в секундах;
     * transferCallCount - кол-во трансферов;
     * transferCallDuration - общая длительность трансферных вызовов;
     * averageTransferCallDuration - средняя длительность трансферных вызовов;
     * hangupACallCount - кол-во отбоев со стороны инициатора вызова;
     * hangupBCallCount - кол-во отбоев со стороны сотрудника;
     * uniqueCallCount - общее кол-во уникальных вызовов;
     * redialCount - общее кол-во повторных вызовов;
     * internalCallCount - общее кол-во вызовов внутри компании;
     * internalCallDuration - общая длительность вызовов внутри компании;
     * averageInternalCallDuration -  средняя длительность вызовов внутри компании.
     */
    public function getCommon($start = "-1 day", $end = "now", $number = null)
    {
        $params = [
            'start' => strtotime($start),
            'end' => strtotime($end),
            'number' => $number
        ];

        return $this->send('employees', $params);
    }

    /**
     * Получение статистики по конкретному номеру
     *
     * Начало временного отрезка, за который предоставляется статистика, обязательный параметр
     * @param string $start
     *
     * Конец временного отрезка, за который предоставляется статистика, обязательный параметр
     * @param string $end
     *
     * Номер для которого собрать статистику (в формате 7ХХХХХХХХХХ), необязательный параметр
     * @param string $number
     *
     * @return array
     * [{
     *      "number":"7XXXXXXXXXX",
     *      "startTimestamp":1486975130,
     *      "endTimestamp":1487061531,
     *      "numberOfCalls":6,
     *      "numberOfSuccessCalls":3
     * }]
     */
     public function  getInfo($start = "-1 day", $end = "now", $number = null)
     {
         $params = [
             'start' => strtotime($start),
             'end' => strtotime($end),
             'number' => $number
         ];

         return $this->send('call_info', $params);
     }
}
