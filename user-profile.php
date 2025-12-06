<!-- profile.php -->
<?php include 'includes/header.php'; ?>

<section class="py-20 bg-lightbg">
  <div class="max-w-4xl mx-auto px-6">
    <div class="bg-white rounded-3xl shadow-2xl p-10">
      <div class="text-center mb-10">
        <div class="w-32 h-32 bg-accent/20 rounded-full mx-auto mb-6 flex items-center justify-center">
          <svg class="w-20 h-20 text-accent" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
          </svg>
        </div>
        <h2 class="text-3xl font-bold text-primary">Dr. Anura Perera</h2>
        <p class="text-accent font-medium">Presenting Author</p>
      </div>

      <div class="grid md:grid-cols-2 gap-8 text-lg">
        <div>
          <p><strong>Email:</strong> anura.perera@university.ac.lk</p>
          <p><strong>Institution:</strong> University of Colombo</p>
          <p><strong>Country:</strong> Sri Lanka</p>
        </div>
        <div>
          <p><strong>Registration Status:</strong> <span class="text-yellow-600 font-bold">Pending</span></p>
          <p><strong>Abstract Status:</strong> <span class="text-blue-600 font-bold">Accepted (Oral)</span></p>
          <p><strong>Session:</strong> Technical Session I</p>
        </div>
      </div>

      <div class="mt-10 text-center">
        <a href="proceed-to-pay.php" class="bg-accent text-primary px-8 py-4 rounded-xl font-bold hover:bg-warmgold transition shadow-lg">
          Proceed to Payment
        </a>
      </div>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>