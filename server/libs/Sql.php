<?php

class Sql
{
    private $mysql;

    public function __construct()
    {
        $this->mysql = new PDO("mysql:host=" . HOST . ";port=" . PORT . ";dbname=" . DATABASE, USER_NAME, USER_PASS);
        $this->mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getBook($id)
    {
        $books = array();

        try {            

            $selectBooks = $this->mysql->prepare("SELECT id, book, about, price, img FROM books WHERE id=?;");
            $par[] = $id;
            $selectBooks->execute($par);

            $indexBooks = 0;
            while ($row = $selectBooks->fetch(PDO::FETCH_ASSOC)) {
                $books[$indexBooks] = $row;
                $indexBooks++;
            }

        }catch (PDOException $e) {
            echo $str = 'Error:+ ' . $e->getMessage();
        }
        return $books;
        //return false;
    }

    public function getGenres()
    {
        $genres = array();

        try {            

            $selectGenres = $this->mysql->prepare("SELECT id, genre FROM genres;");
            $selectGenres->execute();

            $indexGenres = 0;
            while ($row = $selectGenres->fetch(PDO::FETCH_ASSOC)) {
                $genres[$indexGenres] = $row;
                $indexGenres++;
            }

        }catch (PDOException $e) {
            echo $str = 'Error:+ ' . $e->getMessage();
        }
        return $genres;
        //return false;
    }

    public function getAuthors()
    {
        $authors = array();

        try {            

            $selectAuthors = $this->mysql->prepare("SELECT id, author FROM authors;");
            $selectAuthors->execute();

            $indexAuthors = 0;
            while ($row = $selectAuthors->fetch(PDO::FETCH_ASSOC)) {
                $authors[$indexAuthors] = $row;
                $indexAuthors++;
            }

        }catch (PDOException $e) {
            echo $str = 'Error:+ ' . $e->getMessage();
        }
        return $authors;
        //return false;
    }

    /*public function getCar($id)
    {
        $cars = array();
        try {

            $selectCarinfo = $this->mysql->prepare("SELECT  autoshop_cars.id,autoshop_brand.brand,autoshop_cars.model, autoshop_cars.year_issue, autoshop_cars.engin_capacity, autoshop_cars.max_speed, autoshop_cars.price FROM autoshop_cars inner join autoshop_brand on autoshop_cars.brand_id=autoshop_brand.id WHERE autoshop_cars.id = " . $id);
            $selectCarinfo->execute();
            $indexCar = 0;
            while ($row = $selectCarinfo->fetch(PDO::FETCH_ASSOC)) {
                $cars[$indexCar] = $row;
                $indexCar++;
            }
            $selectColor = $this->mysql->prepare("SELECT autoshop_color.color FROM autoshop_color INNER JOIN autoshop_car_color ON autoshop_color.id=autoshop_car_color.color_id WHERE autoshop_car_color.car_id = " . $id . ";");
            $selectColor->execute();
            while ($row = $selectColor->fetch(PDO::FETCH_ASSOC)) {
                $cars[$indexCar] = $row;
                $indexCar++;
            }

        } catch (PDOException $e) {
            echo $str = 'Error:+ ' . $e->getMessage();
        }
        return $cars;
    }*/

    public function getSearchResultGenre($genreId)
    {
        $books = array();    
        $selectBooks = $this->mysql->prepare("SELECT books.id,books.book,books.img FROM books INNER JOIN books_genres ON books.id=books_genres.book_id WHERE books_genres.genre_id=?");
        $par[] = $genreId; 
        $selectBooks->execute($par);
        $indexBooks = 0;
        while ($row = $selectBooks->fetch(PDO::FETCH_ASSOC)) {
            $books[$indexBooks] = $row;
            $indexBooks++;
        }
        return $books;
        
    }

    public function getSearchResultAuthors($authorId)
    {
        $books = array();    
        $selectBooks = $this->mysql->prepare("SELECT books.id,books.book,books.img FROM books INNER JOIN books_authors ON books.id=books_authors.book_id WHERE books_authors.authors_id=?");
        $par[] = $authorId; 
        $selectBooks->execute($par);
        $indexBooks = 0;
        while ($row = $selectBooks->fetch(PDO::FETCH_ASSOC)) {
            $books[$indexBooks] = $row;
            $indexBooks++;
        }
        return $books;
        
    }

    /*public function postBuy($car_id,$user_id,$payment)
    {

        $res = array();
        $sendCarInfo = $this->mysql->prepare("INSERT INTO autoshop_client_order (car_id,user_id,payment) VALUES(?,?,?);");
        $par[] = $car_id;
        $par[] = $user_id;
        $par[] = $payment;
        $res = $sendCarInfo->execute($par);
        if ($res) {
            //return 'yes';
            return array('yes');
        } else {
            //return 'no';
            return array('no');
        }
    } */


    public function postUser($name,$surname,$email,$password)
    {
        $selectEmail = $this->mysql->prepare("SELECT id FROM users where email=?;");
        $parE[] = $email;
        $selectEmail->execute($parE);
        if(count($selectEmail->fetchAll(PDO::FETCH_ASSOC))>0) {
            return 'There is the same email. Please, change it!';
        }else{
            $sendInfo = $this->mysql->prepare("INSERT INTO users (name,surname,email,password,discount,status) VALUES(?,?,?,?,?,?);");
            $par[] = $name;
            $par[] = $surname;
            $par[] = $email;
            $par[] = $password;
            $par[] = '0';
            $par[] = 'offline';
            $res = $sendInfo->execute($par);
            $resR = false;
            if($res){
                $id = "";
                $idUser = $this->mysql->prepare("SELECT id FROM users where email=?;");
                $parU[] = $email;
                $idUser->execute($parU);
                while($row = $idUser->fetchAll(PDO::FETCH_ASSOC)){
                    $id = $row['id'];
                }
                if($id){
                    $insertRole = $this->mysql->prepare("INSERT INTO users_roles (user_id,role_id) VALUES(?,?)");
                    $parR[] = $id;
                    $parR[] = '2';
                    $resR = $insertRole->execute($parR);
                }
            }
            
            
            if($res && $resR){
                return "You are registrated!";
            }else{
                return "There is some problem with buying proccess. Please, try again later!";
            }
        }
    }

    public function putUserLog($email,$password)
    {
        $user = array();
        //$sendCarInfo = $this->mysql->prepare("SELECT id, name, surname FROM users WHERE email='" . $email . "' AND password='" . $password . "';");
        $sendCarInfo = $this->mysql->prepare("UPDATE users SET status='online' WHERE email=? AND password=?;");
        //$par[] = 'online';
        $par[] = $email;
        $par[] = $password;
        $res = $sendCarInfo->execute($par);
        /*$indexCars = 0;
        while ($row = $sendCarInfo->fetch(PDO::FETCH_ASSOC)) {
            $user[$indexCars] = $row;
            $indexCars++;
        }*/
        if ($res) {
            return "Hello!";
        } else {
            return "There is some problem with buying proccess. Please, try again later!";
        }
    }
}