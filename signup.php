<?php include 'includes/header.php'; ?>

<!-- HERO SECTION -->
<section class="relative bg-gradient-to-br from-primary/95 via-purple/90 to-richpurple/95 text-white py-32">
  <div class="absolute inset-0 z-0">
    <img src="./assets/img/breadcrumb.jpeg" alt="" class="w-full h-full object-cover">
    <div class="absolute inset-0 bg-black/60"></div>
  </div>
  <div class="relative z-10 text-center max-w-4xl mx-auto px-6">
    <h1 class="text-5xl md:text-7xl font-bold mb-6">Online Registration</h1>
    <p class="text-xl opacity-90">Transparent and affordable rates for all participants</p>
  </div>
</section>

<!-- REGISTRATION FORM -->
<section class="py-20 bg-lightbg">
  <div class="max-w-4xl mx-auto px-6">
    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
      <div class="bg-gradient-to-r from-primary to-richpurple text-white p-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold">Create Your Symposium Account</h2>
        <p class="mt-3 text-lg opacity-90">Secure registration • One-time setup</p>
      </div>

      <form class="p-8 md:p-12 space-y-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
          <!-- Title -->
          <div>
            <label class="block text-primary font-semibold mb-2">Title <span class="text-red-600">*</span></label>
            <select required class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:border-accent focus:outline-none transition text-gray-800 text-lg">
              <option value="">Select Title</option>
              <option>Prof.</option>
              <option>Dr.</option>
              <option>Mr.</option>
              <option>Ms.</option>
            </select>
          </div>

          <!-- Full Name -->
          <div>
            <label class="block text-primary font-semibold mb-2">Full Name <span class="text-red-600">*</span></label>
            <input type="text" required placeholder="Enter your full name" 
                   class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:border-accent focus:outline-none transition text-lg">
          </div>

          <!-- NIC / Passport / DL -->
          <div>
            <label class="block text-primary font-semibold mb-2">NIC / Passport / Driving License No. <span class="text-red-600">*</span></label>
            <input type="text" required placeholder="e.g. 199812345678 or AB1234567" 
                   class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:border-accent focus:outline-none transition text-lg">
          </div>

          <!-- Email -->
          <div>
            <label class="block text-primary font-semibold mb-2">Email Address <span class="text-red-600">*</span></label>
            <input type="email" required placeholder="name@example.com" 
                   class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:border-accent focus:outline-none transition text-lg">
          </div>

          <!-- Contact Number -->
          <div>
            <label class="block text-primary font-semibold mb-2">Contact Number <span class="text-red-600">*</span></label>
            <input type="tel" required placeholder="+94 77 123 4567" 
                   class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:border-accent focus:outline-none transition text-lg">
          </div>

          <!-- Food Preference -->
          <div>
            <label class="block text-primary font-semibold mb-2">Food Preference <span class="text-red-600">*</span></label>
            <select required class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:border-accent focus:outline-none transition text-gray-800 text-lg">
              <option value="">Select Preference</option>
              <option>Vegetarian</option>
              <option>Non-Vegetarian</option>
              <option>Vegan</option>
              <option>Halal</option>
              <option>No Preference</option>
            </select>
          </div>

          <!-- Participant Type -->
          <div>
            <label class="block text-primary font-semibold mb-2">Participant Type <span class="text-red-600">*</span></label>
            <select required name="participant_type" class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:border-accent focus:outline-none transition text-gray-800 text-lg">
              <option value="">Select Type</option>
              <option>Presenting Author</option>
              <option>Co-Author</option>
              <option>Other Participants</option>
            </select>
          </div>

          <!-- Password -->
          <div>
            <label class="block text-primary font-semibold mb-2">Password <span class="text-red-600">*</span></label>
            <input type="password" required placeholder="••••••••••" 
                   class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:border-accent focus:outline-none transition text-lg">
          </div>

          <!-- Confirm Password -->
          <div>
            <label class="block text-primary font-semibold mb-2">Confirm Password <span class="text-red-600">*</span></label>
            <input type="password" required placeholder="••••••••••" 
                   class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:border-accent focus:outline-none transition text-lg">
          </div>
        </div>

        <!-- Submit Button -->
        <div class="text-center pt-8">
          <button type="submit" 
                  class="bg-accent text-primary px-16 py-6 rounded-xl text-2xl font-bold hover:bg-warmgold transition-all shadow-2xl hover:shadow-3xl transform hover:scale-105 inline-flex items-center space-x-4">
            <span>Create Account and Proceed to payment</span>
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
          </button>
        </div>

        <p class="text-center text-gray-600 mt-8">
          Already have an account? 
          <a href="login.php" class="text-accent font-bold hover:underline">Login here</a>
        </p>
      </form>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>