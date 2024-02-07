<?php
// Povezivanje s bazom podataka (prilagodite svoje podatke)
@include 'config.php';

// Provjera da li je forma submitovana
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["name"];
    $comment = $_POST["comment"];

    // Dodavanje komentara u bazu podataka
    $sql = "INSERT INTO comments (user_id, comment) VALUES ('$username', '$comment', NOW())";
    if ($conn->query($sql) === TRUE) {
        // Uspješno dodan komentar
        header("Location: forum.php");
        exit();
    } else {
        echo "Greška prilikom dodavanja komentara: " . $conn->error;
    }
}

// Dohvatanje postojećih komentara iz baze podataka
$sql = "SELECT comments.comment, user_form.name FROM comments INNER JOIN user_form ON comments.user_id = user_form.id";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
  <title>Forum</title>
  <link rel="stylesheet" type="text/css" href="forum.css">

</head>
<body>
<header>
    <nav>
      <ul>
        <li><a href="projekat2.html">Pocetna</a></li>
        <li><a href="user_page.php">Korisnik opcije</a></li>
        <li><a href="logout.php">Odjava</a></li>
      </ul>
    </div>
    </nav>
  </header>
  <h1>Forum</h1>

  <!-- Forma za unos novog komentara -->
  <form action="dodaj_komentar.php" method="POST">
    <label for="name">Korisničko ime:</label>
    <input type="text" id="name" name="name" required><br>
<br>
    <label for="comment">Komentar:</label>
    <textarea id="comment" name="comment" required></textarea><br>
<br>
    <button type="submit">Objavi komentar</button>
  </form>
<br>
  <!-- Prikaz postojećih komentara -->
  <div id="comments">
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="comment">';
            echo '<span class="user">' . $row['name'] . '</span>';
            //echo '<span class="timestamp">' . $row['timestamp'] . '</span>';
            echo '<div class="content">' . $row['comment'] . '</div>';
            echo '</div>';
        }
    } else {
        echo 'Nema dostupnih komentara.';
    }
    ?>
  </div>

  <script src="forum.js"></script>
</body>
</html>
