function buyTicket(eventsId) {

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {

      if (xhr.readyState === 4) {
        if (xhr.status === 200) {
          alert('Uspješno ste kupili kartu!');
        } else {
          alert('Došlo je do greške prilikom kupovine karte.');
        }
      }
    };

    xhr.open('POST', 'letovi.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send('events_id=' + eventsId);
  }