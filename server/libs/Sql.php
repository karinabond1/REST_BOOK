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
                    //var_dump($row);
                    $id = $row[0]['id'];
                }
                //echo $id;
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

    public function putUserLog($email, $password)
    {
        //echo "ff";
        //echo $_SERVER['HTTP_REFERER'];
        if(!$email && !$password){
            $url = $_SERVER['HTTP_REFERER'];
            $arr = explode('?', $url);
            $arr1 = explode('&', $arr[1]);
            $emailArr = explode('=', $arr1[0]);
            $passwordArr = explode('=', $arr1[1]);
            $email = str_replace("%40","@",$emailArr[1]);
            $password = $passwordArr[1];
            //echo $passwordArr[1];
        }
        //echo $email;
        $arr1 = explode('&', $email);
        $emailArr = explode('=', $arr1[0]);
        $passwordArr = explode('=', $arr1[1]);
        $emailRes = str_replace("%40","@",$emailArr[1]);
        $passwordRes = $passwordArr[1];
        $updateUser = $this->mysql->prepare("UPDATE users SET status='online' WHERE email=? AND password=?;");
        $par[] = $emailRes;
        $par[] = $passwordRes;
        $res = $updateUser->execute($par);
        $selectUser = $this->mysql->prepare("SELECT id, name, surname FROM users WHERE email=? AND password=?;");
        $parS[] = $emailRes;
        $parS[] = $passwordRes;
        $selectUser->execute($parS);
        $indexSelectUser = 0;
        while ($row = $selectUser->fetch(PDO::FETCH_ASSOC)) {
            $user[$indexSelectUser] = $row;
            $indexSelectUser++;
        }
        if ($user) {
            return $user;
        } else {
            return "There is some problem with log in proccess. Please, try again!";
        }
    }

    public function putUserLogOff($id)
    {
        //echo $_SERVER['HTTP_REFERER'];
        if(!$id){
            $url = $_SERVER['HTTP_REFERER'];
            $arr = explode('?', $url);
            $idArr = explode('=', $arr[1]);
            echo $arr[1];
            $id = $idArr[1];
        }
        //echo $id;
        $idArr = explode('=', $id);
        $idLast = $idArr[1];
        //echo $idLast;
        $updateUser = $this->mysql->prepare("UPDATE users SET status='offline' WHERE id=?;");
        $par[] = $idLast;
        $res = $updateUser->execute($par);
        
        if ($res) {
            return "Good Bye!";
        } else {
            return "There is some problem with log out proccess. Please, try again!";
        }
    }

    public function postBuy($user_id,$book_id,$amount)
    {
        //echo "dd";
        $selectCartId = $this->mysql->prepare("SELECT id FROM cart WHERE user_id=?;");
        $parE[] = $user_id;
        $selectCartId->execute($parE);
        if(count($selectCartId->fetchAll(PDO::FETCH_ASSOC))>0) {
            $indexSelectCartId = 0;
            $cart_id = 0;
            $selectCartId2 = $this->mysql->prepare("SELECT id FROM cart WHERE user_id=?;");
            $parEE[] = $user_id;
            $selectCartId2->execute($parEE);
            while ($row = $selectCartId2->fetch(PDO::FETCH_ASSOC)) {
                //echo "ff";
                //echo $row['id'];
                //var_dump($row);
                $cart_id = $row['id'];
                $indexSelectCartId++;
            }
            $insertBookCart = $this->mysql->prepare("INSERT INTO books_cart (book_id,cart_id,amount) VALUES(?,?,?);");
            $parB[] = $book_id;
            $parB[] = $cart_id;
            $parB[] = $amount;
            $res = $insertBookCart->execute($parB);
            if($res){
                return "Your order in the cart!!";
            }else{
                return "Something went wrong! Please, try again!!";
            }
        }else{
            $insertCart = $this->mysql->prepare("INSERT INTO cart (user_id) VALUES(?);");
            $par[] = $user_id;
            $res = $insertCart->execute($par);

            $selectCartId1 = $this->mysql->prepare("SELECT id FROM cart WHERE user_id=?");
            $parC[] = $user_id;
            $selectCartId1->execute($parC);
            $indexSelectCartId1 = 0;
            while ($row = $selectCartId1->fetch(PDO::FETCH_ASSOC)) {
                $cart_id = $row[0]['id'];
                $indexSelectCartId1++;
            }

            $insertBookCart1 = $this->mysql->prepare("INSERT INTO books_cart (book_id,cart_id,amount) VALUES(?,?,?);");
            $parBo[] = $book_id;
            $parBo[] = $cart_id;
            $parBo[] = $amount;
            $resI = $insertBookCart1->execute($parBo);
            if($resI){
                return "Your order in the cart!";
            }else{
                return "Something went wrong! Please, try again!";
            }
        }
    }

    public function getCart($id)
    {
        $cart_id = 0;
        $selectIdCart = $this->mysql->prepare("SELECT id FROM cart WHERE user_id=?");
        $par[] = $id;
        $selectIdCart->execute($par);
        $indexIdCart = 0;
        while ($row = $selectIdCart->fetch(PDO::FETCH_ASSOC)) {
            $cart_id = $row['id'];
            $indexIdCart++;
        }
        if($cart_id>0){
            $selectIdBook = $this->mysql->prepare("SELECT books.id, books.book, books.price, books.discount, books_cart.amount FROM books INNER JOIN books_cart ON books.id=books_cart.book_id WHERE books_cart.cart_id=?;");
            $parB[] = $cart_id;
            $selectIdBook->execute($parB);
            $indexIdBook = 0;
            while ($row = $selectIdBook->fetch(PDO::FETCH_ASSOC)) {
                $books[$indexIdBook] = $row;
                $indexIdBook++;
            }
            if($books){
                return $books;
            }else{
                return "There are some problems. Please, try again!";
            }
        }else{
            return "There are some problems. Please, try again!";
        }
    }
}