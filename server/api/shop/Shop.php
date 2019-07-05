<?php

include_once ('../../libs/Sql.php');
include_once ('../../libs/Server.php');

class Shop extends Server
{
    private $sql;

    public function __construct()
    {
        $this->sql = new Sql();
    }

    public function getBook($arr)
    {
        $books = $this->sql->getBook($arr[0]);
        if($books){
            return $this->response($books, 200);
        }
        return $this->response('Data not found', 404);
    }

    public function getGenres()
    {
        $genres = $this->sql->getGenres();
        if($genres){
            return $this->response($genres, 200);
        }
        return $this->response('Data not found', 404);
    }

    public function getAuthors()
    {
        $authors = $this->sql->getAuthors();
        if($authors){
            return $this->response($authors, 200);
        }
        return $this->response('Data not found', 404);
    }

    public function getSearchResultGenre($arr)
    {
        $books = $this->sql->getSearchResultGenre($arr[0]);
        if($books){
            return $this->response($books, 200);
        }
        return $this->response('Data not found', 404);
    }

    public function getSearchResultAuthors($arr)
    {
        $books = $this->sql->getSearchResultAuthors($arr[0]);
        if($books){
            return $this->response($books, 200);
        }
        return $this->response('Data not found', 404);
    }

    public function postBuy()
    {
        $postBuy = $this->sql->postBuy($_REQUEST['user_id'],$_REQUEST['book_id'],$_REQUEST['amount']);
        if($postBuy){
            return $this->response($postBuy, 200);
        }
        return $this->response('Data not found', 404);
    }

    public function getCart($arr)
    {
        $books = $this->sql->getCart($arr[0]);
        if($books){
            return $this->response($books, 200);
        }
        return $this->response('Data not found', 404);
    }

    
}