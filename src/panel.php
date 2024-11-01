<?php
session_start(); // Rozpocznij sesję, aby mieć dostęp do danych sesji

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['user_id'])) {
    header("Location: logowanie.html?error=Musisz być zalogowany, aby uzyskać dostęp do tej strony.");
    exit();
}

$imie = $_SESSION['user_imie'];
?>

<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>EcoRide</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            primary: "#4CAF50", // oryginalny kolor
                            "primary-dark": "#388E3C", // ciemniejszy odcień
                        },
                    },
                },
            };
        </script>
    </head>
    <body>
        <header>
            <nav class="bg-white shadow">
                <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
                    <div class="relative flex items-center justify-between h-16">
                        <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                            <button
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white"
                                aria-controls="mobile-menu"
                                aria-expanded="false"
                            >
                                <span class="sr-only">Otwórz menu</span>
                                <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                                </svg>
                                <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <div class="flex-1 flex items-center justify-between sm:items-stretch">
                            <div class="hidden sm:flex sm:flex-shrink-0">
                                <h1 class="text-2xl font-bold text-gray-800">
                                    <span class="text-primary">Eco</span>Ride
                                </h1>
                            </div>
                            <div class="hidden sm:block sm:ml-6">
                                <div class="flex items-center space-x-4">
                                    <a href="#" class="text-gray-600 hover:bg-gray-200 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">Wspólne przejazdy</a>
                                    <a href="#" class="text-gray-600 hover:bg-gray-200 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">O nas</a>
                                    <a href="#" class="text-gray-600 hover:bg-gray-200 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">Usługi</a>
                                    <a href="#" class="text-gray-600 hover:bg-gray-200 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">Kontakt</a>
                                </div>
                            </div>
                            <div class="ml-auto hidden sm:block">
                                <a href="wyloguj.php" class="hover:bg-gray-200 px-3 py-2 rounded-md text-sm font-medium bg-primary text-white px-4 py-2 rounded w-full hover:bg-primary-dark transition duration-200">Wyloguj Się</a>
                                <input type="text" placeholder="Szukaj..." class="border border-gray-300 rounded-md py-1 px-2 focus:outline-none focus:ring focus:ring-indigo-500" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sm:hidden" id="mobile-menu">
                    <div class="px-2 pt-2 pb-3 space-y-1">
                        <a href="#" class="text-gray-600 hover:bg-gray-200 hover:text-gray-900 block px-3 py-2 rounded-md text-base font-medium">Wspólne przejazdy</a>
                        <a href="#" class="text-gray-600 hover:bg-gray-200 hover:text-gray-900 block px-3 py-2 rounded-md text-base font-medium">O nas</a>
                        <a href="#" class="text-gray-600 hover:bg-gray-200 hover:text-gray-900 block px-3 py-2 rounded-md text-base font-medium">Usługi</a>
                        <a href="#" class="text-gray-600 hover:bg-gray-200 hover:text-gray-900 block px-3 py-2 rounded-md text-base font-medium">Kontakt</a>
                        <a href="wyloguj.php" class="text-gray-600 hover:bg-gray-200 hover:text-gray-900 block px-3 py-2 rounded-md text-base font-medium">Wyloguj Się</a>
                        <div class="mt-2">
                            <input type="text" placeholder="Szukaj..." class="border border-gray-300 rounded-md py-1 px-2 focus:outline-none focus:ring focus:ring-indigo-500 w-full" />
                        </div>
                    </div>
                </div>
            </nav>

            <div class="relative h-screen bg-cover bg-center" style="background-image: url('img/header-image.jpeg')">
                <div class="flex items-center justify-center h-full bg-black bg-opacity-50">
                    <div class="bg-white p-6 rounded-lg shadow-lg space-y-4 w-3/4 md:w-1/2 lg:w-1/3">
                        <h1 class="text-center font-semibold">Witaj, <?php echo htmlspecialchars($imie); ?>!</h1>
                        <h2 class="text-xl font-bold text-center mb-4">Znajdź przejazd</h2>
                        <div class="flex flex-col space-y-4">
                            <input type="text" placeholder="Skąd" class="border border-gray-300 p-2 rounded w-full" />
                            <input type="text" placeholder="Dokąd" class="border border-gray-300 p-2 rounded w-full" />
                            <input type="date" class="border border-gray-300 p-2 rounded w-full" />
                        </div>
                        <button class="bg-primary text-white px-4 py-2 rounded w-full hover:bg-primary-dark transition duration-200">Szukaj</button>
                    </div>
                </div>
            </div>
        </header>
                
        <script src="src/script.js"></script>
    </body>
</html>

