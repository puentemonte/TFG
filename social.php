<?php
    include_once 'header.php';
    require_once "./includes/dbh_inc.php";
    require_once "./includes/functions_inc.php"; 

	/*
	En social se muestran: 
	- Los libros más populares --> los que tienen mejor nota en general
	- Los clubes más populares --> los que tienen más miembros

	Si el usuario ha iniciado sesión entonces se le muestran:
	- Los libros que están leyendo sus amigos --> son amigos y tienen los libros en read
	- Los clubes en los que están sus amigos --> son amigos y está en algún club
	
	Casos límite:
	- El usuario no tiene amigos -> solo se muestran los populares
	- Ningún amigo del usuario ha leído ningún libro -> solo se muestran los populares

	Ahora los populares en general van en Inicio

	*/

	echo "<div class='mt-custom text-center'>
        <h2 class='h3 mb-3 fw-normal'>Social</h2>
    </div>
    <div class='container'>";

	if(isset($_SESSION["userid"])){ 
		$uid = $_SESSION["userid"];
		
		// Libros
		$popular_books_friends = get_popular_books_friends($conn, $uid);
		
		if($popular_books_friends !== false){
			echo "<div class='row'>
					<div class='col'>
						<h4 class='h4 mb-3 fw-normal'>Tus amigos han leído...</h4>
						<div class='row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-md-4 row-cols-md-5 g-5 text-center'>";
			$books = $popular_books_friends['isbn'];
			$users = $popular_books_friends['user'];
			foreach($books as $index => $book) {
				$book_info = get_book_info($conn, $book);
				$isbn = $book;
				$title = $book_info['title'];
				$author = $book_info['author'];
				$cover = $book_info['cover'];
				$cover_url = get_url_export($cover);

				$user = $users[$index];
				$user_info = get_user_info($conn, $user);
				$username = $user_info['username'];

				echo "<div class='col'>
						<div class='row'>
							<div class='col-2'>
								<img class='social-picture' src='style/img/color-beige.png' alt ='picture'>
							</div>
							<div class='col-4 username-overview'>";
								if (isVerified($conn, $user)){
									echo "<p class='card-text'><a class='profile-link' href=profile.php?uid=$user><b>@$username</b> <i class = 'fa-solid fa-circle-check icon-verified-search'></i></a> ha leído:</p>";
								}
								else{
									echo "<p class='card-text'><a class='profile-link' href=profile.php?uid=$user><b>@$username</b></a> ha leído:</p>";
								}
								
						echo "</div>
						</div>
						<div class='row'>
							<a class='dropdown-item' href='book.php?isbn=$isbn'>
								<div class='card shadow-sm'>
									<img class='bd-placeholder-img card-img-top' src='$cover_url' alt ='$title'>
									<div class='card-body'>
										<p class='card-text'>$title</p>
										<small class='text-muted'>$author</small>
									</div>
								</div>
							</a>
						</div>
					</div>";
			}
			echo "</div>
				</div>
			</div>";
		}

		// Clubes
		$popular_clubs_friends = get_popular_clubs_friends($conn, $uid);

		if($popular_clubs_friends !== false){
			echo "<div class='row'>
					<div class='col'>
						<h4 class='h4 mb-3 fw-normal mt-custom'>Tus amigos pertenecen a...</h4>
								<div class='row ml-club mr-club club-desc'>
									<div class='col text-center'>
										<table class='table'>
											<thead>
												<tr>
													<th scope='col'>Nombre</th>
													<th scope='col'>Creador</th>
													<th scope='col'>Número de miembros</th>
													<th scope='col'>Última publicación</th>
												</tr>
											</thead>
											<tbody>";
			$clubs = $popular_clubs_friends['club'];

			foreach($clubs as $index => $club) {
				$club_data = get_info_clubs($conn, $club);
				$cid = $club;
				$name = $club_data['cname'];
				$creator = get_username($conn, $club_data['uidCreator']);
				$creator_uid = $club_data['uidCreator'];
				$num_members= get_num_members($conn, $cid);
				$last_modification = get_last_modification_club($conn, $cid);
				if ($last_modification == NULL)
					$last_modification = "-";

				echo "<tr>
					<td><a class='profile-link' href='club.php?id=$cid'>$name</a></td>
					<td><a class='profile-link' href='profile.php?uid=$creator_uid'>@$creator</a></td>
					<td>$num_members</td>
					<td>$last_modification</td>
				</tr>";
			}

			echo "</tbody>
				</table>
			</div>
		</div>
	</div>
</div>";
		}
	}
	else {
		// Si el usuario no ha iniciado sesión se le lleva a la página de login
		header("location: ./login.php");
	}

    include_once 'footer.php';
?>