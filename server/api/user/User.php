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

    public function putUserLog($email=false,$password=false)
    {
        $userLog = $this->sql->putUserLog($email, $password);
        if($userLog){
            return $this->response($userLog, 200);
        }
        return $this->response('Data not found', 404);
    }

    public function putUserLogOff($id=false)
    {
        $userLog = $this->sql->putUserLogOff($id);
        if($userLog){
            return $this->response($userLog, 200);
        }
        return $this->response('Data not found', 404);
    }
}