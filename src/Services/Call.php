<?php

namespace Tele2API\Services;

trait Call
{
    /**
     * Получение информации о текущих звонках
     *
     * @return array
     * [{
     *      "callType":"INTERNAL",
     *      "callerNumberShort":"0001",
     *      "callerNumberFull":"79535548834",
     *      "calledNumberShort":"0002",
     *      "calledNumberFull":"79527745939" 
     * }], где:
     * callType - тип вызова, может принимать значения:
     * MULTI_CHANNEL - вызов на многоканальный номер;
     * INTERNAL - вызов между номерами АТС;
     * callerNumberShort - короткий номер вызывающего абонента, если существует;
     * callerNumberFull - полный номер вызывающего абонента;
     * calledNumberShort - короткий номер вызываемого абонента, если существует;
     * calledNumberFull - полный номер вызываемого абонента;
     * calledNumberShort и calledNumberFull могут отсутствовать, если вызывающий абонент еще не был направлен на номер Б.
     */
    public function getCurrent()
    {
        return $this->send('call-company');
    }

    /**
     * Получение истории звонков
     *
     * @param string $start
     * @param string $end
     *
     * @return array
     * [{
     *      "callTimestamp":1486976298,
     *      "callType":"MULTI_CHANNEL",
     *      "destinationNumber":"73456576767",
     *      "callerNumber":"79527648162",
     *      "calleeNumber":"79527821956",
     *      "calleeName":" ",
     *      "callDuration":463125,
     *      "callStatus":"CANCELLED_BY_CALLER"
     * }], где
     * callTimestamp - unix timesamp начала вызова,
     * callType - тип вызова, возможные значения:
     * SINGLE_CHANNEL - одноканальный, вызов на конкретный номер абонента,
     * MULTI_CHANNEL – многоканальный,
     * INTERNAL - вызов в рамках клиента,
     * HIMSELF - вызов самому себе,
     * destinationNumber - номер на который был первоначальный вызов,
     * callerNumber - А-номер,
     * callerName - имя А-номера, если это зарегистрированный на АТС абонент,
     * calleeNumber - номер ответившей стороны (Б-номер),
     * calleeName - имя Б-номера,
     * callDuration - длительность вызова (начиная от попадания на АТС), в секундах,
     * conversationDuration - длительность разговора (с конкретным абонентом), в секундах,
     * callStatus - статус вызова, возможные значения:
     * ANSWERED_COMMON - отвечен в режиме вызова на конкретный номер (P2P),
     * ANSWERED_BY_ORIGINAL_CLIENT - отвечен оператором КЦ,
     * ANSWERED_BY_BUSY_FORWARD_CLIENT - отвечен после переадресации по "Занято" ,
     * ANSWERED_BY_NO_ANSWER_FORWARD_CLIENT - отвечен после переадресации по "Нет ответа",
     * NOT_ANSWERED_COMMON - не отвечен,
     * CANCELLED_BY_CALLER - отменен звонившим абонентом,
     * DENIED_DUE_TO_MAX_SESSION - заблокирован по причине превышения макс. значения одновременных вызовов на клиенте,
     * DENIED_DUE_TO_INCOMING_CALLS_BLOCKED - заблокирован по причине запрета входящих вызовов,
     * DENIED_DUE_TO_ONLY_INTERNAL_CALLS_ENABLED - заблокирован по причине разрешения только внутренних вызовов,
     * DENIED_DUE_TO_BLACK_LISTED - заблокирован по причине нахождения в черном списке,
     * DENIED_DUE_TO_NOT_WORK_TIME - заблокирован по причине вызова в нерабочее время,
     * DENIED_DUE_TO_UNKNOWN_NUMBER - заблокирован по причине неизвестного номера.
     */
    public function getHistory($start = "-1 day", $end = "now")
    {
        $params = [
            'start' => strtotime($start),
            'end' => strtotime($end)
        ];

        return $this->send('cdr', $params);
    }

    /**
     * Получение списка абонентов в очереди
     *
     * @return array
     * [{
     *      "queueName":"1",
     *      "calls":[
     *          "79527648162",
     *          "79527648163"
     *      ]
     * }], где
     * queueName - название КЦ
     * calls - список номеров в очереди
     */
    public function getPending()
    {
        return $this->send('call_pending', $params);
    }
}
