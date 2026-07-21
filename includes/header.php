<?php

require_once 'config/config.php';
require_once 'classes/database.php';
require_once 'classes/auth.php';

$auth = new Auth();
$loggedInUser = $auth->isParticipant() ? $auth->user() : null;
$loggedInAdmin = $auth->isAdmin() ? $auth->admin() : null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Gem and Jewellery Research Symposium of Sri Lanka 2026</title>
  <meta name="description" content="Gem and Jewellery Research Symposium of Sri Lanka 2026">
  <!-- favicon -->
  <link rel="icon" type="image/png" href="assets/img/logo.jpg" />

  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  <link rel="stylesheet" href="assets/css/styles.css">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>

<body>

  <!-- TOP BAR: Logged In or Guest -->
  <div class="header-topbar">
    <div class="header-topbar-wrapper">

      <?php if ($loggedInUser || $loggedInAdmin): ?>
        <!-- LOGGED IN USER -->
        <div class="flex-gap-4">
          <div class="flex-gap-4">
            <div class="header-topbar-avatar">
              <svg fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
              </svg>
            </div>
            <span class="font-medium hidden sm:block">
              <a href="user-profile.php" class="hover:text-accent transition">
                <?= htmlspecialchars($loggedInUser['name'] ?? $loggedInAdmin['name']) ?>
              </a>
            </span>
          </div>
          <a href="logout.php" class="hover:text-accent transition font-medium">
            Logout
          </a>
        </div>
      <?php else: ?>
        <!-- GUEST USER -->
        <div class="flex-gap-4">
          <a href="login.php" class="hover:text-accent transition">Login</a>
          <span class="header-topbar-divider">|</span>
          <a href="signup.php" class="hover:text-accent font-semibold transition">Sign Up</a>
        </div>
      <?php endif; ?>

    </div>
  </div>

  <!-- MAIN HEADER -->
  <header class="header-main">
    <div class="header-main-wrapper">
      <div class="header-main-container">

        <a href="index.php" class="header-logo-link">
          <img src="assets/img/logo.jpg" alt="GJRTI Logo" class="header-logo-img">
          <div>
            <h1 class="header-title-text">
              Gem and Jewellery Research Symposium of Sri Lanka
            </h1>
          </div>
        </a>

        <!-- Desktop Navigation -->
        <nav class="header-nav-desktop">
          <a href="index.php" class="header-nav-item">Home</a>

          <!-- Registration Dropdown -->
          <div x-data="{ open: false }" class="nav-dropdown" @click.outside="open = false">
            <button @click="open = !open" class="nav-dropdown-btn">
              <span>Registration</span>
              <svg :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div x-show="open" x-transition class="nav-dropdown-menu dropdown-w-64">
              <div class="dropdown-menu-padding">
                <a href="registration-guideline.php" class="dropdown-item">Registration Guideline</a>
                <a href="registration-fee.php" class="dropdown-item">Registration Fee</a>
                <a href="signup.php" class="dropdown-item bg-accent-5">Online Registration</a>
              </div>
            </div>
          </div>

          <!-- Abstract Submission Dropdown -->
          <div x-data="{ open: false }" class="nav-dropdown" @click.outside="open = false">
            <button @click="open = !open" class="nav-dropdown-btn">
              <span>Abstract Submission</span>
              <svg :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div x-show="open" x-transition class="nav-dropdown-menu dropdown-w-80">
              <div class="dropdown-menu-padding">
                <a href="submit-abstract.php#themes" class="dropdown-item">Abstract Themes</a>
                <a href="submit-abstract.php#poster" class="dropdown-item">Poster Presentation Upload</a>
                <a href="submit-abstract.php#oral" class="dropdown-item bg-accent-5">Oral Presentation Upload</a>
              </div>
            </div>
          </div>

          <a href="contact.php" class="header-nav-item">Contact Us</a>
        </nav>

        <!-- Mobile Menu Button -->
        <button id="mobile-menu-btn" class="header-mobile-menu-btn">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
      </div>

      <!-- Mobile Navigation -->
      <nav id="mobile-menu" class="mobile-menu">
        <div class="mobile-menu-container">
          <a href="index.php" class="mobile-menu-link">Home</a>
          <a href="registration-guideline.php" class="mobile-menu-link">Registration Guideline</a>
          <a href="registration-fee.php" class="mobile-menu-link">Registration Fee</a>
          <a href="signup.php" class="mobile-menu-link-btn">Online Registration</a>
          <a href="submit-abstract.php" class="mobile-menu-link">Abstract Submission</a>
          <a href="contact.php" class="mobile-menu-link">Contact Us</a>
        </div>
      </nav>
    </div>
  </header>

  <script>
    document.getElementById('mobile-menu-btn').addEventListener('click', function() {
      document.getElementById('mobile-menu').classList.toggle('active');
    });
  </script>

  <main class="flex-1">