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
    if(empty($username) | empty($email)){
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
                "author" => $book_data['author'],
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
        return false; // not logged

    // to update the number of pages
    $query = mysqli_query($conn, "SELECT * FROM books WHERE isbn = '$isbn';");
    $book_info = mysqli_fetch_array($query);
    $max_pages = $book_info['pages'];

    $query = mysqli_query($conn, "SELECT * FROM books_users WHERE userId = '$userid' AND isbn = '$isbn';");

    if (mysqli_num_rows($query) > 0) // already exists -> update
        $update = mysqli_query($conn, "UPDATE books_users SET pages = '$max_pages', list = '$list' WHERE userId = '$userid' AND isbn = '$isbn';");
    else // doesn't exist -> insert
        $insert = mysqli_query($conn, "INSERT INTO books_users (isbn, userId, pages, list) VALUES ('$isbn', '$userid', '$max_pages', '$list');");
    
    $update = date("Y-m-d H:i:s");
    mysqli_query($conn, "UPDATE books_users SET dateStamp = '$update' WHERE userId = '$userid' AND isbn = '$isbn'");
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

function add_comment_discussion($conn, $did, $comment, $reply, $cid) {
    session_start();
    $uid = $_SESSION["userid"];
    if ($uid == 0)
        return false; // no está iniciada la sesión
    
    $date = date("Y-m-d H:i:s");
    $insert = mysqli_query($conn, "INSERT INTO answers (did, userUid, comment, answer, dateStamp, cid) VALUES ('$did', '$uid', '$comment', '$reply', '$date', '$cid');");
    return true;
}

function get_num_members($conn, $cid) {
    $query = mysqli_query($conn, "SELECT * FROM members WHERE cid = '$cid';");
    return mysqli_num_rows($query);
}

function get_last_modification_club($conn, $cid) {
    $query = mysqli_query($conn, "SELECT * FROM answers WHERE cid = '$cid' ORDER BY dateStamp DESC;");
    if (mysqli_num_rows($query) == 0)
        return false;

    $rows = array();
    while($row = mysqli_fetch_array($query))
        $rows[] = $row;
    return $rows[0]['dateStamp'];
}

function get_last_modification_discussion($conn, $did) {
    $query = mysqli_query($conn, "SELECT * FROM answers WHERE did = '$did' ORDER BY dateStamp DESC;");
    if (mysqli_num_rows($query) == 0)
        return false;

    $answers_data = mysqli_fetch_array($query);
    return $answers_data["dateStamp"];
}

function delete_comment($conn, $aid) {
    mysqli_query($conn, "DELETE FROM answers WHERE aid = '$aid';");
}

function get_info_clubs($conn, $cid){
    $query = mysqli_query($conn, "SELECT * FROM clubs WHERE cid='$cid';");
    if (mysqli_num_rows($query) == 0) // does not exist
        return false;

    $row = mysqli_fetch_array($query);
    return $row;
}

function get_book_info($conn, $current_book){
    $query = mysqli_query($conn, "SELECT * FROM books WHERE isbn='$current_book';");
    if (mysqli_num_rows($query) == 0) // does not exist
        return false;
    
    $row = mysqli_fetch_array($query);
    return $row;
}

function get_discussions($conn, $cid){
    $query = mysqli_query($conn, "SELECT * FROM discussions WHERE cid = '$cid';");
    $rows = array();
    while($row = mysqli_fetch_array($query))
        $rows[] = $row;
    return $rows;
}

function get_members($conn, $cid){
    $query = mysqli_query($conn, "SELECT * FROM members WHERE cid = '$cid';");
    if (mysqli_num_rows($query) == 0) // no reviews
        return false;
    
    $rows = array();
    while($row = mysqli_fetch_array($query))
        $rows[] = $row;
        
    return $rows;
}

function get_admins($conn, $cid){
    $query = mysqli_query($conn, "SELECT * FROM members WHERE cid = '$cid' AND typeMember = 'moderator';");
    if (mysqli_num_rows($query) == 0) // no reviews
        return false;
    
    $rows = array();
    while($row = mysqli_fetch_array($query))
        $rows[] = $row;

    return $rows;
}

function is_club_mod($conn, $cid) {  
    if (!session_id()) session_start();

    if (!isset($_SESSION['userid'])) // not logged
        return false; 
        
    $userid = $_SESSION['userid'];
    $query = mysqli_query($conn, "SELECT * FROM members WHERE cid = '$cid' AND userid = '$userid' AND typeMember = 'moderator';");

    if (mysqli_num_rows($query) > 0) // it's not a modetaror
        return true;
    else
        return false;
}

function join_club($conn, $cid) {
    if (!session_id()) session_start();

    if (!isset($_SESSION['userid'])) // not logged
        return false; 
    
    $userid = $_SESSION['userid'];
    $member_type = 'member'; // common member

    $exist = mysqli_query($conn, "SELECT * FROM members WHERE cid = '$cid' AND userid = '$userid';");

    // Get the previous number of members
    $query = mysqli_query($conn, "SELECT * FROM clubs WHERE cid = '$cid';");
    $club_info = mysqli_fetch_array($query);
    $numMembers = $club_info['numMembers'] + 1;

    // Update the number of members
    mysqli_query($conn, "UPDATE clubs SET numMembers = '$numMembers' WHERE cid = '$cid'");

    if (mysqli_num_rows($exist) <= 0) // does not exist 
        $query = mysqli_query($conn, "INSERT INTO members (cid, userid, typeMember) VALUES ('$cid', '$userid', '$member_type');");
        
    return true;
}

function emptyInputNameDesc($name, $desc){
    $result; 
    if (empty($name) | empty($desc)){
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function update_name_desc($conn, $cid, $name, $desc){
    mysqli_query($conn, "UPDATE clubs SET cname = '$name', descrip = '$desc' WHERE cid = '$cid';");
}

function update_current_book($conn, $cid, $currBook, $nextDate, $pages){
    mysqli_query($conn, "UPDATE clubs SET currBook = '$currBook', nextDate = '$nextDate', currPages = '$pages' WHERE cid = '$cid';");
}

function open_discussion($conn, $did){
    mysqli_query($conn, "UPDATE discussions SET opendis = '1' WHERE did = '$did';");
}

function close_discussion($conn, $did){
    mysqli_query($conn, "UPDATE discussions SET opendis = '0' WHERE did = '$did';");
}

function update_member_type($conn, $mid, $type){
    mysqli_query($conn, "UPDATE members SET typeMember = '$type' WHERE mid = '$mid';");
}

function delete_member($conn, $mid){
    mysqli_query($conn, "DELETE FROM members WHERE mid = '$mid';");
}

function quit_club($conn, $cid){
    if (!session_id()) session_start();

    if (!isset($_SESSION['userid'])) // not logged
        return false; 
    
    $userid = $_SESSION['userid'];
    $member_type = 'member'; // common member

    $exist = mysqli_query($conn, "SELECT * FROM members WHERE cid = '$cid' AND userid = '$userid';");

    if (mysqli_num_rows($exist) > 0) { // exists 
        $query = mysqli_query($conn, "DELETE FROM members WHERE cid = '$cid' AND userid = '$userid';");

        $query = mysqli_query($conn, "SELECT * FROM clubs WHERE cid = '$cid';");
        $club_info = mysqli_fetch_array($query);
        $numMembers = $club_info['numMembers'] + 1;

        mysqli_query($conn, "UPDATE clubs SET numMembers = '$numMembers' WHERE cid = '$cid';");
    }
    return true;
}

function is_club_member($conn, $cid){
    if (!session_id()) session_start();

    if (!isset($_SESSION['userid'])) // not logged
        return false; 
        
    $userid = $_SESSION['userid'];
    $query = mysqli_query($conn, "SELECT * FROM members WHERE cid = '$cid' AND userid = '$userid';");

    if (mysqli_num_rows($query) > 0) // it's not a member
        return true;
    else
        return false;
}

function add_discussion($conn, $cid, $topic){
    if (!session_id()) session_start();

    if (!isset($_SESSION['userid'])) // not logged
        return false; 
    
    $userid = $_SESSION['userid'];

    mysqli_query($conn, "INSERT INTO discussions (cid, creatorId, opendis, topic) VALUES ('$cid', '$userid', 1, '$topic');");
}

function get_profile_info($conn, $uid) {
    // The user's info
    $query = mysqli_query($conn, "SELECT * FROM users WHERE userId = '$uid';");
    $info_usr = mysqli_fetch_array($query);
    
    // The reading list
    $query = mysqli_query($conn, "SELECT * FROM books_users WHERE userId = '$uid' AND list = 'reading';");
    $info_reading = array();
    while($row = mysqli_fetch_array($query))
        $info_reading[] = $row;

    // The read list
    $query = mysqli_query($conn, "SELECT * FROM books_users WHERE userId = '$uid' AND list = 'read';");
    $info_read = array();
    while($row = mysqli_fetch_array($query))
        $info_read[] = $row;

    // The pending list
    $query = mysqli_query($conn, "SELECT * FROM books_users WHERE userId = '$uid' AND list = 'pending';");
    $info_pending = array();
    while($row = mysqli_fetch_array($query))
        $info_pending[] = $row;

    // The number of followers and followed
    $query = mysqli_query($conn, "SELECT * FROM followers WHERE follower = '$uid';");
    $num_followed = mysqli_num_rows($query);

    $query = mysqli_query($conn, "SELECT * FROM followers WHERE followed = '$uid';");
    $num_followers = mysqli_num_rows($query); 

    $ret = array(//"picture" => $info_usr["picture"], --> TO DO
                 "username" => $info_usr["userUid"],
                "reading" => $info_reading,
                "read" => $info_read,
                "pending" => $info_pending,
                "followers" => $num_followers,
                "followed" => $num_followed);
    return $ret;
}

function get_popular_books_friends($conn, $uid){
    $query = mysqli_query($conn, "SELECT * FROM followers WHERE follower = '$uid';");

    if(mysqli_num_rows($query) == 0){ // if the user doesnt have any friends
        return false;
    }

    $followed = array(); // ids of all the followed acc
    while($user = mysqli_fetch_array($query))
        $followed[] = $user;

    $data = array();
    foreach($followed as $user) { // loop though all the followed acc fav book
        $uid = $user['followed'];
        $query = mysqli_query($conn, "SELECT * FROM books_users WHERE userId = '$uid' AND list = 'read' ORDER BY dateStamp DESC LIMIT 1;");
        if(mysqli_num_rows($query) > 0) // has read books 
            $data[] = mysqli_fetch_array($query);
    }
    if(count($data) == 0){ // none of their friends have read any book
        return false;
    }

    $isbn = array();
    $user = array();
    foreach($data as $item){
        array_push($isbn, $item['isbn']);
        array_push($user, $item['userId']);
    }
    $ret = array("isbn" => $isbn, "user" => $user);
    return $ret;
}

function get_user_info($conn, $uid){
    $query = mysqli_query($conn, "SELECT * FROM users WHERE userId = '$uid';");

    $info_usr = mysqli_fetch_array($query);
    
    $ret = array("picture" => $info_usr["picture"], "username" => $info_usr["userUid"]);
    return $ret;
}

function get_popular_clubs_friends($conn, $uid){
    $query = mysqli_query($conn, "SELECT * FROM followers WHERE follower = '$uid';");

    if(mysqli_num_rows($query) == 0){ // if the user doesnt have any friends
        return false;
    }

    $followed = array(); // ids of all the followed acc
    while($user = mysqli_fetch_array($query))
        $followed[] = $user;

    $data = array();
    foreach($followed as $user) { // loop though all the followed acc clubs
        $uid = $user['followed'];
        $query = mysqli_query($conn, "SELECT * FROM members WHERE userid = '$uid' ORDER BY joinDate DESC LIMIT 1;");
        if(mysqli_num_rows($query) > 0) // is in club 
            $data[] = mysqli_fetch_array($query);
    }
    if(count($data) == 0){ // none of their friends are in clubs
        return false;
    }

    $club = array();
    foreach($data as $item){
        array_push($club, $item['cid']);
    }
    $ret = array("club" => $club);
    return $ret;
}

function get_popular_books($conn){
    $query = mysqli_query($conn, "SELECT DISTINCT isbn FROM books_users WHERE list = 'read' ORDER BY rating DESC LIMIT 10;");
    $books = array();
    while($book = mysqli_fetch_array($query))
        $books[] = $book['isbn'];

    return $books;
}

function get_popular_clubs($conn) {
    $query = mysqli_query($conn, "SELECT DISTINCT cid FROM clubs ORDER BY numMembers DESC LIMIT 10;");
    $clubs = array();
    while($club = mysqli_fetch_array($query))
        $clubs[] = $club['cid'];

    return $clubs;
}

function same_user($uid){
    if (!session_id()) session_start();

    if (!isset($_SESSION['userid'])) // not logged
        return true;
    
    $userid = $_SESSION['userid'];
    return $userid == $uid;
}

function is_following($conn, $uid, $fuid){
    $query = mysqli_query($conn, "SELECT * FROM followers WHERE follower= '$fuid' AND followed = '$uid';");

    if (mysqli_num_rows($query) > 0) // following
        return true;
    else
        return false;
}

function follow_user($conn, $follower, $followed){
    mysqli_query($conn, "INSERT INTO followers (follower, followed) VALUES ('$follower', '$followed');");
    mysqli_query($conn, "INSERT INTO notifications (userDest, userSrc, topic, alrdyRead) VALUES ('$followed', '$follower', 'users', '0');");
}

function unfollow_user($conn, $follower, $followed){
    mysqli_query($conn, "DELETE FROM followers WHERE follower = '$follower' AND followed = '$followed';");
}

function get_notifications($conn, $uid) {
    $query = mysqli_query($conn, "SELECT * FROM notifications WHERE userDest = '$uid' ORDER BY nid DESC;");

    $notifications = array();
    while($row = mysqli_fetch_array($query))
        $notifications[] = $row;

    $alrdyRead = 1;
    mysqli_query($conn, "UPDATE notifications SET alrdyRead = '$alrdyRead' WHERE userDest = '$uid';"); // The notifications are already read
    return $notifications;
}

function get_club_name($conn, $cid) {
    $query = mysqli_query($conn, "SELECT * FROM clubs WHERE cid = '$cid';");
    $rows = array();
    while($row = mysqli_fetch_array($query))
        $rows[] = $row;
    return $rows[0]['cname'];
}

function emptyInputAddEvent($title, $date, $hour, $place){
    $result;
    if(empty($title) | empty($date) | empty($hour) | empty($place)){
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function addEvent($conn, $title, $date, $hour, $place){
    if (!session_id()) session_start();
    $creatorUid = $_SESSION['userid'];
    $date_aux = date('Y-m-d H:i:s', strtotime("$date $hour"));
    mysqli_query($conn, "INSERT INTO events (title, dateStamp, place, uidCreator) VALUES ('$title', '$date_aux', '$place', '$creatorUid');");
}

function invalidDate($conn, $date, $hour) {
    $current_date = strtotime(date("Y-m-d H:i:s"));
    $event_date = strtotime("$date $hour");
    if($event_date < $current_date) return true;
    return false;
}

function isVerified($conn, $uid) {
    $query = mysqli_query($conn, "SELECT * FROM users WHERE userId = '$uid';");
    $rows = array();
    while($row = mysqli_fetch_array($query))
        $rows[] = $row;
    if($rows[0]['verified']){
        return true;
    }
    return false;
}

function get_my_events($conn, $uidCreator) {
    $query = mysqli_query($conn, "SELECT * FROM events WHERE uidCreator = '$uidCreator';");
    $rows = array();
    while($row = mysqli_fetch_array($query))
        $rows[] = $row;

    return $rows;
}

function deleteEvent($conn, $eid) {
    mysqli_query($conn, "DELETE FROM events WHERE eid = '$eid';");
}

function get_unread_notifications($conn, $uid){
    $query = mysqli_query($conn, "SELECT * FROM notifications WHERE userDest = '$uid' AND alrdyRead = '0';");
    return mysqli_num_rows($query);
}

function addClub($conn, $name, $desc, $currBook, $nextDate, $currPages){
    // 1) Add the club to the DB
    if (!session_id()) session_start();
    $uid = $_SESSION['userid']; // the creator

    $members = 1;
    mysqli_query($conn, "INSERT INTO clubs (cname, uidCreator, currBook, currPages, nextDate, descrip, numMembers) VALUES ('$name', '$uid', '$currBook', '$currPages', '$nextDate', '$desc', '$members');");

    // 2) Get the selected cid
    $query = mysqli_query($conn, "SELECT * FROM clubs WHERE cname = '$name' AND uidCreator = '$uid';");
    $row = mysqli_fetch_array($query);
    $cid = $row[0]['cid'];

    // 3) Add the user as an admin of the club 
    $member_type = 'moderator';
    mysqli_query($conn, "INSERT INTO members (cid, userid, typeMember) VALUES ('$cid', '$uid', '$member_type');");

    return $cid;
}

function is_open_discussion($conn, $did) {
    $query = mysqli_query($conn, "SELECT * FROM discussions WHERE did = '$did';");

    $rows = array();
    while($row = mysqli_fetch_array($query))
        $rows[] = $row;

    if($rows[0]['opendis']){
        return true;
    }
    return false;
}

function delete_notification($conn, $nid){
    mysqli_query($conn, "DELETE FROM notifications WHERE nid = '$nid';");
}

function emptyInputAskVerified($fullname){
    $result; 
    if (empty($fullname)){
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function ask_verified($conn, $fullname, $motivation){
    if (!session_id()) session_start();
    $uid = $_SESSION['userid']; 

    mysqli_query($conn, "INSERT INTO requests (userid, fullname, motivation) VALUES ('$uid', '$fullname', '$motivation');");
}

function isAdmin($conn, $uid){
    $query = mysqli_query($conn, "SELECT * FROM users WHERE userId = '$uid';");
    $rows = array();
    while($row = mysqli_fetch_array($query))
        $rows[] = $row;
    if($rows[0]['administrator']){
        return true;
    }
    return false;
}

function get_all_requests($conn) {
    $query = mysqli_query($conn, "SELECT * FROM requests");
    $rows = array();
    while($row = mysqli_fetch_array($query))
        $rows[] = $row;
    return $rows;
}

function accept_request($conn, $rid, $uid){
    // First update the users table 
    mysqli_query($conn, "UPDATE users SET verified = 1 WHERE userId = '$uid';");

    // Second delete the request
    delete_request($conn, $rid);
}

function delete_request($conn, $rid){
    mysqli_query($conn, "DELETE FROM requests WHERE rid = '$rid';");
}

function get_all_events($conn){
    $query = mysqli_query($conn, "SELECT * FROM events ORDER BY dateStamp ASC");

    $rows = array();
    while($row = mysqli_fetch_array($query))
        $rows[] = $row;

    return $rows;
}

function is_assistant($conn, $eid, $uid){
    $query = mysqli_query($conn, "SELECT * FROM assistants WHERE eid = '$eid' AND userid = '$uid';");

    if (mysqli_num_rows($query) > 0) // it's not an assistant yet
        return true;
    else
        return false;
}

function asssit_event($conn, $eid, $uid) {
    mysqli_query($conn, "INSERT INTO assistants (eid, userid) VALUES ('$eid', '$uid');");
}

function quit_event($conn, $eid, $uid) {
    mysqli_query($conn, "DELETE FROM assistants WHERE eid = '$eid' AND userid = '$uid';");
}