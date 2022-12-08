<?php

class Book {
    // book isbn
    private $isbn;

    // queries
	private $conn;

    public function __construct($conn, $isbn){
		$this->conn = $conn;
        $this->isbn = $isbn;      
	}

    public function get_full_info(){
		// get the data from books table
        $query = mysqli_query($this->conn, "SELECT * FROM books WHERE isbn='$isbn'");
        $book_data = mysqli_fetch_array($query);

        // get reviews from books-users table
        $reviews = get_reviews();
        
        // get average rating
        $avg_rating = get_avg_rating($reviews);       

        // get rating distribution
        $distribution_ratings = get_distribution_ratings($reviews);

        $ret = array("title" => $book_data['title'], 
                    "author" => $book_data['author'],
                    "editorial" => $book_data['editorial'],
                    "translator" => $book_data['translator'],
                    "pages" => $book_data['pages'],
                    "releaseDate" => $book_data['releaseDate'],
                    "genres" => $book_data['genres'],
                    "synopsis" => $book_data['synopsis'],
                    "image" => $book_data['cover'],
                    "reviews" => $reviews, 
                    "avg_rating" => $avg_rating,
                    "distribution_ratings" => $distribution_ratings);
        
        return $ret;
	}

    public function get_overview_partial_info(){
		// get the data from books table
        $query = mysqli_query($this->conn, "SELECT * FROM books WHERE isbn='$isbn'");
        $book_data = mysqli_fetch_array($query);

        
        $ret = array("title" => $book_data['title'],
                    "image" => $book_data['cover']);
        return $ret;
	}

    public function get_overview_full_info(){
        $query = mysqli_query($this->conn, "SELECT * FROM books WHERE isbn='$isbn'");
        $book_data = mysqli_fetch_array($query);

        $ret = array("title" => $book_data['title'],
                    "author" => $book_data['author'],
                    "rating" => $book_data['rating'],
                    "cover" => $book_data['cover']);
        return $ret;
    }

    private function get_reviews() {
        $query = mysqli_query($this->conn, "SELECT * FROM books WHERE isbn='$isbn'");
        $reviews = mysqli_fetch_array($query);
        return $reviews;
    }

    private function get_avg_rating($reviews){
        $total = 0;
        $acc = 0;
        foreach($reviews as $key => $value) {
            if ($value['rating'] != NULL){
                $acc += $value['rating'];
                ++$total;
            }
        }

        // calculating the avg
        $avg = acc / total;
        return round($avg, 1); // round to the first decimal 
    }

    private function get_distribution_ratings($reviews){
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
                    10 => 0,);

        foreach($reviews as $key => $value) {
            if ($value['rating'] != NULL){
                $rating_10 = round($value * 2, 0);
                ++$ret[$rating_10];
            }
        }
        return ret;
    }
}