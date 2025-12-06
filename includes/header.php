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

<body class="bg-lightbg text-gray-900 min-h-screen flex flex-col">

  <!-- TOP BAR: Login & Sign Up -->
  <div class="bg-richpurple text-white py-2.5 text-sm border-b border-white/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 flex justify-end items-center space-x-4">
      <a href="login.php" class="hover:text-accent transition-colors duration-200 flex items-center">
        Login
      </a>
      <span class="text-gray-400">|</span>
      <a href="signup.php" class="hover:text-accent font-semibold transition-colors duration-200 flex items-center">
        Sign Up
      </a>
    </div>
  </div>

  <!-- MAIN HEADER -->
  <header class="bg-white shadow-2xl relative z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-5">
      <div class="flex justify-between items-center">

        <a href="index.php" class="flex items-center space-x-4 sm:space-x-6 flex-1 group">
          <img src="assets/img/logo.png" alt="GJRTI Logo"
            class="h-14 sm:h-16 md:h-20 w-auto object-contain transition-transform">
          <div class="flex-1 min-w-0">
            <h1 class="text-lg sm:text-xl md:text-3xl font-bold leading-tight text-primary transition-colors">
              GJRTI 3rd International Research Symposium 2025
            </h1>

          </div>
        </a>

        <!-- Desktop Navigation -->
        <nav class="hidden lg:flex items-center space-x-2 ml-8">
          <a href="index.php" class="px-5 py-3 hover:bg-softpurple/10 rounded-lg transition-all font-bold text-primary">
            Home
          </a>

          <!-- REGISTRATION DROPDOWN – CLEAN & MINIMAL (Only Page Names) -->
          <div x-data="{ open: false }" class="relative" @click.outside="open = false">
            <button @click="open = !open"
              class="px-5 py-3 bg-white text-primary rounded-lg hover:bg-softpurple/10 transition-all font-bold flex items-center space-x-2">
              <span>Registration</span>
              <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
              </svg>
            </button>

            <!-- Clean Dropdown – Only Names -->
            <div x-show="open"
              x-transition:enter="transition ease-out duration-200"
              x-transition:enter-start="opacity-0 scale-95 translate-y-2"
              x-transition:enter-end="opacity-100 scale-100 translate-y-0"
              x-transition:leave="transition ease-in duration-150"
              x-transition:leave-end="opacity-0 scale-95 translate-y-2"
              class="absolute top-full left-1/2 -translate-x-1/2 mt-4 w-64 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden z-50"
              style="display: none">

              <div class="py-3">
                <a href="registration-guideline.php"
                  class="block px-6 py-4 text-primary hover:bg-softpurple/10 transition-all font-medium text-base">
                  Registration Guideline
                </a>
                <a href="registration-fee.php"
                  class="block px-6 py-4 text-primary hover:bg-softpurple/10 transition-all font-medium text-base">
                  Registration Fee
                </a>
                <a href="signup.php"
                  class="block px-6 py-4 text-primary hover:bg-softpurple/10 transition-all font-medium text-base bg-accent/5">
                  Online Registration
                </a>
              </div>
            </div>
          </div>
          <!-- END CLEAN DROPDOWN -->


          <!-- ABSTRACT SUBMISSION DROPDOWN – CLEAN & MINIMAL -->
          <div x-data="{ open: false }" class="relative" @click.outside="open = false">
            <button @click="open = !open"
              class="px-5 py-3 bg-white text-primary rounded-lg hover:bg-softpurple/10 transition-all font-bold flex items-center space-x-2">
              <span>Abstract Submission</span>
              <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
              </svg>
            </button>

            <div x-show="open"
              x-transition:enter="transition ease-out duration-200"
              x-transition:enter-start="opacity-0 scale-95 translate-y-2"
              x-transition:enter-end="opacity-100 scale-100 translate-y-0"
              x-transition:leave="transition ease-in duration-150"
              x-transition:leave-end="opacity-0 scale-95 translate-y-2"
              class="absolute top-full left-1/2 -translate-x-1/2 mt-4 w-80 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden z-50"
              style="display: none">
              <div class="py-3">
                <a href="submit-abstract.php#themes" class="block px-6 py-4 text-primary hover:bg-softpurple/10 transition-all font-medium">Abstract Themes</a>
                <a href="submit-abstract.php#poster" class="block px-6 py-4 text-primary hover:bg-softpurple/10 transition-all font-medium">Poster Presentation Upload</a>
                <a href="submit-abstract.php#oral" class="block px-6 py-4 text-primary hover:bg-softpurple/10 transition-all font-medium bg-accent/5">Oral Presentation Upload</a>
              </div>
            </div>
          </div>
          <a href="contact.php" class="px-5 py-3 hover:bg-softpurple/10 rounded-lg transition-all font-bold text-primary">
            Contact Us
          </a>
        </nav>

        <!-- Mobile Menu Button -->
        <button id="mobile-menu-btn" class="lg:hidden ml-4 p-3 hover:bg-gray-100 rounded-lg transition-colors">
          <svg class="w-7 h-7 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
      </div>

      <!-- Mobile Navigation -->
      <nav id="mobile-menu" class="mobile-menu lg:hidden mt-4">
        <div class="pt-4 pb-2 space-y-2 border-t border-gray-200">
          <a href="index.php" class="block px-4 py-3 hover:bg-gray-50 rounded-lg font-medium text-primary">Home</a>
          <a href="registration-guideline.php" class="block px-4 py-3 hover:bg-gray-50 rounded-lg font-medium text-primary">Registration Guideline</a>
          <a href="registration-fee.php" class="block px-4 py-3 hover:bg-gray-50 rounded-lg font-medium text-primary">Registration Fee</a>
          <a href="signup.php" class="block px-4 py-3 bg-accent text-primary rounded-lg font-bold hover:bg-warmgold">Online Registration</a>
          <a href="submit-abstract.php" class="block px-4 py-3 hover:bg-gray-50 rounded-lg font-medium text-primary">Abstract Submission</a>
          <a href="contact.php" class="block px-4 py-3 hover:bg-gray-50 rounded-lg font-medium text-primary">Contact Us</a>
        </div>
      </nav>
    </div>
  </header>

  <script>
    // Mobile menu toggle
    document.getElementById('mobile-menu-btn').addEventListener('click', function() {
      document.getElementById('mobile-menu').classList.toggle('active');
    });
  </script>