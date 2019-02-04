<?php

class qb_vmin
{
    private $url = 'https://ns529456.ip-149-56-22.net:10000/virtual-server/remote.cgi?domain=quakbox.com';
    private $username = 'root';
    private $password = '37qFaCCxys1i';

    public function modifyUser($username, $password)
    {
        $this->execCommand('modify-user', [
            'user' => $username,
            'pass' => $password
        ]);
    }

    private function execCommand($command, $params)
    {
        $url = $this->url.'&program='.$command;
        if(!empty($params)){
            foreach($params as $k => $v) {
                $url .= '&'.$k.'='.$v;
            }
        }

        $c = curl_init();
        curl_setopt($c, CURLOPT_URL, $url);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($c, CURLOPT_TIMEOUT, 60);
        curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($c, CURLOPT_USERPWD, $this->username.':'.$this->password);
        $results = @curl_exec($c);
    }

}