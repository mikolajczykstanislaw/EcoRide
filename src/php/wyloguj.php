<?php
session_start();
session_unset(); // Usuń wszystkie zmienne sesji
session_destroy(); // Zakończ sesję

header("Location: ../../index.html");
exit();
?>