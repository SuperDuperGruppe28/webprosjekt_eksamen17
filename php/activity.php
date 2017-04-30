<?php
require_once __DIR__ . '/../database/tools/bruker.php';

$bruker = loggetInnBruker();

// Om bruker er logget inn
if($bruker)
{
   
  
}else
{
    echo "<h1>Må være logget inn!</h1>";
}