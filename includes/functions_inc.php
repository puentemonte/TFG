<?php

function uidExists($conn, $username, $email) {
    $sql = "SELECT * FROM users WHERE userUid = ? OR userEmail = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    }
    else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function emptyInputLogin($username, $pwd) {
    $result; 
    if (empty($username) | empty($pwd)){
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function emptyInputPwdChange($pwd, $newpwd, $newpwdrepeat) {
    $result; 
    if (empty($pwd) | empty($newpwd) | empty($newpwdrepeat)){
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function emptyInputDelete($pwd) {
    $result; 
    if (empty($pwd)){
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function wrongPwd($conn, $pwd) {
    session_start();
    $username = $_SESSION["useruid"];

    $uidExists = uidExists($conn, $username, $username);

    // Acheck the session pwd
    $pwdHashed = $uidExists["userPwd"];
    $checkPwd = password_verify($pwd, $pwdHashed);

    $result;
    if ($checkPwd === false) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function loginUser($conn, $username, $pwd) {
    $uidExists = uidExists($conn, $username, $username);

    if ($uidExists === false) {
        header("location: ../login.php?error=wronglogin");
        exit();
    }

    $pwdHashed = $uidExists["userPwd"];
    $checkPwd = password_verify($pwd, $pwdHashed);

    if ($checkPwd === false) {
        header("location: ../login.php?error=wronglogin");
        exit();
    }
    else if ($checkPwd === true){
        session_start();
        // retrieve data from db
        $email;
        $fname;
        $surname;
        $pronouns;

        $sql = "SELECT * FROM users WHERE userUid = ? OR userEmail = ?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../signup.php?error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "ss", $username, $username);
        mysqli_stmt_execute($stmt);
        $resultData = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($resultData)) {
            $email = $row["userEmail"];
            $fname = $row["userName"];
            $surname = $row["userSurname"];
            $pronouns = $row["userPronouns"];
        }
        else {
            header("location: ../login.php?error=wronglogin");
            exit();
        }
        mysqli_stmt_close($stmt);
        $_SESSION["userid"] =  $uidExists["userId"];
        $_SESSION["useruid"] =  $uidExists["userUid"];
        $_SESSION["email"] = $email;
        $_SESSION["fname"] = $fname;
        $_SESSION["surname"] = $surname;
        $_SESSION["pronouns"] = $pronouns;
        header("location: ../index.php");
        exit();
    }
}

function emptyInputSignup($username, $email, $pwd, $pwdRepeat){
    $result;
    if(empty($username) | empty($email) | empty($pwd) | empty($pwdRepeat)){
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function invalidEmail($email){
    $result;
    !filter_var($email, FILTER_VALIDATE_EMAIL) ? $result = true : $result = false;
    return $result;
}

function pwdMatch($pwd, $pwdRepeat){
    $result;
    $pwd !== $pwdRepeat ? $result = true : $result = false;
    return $result;
}

function invalidPwd($pwd){
    $result;
    // contraseña válida: mínimo una mayúscula, un número, long 8
    $pattern = "/^(?=.*[A-Z])(?=.*[0-9]).{8,}$/";
    if(preg_match($pattern, $pwd)) {
        $result = false;
    }
    else {
        $result = true;
    }
    return $result;
}

function createUser($conn, $fname, $surname, $username, $email, $pwd, $pronouns, $descr){
    $sql ="INSERT INTO users (userEmail, userUid, userPwd, userName, userSurname, userDescription, userPronouns) VALUES (?, ?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }     

    // security
    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    // check optional fields
    $fname = !empty($fname) ? $fname : "NULL";
    $surname = !empty($surname) ? $surname : "NULL";
    $descr = !empty($descr) ? $descr : "NULL";
    $pronouns = !empty($pronouns) ? $pronouns : "NULL";
    
    mysqli_stmt_bind_param($stmt, "sssssss", $email, $username, $hashedPwd, $fname, $surname, $descr, $pronouns);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    loginUser($conn, $username, $pwd);
    header("location: ../index.php");
    exit();
}

function emptyInputUpdate($username, $email){
    $result;
    if(empty($username) || empty($email)){
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function updateUser($conn, $fname, $surname, $username, $email, $pronouns) {
    session_start();
    $userid = $_SESSION["userid"];
    $sql = "UPDATE users SET userEmail = ?, userUid = ?, userName = ?, userSurname = ?, userPronouns = ? WHERE userId = ?;";

    // preparing the stmt
    $stmt = mysqli_stmt_init($conn);
    // error
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../settings.php?error=stmtfailed");
        exit();
    }
    else { 
        mysqli_stmt_bind_param($stmt, "sssssi", $email, $username, $fname, $surname, $pronouns, $userid);
        //, $fname, $surname, $pronouns
        mysqli_stmt_execute($stmt);

        // update session data
        session_start();
        $_SESSION["useruid"] =  $username;
        $_SESSION["fname"] = $fname;
        $_SESSION["surname"] = $surname;
        $_SESSION["email"] = $email;
        $_SESSION["pronouns"] = $pronouns;
    }

    mysqli_stmt_close($stmt);
    header("location: ../settings.php?error=none");
    exit();
}

function updatePwd($conn, $newpwd){
    session_start();
    $userid = $_SESSION["userid"];
    $sql = "UPDATE users SET userPwd = ? WHERE userId = ?;";

    // preparing the stmt
    $stmt = mysqli_stmt_init($conn);
    // error
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../settings.php?error=stmtfailed");
        exit();
    }
    else { 
        // hashing the pwd
        $hashedPwd = password_hash($newpwd, PASSWORD_DEFAULT);

        mysqli_stmt_bind_param($stmt, "si", $hashedPwd, $userid);
        mysqli_stmt_execute($stmt);
    }
    mysqli_stmt_close($stmt);

    header("location: ../settings.php?error=none");
    exit();
}

function deleteUsr($conn, $pwd) {
    // Obtener la id de la session
    session_start();
    $userid = $_SESSION["userid"];

    $sql = "DELETE FROM users WHERE userId = ?;";
    // preparing the stmt
    $stmt = mysqli_stmt_init($conn);

    // error
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../settings.php?error=stmtfailed");
        exit();
    }
    else { 
        mysqli_stmt_bind_param($stmt, "i", $userid);
        mysqli_stmt_execute($stmt);
    }
    mysqli_stmt_close($stmt);

    header("location: ../includes/logout_inc.php");
    exit();
}

function get_full_info($conn, $isbn, $uid){
    // get the data from books table
    $query = mysqli_query($conn, "SELECT * FROM books WHERE isbn='$isbn';");
    $book_data = mysqli_fetch_array($query);

    $query_user = mysqli_query($conn, "SELECT * FROM books_users WHERE isbn='$isbn' AND userId='$uid';");
    $book_user_data = mysqli_fetch_array($query_user);

    // get reviews from books-users table
    $reviews = get_reviews($conn, $isbn);
    
    // get average rating
    //$avg_rating = get_avg_rating($reviews);       

    // get rating distribution
    //$distribution_ratings = get_distribution_ratings($reviews);

    $ret = array("title" => $book_data['title'], 
                "author" => $book_data['author'],
                "editorial" => $book_data['editorial'],
                "translator" => $book_data['translator'],
                "pages" => $book_data['pages'],
                "releaseDate" => $book_data['releaseDate'],
                "genres" => $book_data['genres'],
                "synopsis" => $book_data['synopsis'],
                "image" => $book_data['cover'],
                "pages_read" => $book_user_data == NULL ? '0' : $book_user_data['pages'],
                "rating" => $book_user_data == NULL ? NULL : $book_user_data['rating'],
                "list" => $book_user_data == NULL ? 'none' : $book_user_data['list'],
                "reviews" => $reviews, 
                /*"avg_rating" => $avg_rating,
"distribution_ratings" => $distribution_ratings*/);
    
    return $ret;
}

function get_overview_partial_info($conn, $isbn){
    // get the data from books table
    $query = mysqli_query($conn, "SELECT * FROM books WHERE isbn='$isbn';");
    $book_data = mysqli_fetch_array($query);

    
    $ret = array("title" => $book_data['title'],
                "image" => $book_data['cover']);
    return $ret;
}

function get_overview_full_info($conn, $isbn){
    $query = mysqli_query($conn, "SELECT * FROM books WHERE isbn='$isbn';");
    $book_data = mysqli_fetch_array($query);

    $ret = array("title" => $book_data['title'],
                "author" => $book_data['author'],
                /*"rating" => $book_data['rating'],*/
                "cover" => $book_data['cover']);
    return $ret;
}

function get_reviews($conn, $isbn) {
    $query = mysqli_query($conn, "SELECT * FROM books_users WHERE isbn='$isbn';");
    if (mysqli_num_rows($query) == 0) // no reviews
        return false;
    
    $rows = array();
    while($row = mysqli_fetch_array($query))
        $rows[] = $row;
        
    return $rows;
}

function get_avg_rating($reviews){
    $total = 0;
    $acc = 0;
    foreach($reviews as $value) {
        if ($value['rating'] != NULL){
            $acc += $value['rating'];
            ++$total;
        }
    }

    // calculating the avg
    $avg = acc / total;
    return round($avg, 1); // round to the first decimal 
}

function get_distribution_ratings($reviews){
    // 0.5 -> 1, 1 -> 2, 1.5 -> 3...
    $ret = array(1 => 0,
                2 => 0,
                3 => 0,
                4 => 0,
                5 => 0,
                6 => 0,
                7 => 0,
                8 => 0,
                9 => 0,
                10 => 0);

    foreach($reviews as $key => $value) {
        if ($value['rating'] != NULL){
            $rating_10 = round($value * 2, 0);
            ++$ret[$rating_10];
        }
    }
    return ret;
}

function get_url_export($url){
    $pfx = "https://drive.google.com/uc?export=view&id=";
    $start = 0; // position from which we take the id
    $num = 0; // num of slashes
    for($i = 0; $i < strlen($url); ++$i){
        if($url[$i] === '/'){
            ++$num;
            if($num === 5){
                $start = $i + 1;
            }
            else if($num === 6)
                $pfx .= substr($url, $start, ($i - $start));
        }
    }
    return $pfx;
}

function update_list($isbn, $conn, $list) {
    session_start();
    $userid = $_SESSION["userid"]; 
    if ($userid == 0)
        return false; // no está iniciada la sesión

    $query = mysqli_query($conn, "SELECT * FROM books_users WHERE userId = '$userid' AND isbn = '$isbn';");
    
    if (mysqli_num_rows($query) > 0) // already exists -> update
        $update = mysqli_query($conn, "UPDATE books_users SET list = '$list' WHERE userId = '$userid' AND isbn = '$isbn';");
    else // doesn't exist -> insert
        $insert = mysqli_query($conn, "INSERT INTO books_users (isbn, userId, list) VALUES ('$isbn', '$userid', '$list');");
    return true;
}

function update_pages_read($isbn, $conn, $pages) {
    session_start();
    $userid = $_SESSION["userid"]; 
    if ($userid == 0)
        return false; // no está iniciada la sesión
    $list = "reading";

    $query = mysqli_query($conn, "SELECT * FROM books_users WHERE userId = '$userid' AND isbn = '$isbn';");

    if (mysqli_num_rows($query) > 0) // already exists -> update
        $update = mysqli_query($conn, "UPDATE books_users SET pages = '$pages', list = '$list' WHERE userId = '$userid' AND isbn = '$isbn';");
    else // doesn't exist -> insert
        $insert = mysqli_query($conn, "INSERT INTO books_users (isbn, userId, pages, list) VALUES ('$isbn', '$userid', '$pages', '$list');");
    return true;    
}

function get_all_books($conn){
    $query = mysqli_query($conn, "SELECT * FROM books");
    $rows = array();
    while($row = mysqli_fetch_array($query))
        $rows[] = $row;
    return $rows;
}

function get_all_clubs($conn){
    $query = mysqli_query($conn, "SELECT * FROM clubs");
    $rows = array();
    while($row = mysqli_fetch_array($query))
        $rows[] = $row;
    return $rows;
}

function update_rating($isbn, $conn, $rating){
    session_start();
    $userid = $_SESSION["userid"]; 
    if ($userid == 0)
        return false; // no está iniciada la sesión
    $list = "read";

    $query = mysqli_query($conn, "SELECT * FROM books_users WHERE userId = '$userid' AND isbn = '$isbn';");

    if (mysqli_num_rows($query) > 0) // already exists -> update
        $update = mysqli_query($conn, "UPDATE books_users SET rating = '$rating', list = '$list' WHERE userId = '$userid' AND isbn = '$isbn';");
    else // doesn't exist -> insert
        $insert = mysqli_query($conn, "INSERT INTO books_users (isbn, userId, pages, rating, list) VALUES ('$isbn', '$userid', '$pages', '$rating','$list');");
    return true;
}

function get_username($conn, $uid){
    $query = mysqli_query($conn, "SELECT * FROM users WHERE userId = '$uid';");
    $rows = array();
    while($row = mysqli_fetch_array($query))
        $rows[] = $row;
    return $rows[0]['userUid'];
}

function add_review($isbn, $conn, $comment) {
    session_start();
    $userid = $_SESSION["userid"];
    if ($userid == 0)
        return false; // no está iniciada la sesión

    $query = mysqli_query($conn, "SELECT * FROM books_users WHERE userId = '$userid' AND isbn = '$isbn';");

    if (mysqli_num_rows($query) > 0) // already exists -> update
        $update = mysqli_query($conn, "UPDATE books_users SET review = '$comment' WHERE userId = '$userid' AND isbn = '$isbn';");
    else // doesn't exist -> insert
        $insert = mysqli_query($conn, "INSERT INTO books_users (isbn, userId, review) VALUES ('$isbn', '$userid', '$comment');");
    return true;    
}

function emptyInputAddBook($title, $author, $isbn, $editorial, $pages, $releaseDate, $genres, $synopsis){
    $result;
    if(empty($title) | empty($author) | empty($isbn) | empty($editorial) | empty($pages) | empty($releaseDate) | empty($genres) | empty($synopsis)){
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function isbnExists($conn, $isbn){
    $query = mysqli_query($conn, "SELECT * FROM books WHERE isbn = '$isbn';");
    if (mysqli_num_rows($query) == 0)
        return false;
    else 
        return true;
}

function addBook($conn, $title, $author, $isbn, $editorial, $translator, $pages, $releaseDate, $genres, $synopsis){
    $cover_default = "https://drive.google.com/file/d/1st4B4XoGTskNZtOcYvgYfFJt-jk8TFub/view?usp=sharing"; // the cover by default
    mysqli_query($conn, "INSERT INTO books (isbn, title, author, editorial, translator, pages, releaseDate, genres, synopsis, cover) VALUES ('$isbn', '$title', '$author', '$editorial', '$translator', '$pages', '$releaseDate', '$genres', '$synopsis', '$cover_default');");
}

function get_discussion($conn, $did) {
    $query = mysqli_query($conn, "SELECT * FROM discussions WHERE did = '$did'");
    return mysqli_fetch_array($query); // there is only one discussion with that id
}

function get_all_answers($conn, $did) {
    $query = mysqli_query($conn, "SELECT * FROM answers WHERE did = '$did' ORDER BY dateStamp DESC");
    $rows = array();
    while($row = mysqli_fetch_array($query))
        $rows[] = $row;
    return $rows;
}

function add_comment_discussion($conn, $did, $comment, $reply) {
    session_start();
    $uid = $_SESSION["userid"];
    if ($uid == 0)
        return false; // no está iniciada la sesión
    
    $date = date("Y-m-d H:i:s");
    $insert = mysqli_query($conn, "INSERT INTO answers (did, userUid, comment, answer, dateStamp) VALUES ('$did', '$uid', '$comment', '$reply', '$date');");
    return true;
}

function get_num_members($conn, $cid) {
    $query = mysqli_query($conn, "SELECT * FROM members WHERE cid = '$cid';");
    return mysqli_num_rows($query);
}

function get_last_modification($conn, $did) {
    $query = mysqli_query($conn, "SELECT * FROM answers WHERE did='$did' ORDER BY dateStamp DESC;");
    $answers_data = mysqli_fetch_array($query);
    $date = $answers_data[0]["dateStamp"];
    return $date;
}

function get_overview_info_discussion($conn, $did) {
    $query = mysqli_query($conn, "SELECT * FROM discussions WHERE did='$did';");
    $discussion_data = mysqli_fetch_array($query);

    $ret = array("creatorId" => $book_data['creatorId'],
                "name" => $book_data['name'], 
                "members" => get_members($conn, $did),
                "last_modification" => get_last_modification($conn, $did)
            );
    return $ret;
}

function is_moderator($conn, $cid, $userId) {
    return true;
}

function delete_comment($conn, $did, $aid) {
    return true;
}

// TO DO
function get_username_discussion($userid) {
    return "elena";
}

// TO DO
function get_last_update_discussion(){
    return "23/01/2023";
}