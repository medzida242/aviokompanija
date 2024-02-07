<?php
@include 'config.php';

// Obrada zahtjeva brisanja leta
if (isset($_POST['delete_flight'])) {
    $flightId = $_POST['delete_flight'];

    // Izvrši SQL upit za brisanje leta
    $sql = "DELETE FROM events WHERE events_id = '$flightId'";

    if ($conn->query($sql) === TRUE) {
        echo "Let je uspješno izbrisan.";
    } else {
        echo "Greška prilikom brisanja leta: " . $conn->error;
    }
}

// Obrada zahtjeva unosa leta
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Dohvati podatke iz poslanog obrasca
    $departure = isset($_POST['departure']) ? $_POST['departure'] : '';
    $arrival = isset($_POST['arrival']) ? $_POST['arrival'] : '';
    $destination = isset($_POST['destination']) ? $_POST['destination'] : '';
    $price = isset($_POST['price']) ? $_POST['price'] : '';
    $available = isset($_POST['available']) ? $_POST['available'] : '';

    // Provera da li su svi potrebni podaci uneti
    if ($departure && $arrival && $destination && $price && $available) {
        // Pripremi SQL upit za unos leta
        $sql = "INSERT INTO events (departure, arrival, destination, price, available)
                VALUES ('$departure', '$arrival', '$destination', '$price', '$available')";

        if ($conn->query($sql) === TRUE) {
            echo "Let je uspješno dodan.";
        } else {
            echo "Greška prilikom unosa leta: " . $conn->error;
        }
    } else {
        echo "Molimo unesite sve potrebne podatke.";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="uredi_letove.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Pacifico:wght@300;400;700&display=swap">
  <header>
    <nav>
      <ul>
        <li><a href="projekat2.html">Pocetna</a></li>
        <li><a href="admin_page.php">Admin opcije</a></li>
        <li><a href="logout.php">Odjava</a></li>
      </ul>
    </div>
    </nav>
  </header>

  <title>Unos letova</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 20px;
    }

    label, input, select {
      display: block;
      margin-bottom: 20px;
    }
/*
    input[type="submit"] {
      padding: 10px;
    } */
  </style>
</head>
<body>
  <h1>Unos letova</h1>

  <form method="post" action="unosLetova.php">
    <label for="departure">Datum polaska:</label>
    <input type="date" id="departure" name="departure" required>

    <label for="arrival">Datum dolaska:  </label>
    <input type="date" id="arrival" name="arrival" required>

    <label for="destination">Odredište:  </label>
    <input type="text" id="destination" name="destination" required>

    <label for="price">Cijena: </label>
    <input type="text" id="price" name="price" required>

    <label for="available">Dostupno: </label>
    <input type="text" id="available" name="available" required>

    <input type="submit" value="Unesi let">
  </form>

  <h2>Letovi</h2>
  <?php
  // Dohvati letove iz baze podataka
  $sql = "SELECT * FROM events";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          echo '<div class="flight">';
          echo '<div class="flight-details">';
          echo '<span>Let broj: ' . $row['events_id'] . '</span>';
          echo '<span>Polazak: ' . $row['departure'] . '</span>';
          echo '<span>Dolazak: ' . $row['arrival'] . '</span>';
          echo '<span>Destinacija: ' . $row['destination'] . '</span>';
          echo '<span>Cijena: ' . $row['price'] . '</span>';
          echo '</div>';
          echo '<div class="delete-button">';
          echo '<form method="post">';
          echo '<input type="hidden" name="delete_flight" value="' . $row['events_id'] . '">';
          echo '<input type="submit" value="Izbriši">';
          echo '</form>';
          echo '</div>';
          echo '</div>';
      }
  } else {
      echo 'Nema dostupnih letova.';
  }

  // Zatvori vezu s bazom podataka
  $conn->close();
  ?>
</body>
</html>



