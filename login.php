<!-- includes/header.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>GJRTI International Research Symposium 2026</title>
    <meta name="description" content="GJRTI International Research Symposium 2026">

    <!-- Alpine.js for dropdowns -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#29147d',
                        accent: '#c0a35c',
                        blue: '#107cc0',
                        warmblue: '#047bc2',
                        lightblue: '#84bde0',
                        purple: '#2b1c60',
                        softpurple: '#9386bc',
                        lightbg: '#e2f1fa',
                        richpurple: '#2a1572',
                        warmgold: '#c0a064',
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
        }

        .mobile-menu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease-out;
        }

        .mobile-menu.active {
            max-height: 600px;
        }
    </style>
</head>

<!-- COMPACT LOGIN FORM -->
<section class="py-16 bg-lightbg">
    <div class="max-w-md mx-auto px-6">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Mini Header -->
            <div class="bg-gradient-to-r from-primary to-richpurple text-white py-8 text-center">
                <img src="assets/img/logo.png" alt="GJRTI" class="h-16 mx-auto mb-3">
                <h2 class="text-2xl font-bold">Symposium Login</h2>
            </div>

            <form class="p-8 space-y-6">
                <!-- Email -->
                <div>
                    <input type="email" name="email" required placeholder="Email Address"
                        class="w-full px-5 py-4 border border-gray-300 rounded-lg focus:border-accent focus:outline-none text-lg">
                </div>

                <!-- Password -->
                <div>
                    <input type="password" name="password" required placeholder="Password"
                        class="w-full px-5 py-4 border border-gray-300 rounded-lg focus:border-accent focus:outline-none text-lg">
                </div>

                <!-- Remember + Forgot -->
                <div class="flex justify-between text-sm">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" class="w-4 h-4 text-accent rounded">
                        <span class="text-gray-600">Remember me</span>
                    </label>
                    <a href="forgot-password.php" class="text-accent hover:underline">Forgot?</a>
                </div>

                <!-- Login Button -->
                <button type="submit"
                    class="w-full bg-accent text-primary py-4 rounded-lg text-xl font-bold hover:bg-warmgold transition shadow-lg">
                    Login
                </button>

                <!-- Register Link -->
                <p class="text-center text-sm text-gray-600">
                    No account?
                    <a href="signup.php" class="text-accent font-bold hover:underline">Register here</a>
                </p>
            </form>
        </div>

        <!-- Back Link -->
        <div class="text-center mt-8">
            <a href="index.php" class="text-sm text-primary hover:text-accent flex items-center justify-center gap-1">
                ← Back to Home
            </a>
        </div>
    </div>
</section>