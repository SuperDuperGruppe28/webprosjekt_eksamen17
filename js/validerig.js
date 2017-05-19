// Validerer input i logginnboks
function validerLogginn()
{
    var bruker = document.forms["form_logginn"]["bruker"].value;
    var passord = document.forms["form_logginn"]["passord"].value;
    
    if(bruker === "" || bruker.length > 30)
    {
        alert("Skriv inn brukernavn ordentlig!");
        return false;
    }
        
    if(passord === "" || passord.length > 60)
    {
        alert("Skriv inn passord ordentlig!");
        return false;
    }
}

// Validerer input i logginnboks
function validerBrukerRegistrering()
{
    var bruker = document.forms["form_reg"]["bruker"].value;
    var passord = document.forms["form_reg"]["passord"].value;
    var email = document.forms["form_reg"]["email"].value;
    
    if(bruker === "" || bruker.length > 30)
    {
        alert("Skriv inn brukernavn ordentlig!");
        return false;
    }
    
    if(email === "" || email.length > 70)
    {
        alert("Skriv inn email ordentlig!");
        return false;
    }
        
    if(passord === "" || passord.length > 60)
    {
        alert("Skriv inn passord ordentlig!");
        return false;
    }
}

// Validerer input i logginnboks
function valdierAktivitet()
{
    var tittel = document.forms["form_reg"]["bruker"].value;
    var passord = document.forms["form_reg"]["passord"].value;
    var email = document.forms["form_reg"]["email"].value;
    
    if(bruker === "" || bruker.length > 30)
    {
        alert("Skriv inn brukernavn ordentlig!");
        return false;
    }
    
    if(email === "" || email.length > 70)
    {
        alert("Skriv inn email ordentlig!");
        return false;
    }
        
    if(passord === "" || passord.length > 60)
    {
        alert("Skriv inn passord ordentlig!");
        return false;
    }
}