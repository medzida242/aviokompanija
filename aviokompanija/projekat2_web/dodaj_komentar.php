<?php
// Povezivanje s bazom podataka (prilagodite svoje podatke)
@include 'config.php';

// Provjera da li je forma submitovana
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $comment = $_POST["comment"];

    // Dohvati user_id na temelju korisničkog imena
    $sql = "SELECT id FROM user_form WHERE name = '$name'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['id'];

        // Dodaj komentar u bazu podataka
        $sql = "INSERT INTO comments (user_id, comment) VALUES ('$user_id', '$comment')";
        if ($conn->query($sql) === TRUE) {
            // Uspješno dodan komentar
            header("Location: forum.php");
            exit();
        } else {
            echo "Greška prilikom dodavanja komentara: " . $conn->error;
        }
    } else {
        echo "Korisnik nije pronađen.";
    }
}

$conn->close();
?>


