// Validerer input i logginnboks
function validerLogginn() {
    var bruker = document.forms["form_logginn"]["bruker"].value;
    var passord = document.forms["form_logginn"]["passord"].value;

    if (bruker === "" || bruker.length > 30) {
        alert("Skriv inn brukernavn ordentlig!");
        return false;
    }

    if (passord === "" || passord.length > 60) {
        alert("Skriv inn passord ordentlig!");
        return false;
    }
}

// Validerer input i registreing av bruker
function validerBrukerRegistrering() {
    var bruker = document.forms["form_reg"]["bruker"].value;
    var passord = document.forms["form_reg"]["passord"].value;
    var email = document.forms["form_reg"]["email"].value;

    if (bruker === "" || bruker.length > 30) {
        alert("Skriv inn brukernavn ordentlig!");
        return false;
    }

    if (email === "" || email.length > 70) {
        alert("Skriv inn email ordentlig!");
        return false;
    }

    if (passord === "" || passord.length > 60) {
        alert("Skriv inn passord ordentlig!");
        return false;
    }
}

// Validerer input i aktivitet
function valdierAktivitet() {
    var tittel = document.forms["form_aktivitet"]["tittel"].value;
    var beskrivelse = document.forms["form_aktivitet"]["beskrivelse"].value;
    var pris = document.forms["form_aktivitet"]["pris"].value;
    var bilde = document.forms["form_aktivitet"]["bilde"].value;

    if (tittel === "" || tittel.length > 45) {
        alert("Skriv inn tittel ordentlig!");
        return false;
    }

    if (beskrivelse === "" || beskrivelse.length > 1024) {
        alert("Skriv inn beskrivelse ordentlig!");
        return false;
    }

    if (bilde === "" || bilde.length > 512) {
        alert("Skriv inn bildeURL ordentlig!");
        return false;
    }

    if (pris < 0 || pris > 100000) {
        alert("Skriv inn pris ordentlig!");
        return false;
    }
}

// Validerer input i kommentar
function validerKommentar() {
    var tekst = document.forms["form_kommentar"]["tekst"].value;
  
    if (tekst === "" || tekst.length > 512) {
        alert("Kommentaren kan ikke overskride 512 bokstaver, eller være tom!");
        return false;
    }

}