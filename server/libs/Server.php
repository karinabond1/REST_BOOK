<?php
include('/home/user14/public_html/REST_BOOK/server/api/shop/Shop.php');
include('/home/user14/public_html/REST_BOOK/server/api/user/User.php');
include('Viewer.php');
include('../../config.php');

class Server
{
    private $server;
    private $method;
    private $url;
    private $viewer;

    public function __construct()
    {

        //print_r($_REQUEST);
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->url = $_SERVER['REQUEST_URI'];
        $this->viewer = new Viewer();
    }

    public function methodChoose()
    {
        list($s, $u, $r, $ser, $a, $class, $meth, $par) = explode('/', $this->url, 8);
        //echo $class."...".$meth."!!!".$par."!!!";
        //echo $this->url;
        //echo $this->method;
        switch ($this->method) {
            case 'GET':
                $this->setMethod(ucfirst($class), 'get' . ucfirst($meth), $par);
                break;
            case 'DELETE':
                $this->setMethod(ucfirst($class), 'delete' . ucfirst($meth), $par);
                break;
            case 'POST':
                $this->setMethod(ucfirst($class), 'post' . ucfirst($meth), $par);
                break;
            case 'PUT':
                $this->setMethod(ucfirst($class), 'put' . ucfirst($meth), $par);
                break;
            default:
                return false;
        }
    }

    private function setMethod($class, $method, $par = false)
    {
        //$_POST['name'];
        //echo $class.".".$method;
        //echo $method;
        $obj = new $class;
        if (method_exists($obj, $method)) {
            //echo $_REQUEST['password_log'];
            //echo "gg";
            if (stristr($par, '/') && (!stristr($par, '.txt') || !stristr($par, '.json') || !stristr($par, '.html') || !stristr($par, '.xml'))) {
                $arr = explode('/', $par);
                //echo "f";
                $carsRes = call_user_func([$obj, $method], $arr);
                $this->viewer->view($carsRes, '');
            } elseif (stristr($par, '.') && (stristr($par, '.txt') || stristr($par, '.json') || stristr($par, '.html') || stristr($par, '.xml'))) {
                $arr = explode('/', $par);
                //echo "f";
                $carsRes = call_user_func([$obj, $method], $arr[0]);
                $this->viewer->view($carsRes, $arr[1]);
            } else {
                //echo "f";
                $carsRes = call_user_func([$obj, $method], $par);
                $this->viewer->view($carsRes, $par);
            }

        }
    }

    protected function response($data, $status = 500)
    {
        header("HTTP/1.1 " . $status . " " . $this->requestStatus($status));
        return $data;
    }

    private function requestStatus($code)
    {
        $status = array(
            200 => 'OK',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error',
        );
        return ($status[$code]) ? $status[$code] : $status[500];
    }

}