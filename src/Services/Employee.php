<?php

namespace Tele2API\Services;

trait Employee
{
    /**
     * Получение списка сотрудников компании
     *
     * @return array
     * [{
     *      "employeeId": 5531,
     *      "name": "Ivan",
     *      "surname": "Ivanov",
     *      "fullNumber": "7XXXXXXXXXX",
     *      "shortNumber": "1234",
     *      "email": "i.ivanov@mail.ru"
     * }], где
     * employeeId – ID номера, зарегистрированного в АТС,
     * name – имя,
     * surname – фамилия,
     * fullNumber – федеральный номер,
     * shortNumber – короткий номер,
     * email – электронная почта.
     */
    public function get()
    {
        return $this->send('employees');
    }
}
