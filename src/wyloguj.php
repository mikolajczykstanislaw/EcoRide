<?php
session_start();
session_unset(); // Usuń wszystkie zmienne sesji
session_destroy(); // Zakończ sesję

header("Location: http://localhost/EcoRide-main/index.html?");
exit();
?>