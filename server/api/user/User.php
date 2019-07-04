<?php
include_once ('../../libs/Server.php');
include_once('../../libs/Sql.php');

class User extends Server
{
    private $sql;

    public function __construct()
    {
        $this->sql = new Sql();
    }

    public function postUserInfo()
    {
        $userInfo = $this->sql->postUser($_REQUEST['name'],$_REQUEST['surname'],$_REQUEST['email'],$_REQUEST['password']);
        if($userInfo){
            return $this->response($userInfo, 200);
        }
        return $this->response('Data not found', 404);
    }

    public function putUserLog()
    {
        $userLog = $this->sql->putUserLog($_REQUEST['email_log'],$_REQUEST['password_log']);
        if($userLog){
            return $this->response($userLog, 200);
        }
        return $this->response('Data not found', 404);
    }
}