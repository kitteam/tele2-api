<?php

namespace Tele2Api\Services;

use GuzzleHttp\Client;
use Tele2Api\Exceptions\Tele2Exceptions;

class Tele2Api
{
    use Call, Employee, Stat;

    /**
     * ID клиента (передается каждому клиенту при интеграции)
     *
     * @var integer
     */
    protected $company = '';

    /**
     * ID региона (передается каждому клиенту при интеграции)
     *
     * @var integer
     */
    protected $region = '';

    /**
     * Логин администратора АТС (добавляется в разделе «Пользователи АТС»)
     *
     * @var string
     */
    protected $login = '';

    /**
     * Пароль администратора АТС (добавляется в разделе «Пользователи АТС»)
     *
     * @var string
     */
    protected $password = '';

    public function __construct()
    {
        if ($account = config('tele2.default')) {
            $this->account($account);
        }
    }

    /**
     * @param string $server
     *
     * @throws \Exception
     *
     * @return $this
     */
    public function account($account = '')
    {
        if (empty($account)) {
            throw new \Exception('Account is not specified');
        }
        $allAccounts = config('tele2.accounts');

        if (!isset($allAccounts[$account])) {
            throw new \Exception('Specified account not found in config');
        }

        if ($this->accountCheck($account, $allAccounts)) {
            throw new \Exception('Specified account config does not contain the required key');
        }

        $this->company = (string) $allAccounts[$account]['company'];
        $this->region = (string) $allAccounts[$account]['region'];
        $this->login = (string) $allAccounts[$account]['login'];
        $this->password = (string) $allAccounts[$account]['password'];

        return $this;
    }

    /**
     * @param string $account
     * @param array  $config
     *
     * @return bool
     */
    private function accountCheck($account, $config)
    {
        return !isset($config[$account]['company'])
            || !isset($config[$account]['region'])
            || !isset($config[$account]['login'])
            || !isset($config[$account]['password']);
    }

    /**
     * @param string $cmd
     *
     * @throws Tele2Exceptions
     *
     * @return string
     */
    public function send($cmd, $params = [])
    {
        $config = config('tele2.client');

        if (!isset($config)) {
            throw new \Exception('Specified client params not found in config');
        }

        $client = new Client($config);

        $params = array_merge($params, [
            'company_id' => $this->company,
            'region_id' => $this->region,
            'login' => $this->login,
            'password' => $this->password
        ]);

        $json = $client->post($cmd, ['form_params' => $params])
            ->getBody()
            ->getContents();

        if (!($data = json_decode($json, true)) && json_last_error()) {
            throw new Tele2Exceptions('JSON decodin error');
        }

        return $data;
    }

}
