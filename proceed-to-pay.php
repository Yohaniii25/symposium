<?php include 'includes/header.php'; ?>

<!-- HERO -->
<section class="relative bg-gradient-to-br from-primary/95 via-purple/90 to-richpurple/95 text-white py-32 overflow-hidden">
  <div class="absolute inset-0 z-0">
    <img src="./assets/img/breadcrumb.jpeg" alt="" class="w-full h-full object-cover">
    <div class="absolute inset-0 bg-black/60"></div>
  </div>
  <div class="relative z-10 max-w-7xl mx-auto px-6 text-center">
    <h1 class="text-5xl md:text-7xl font-bold mb-6 drop-shadow-2xl">Complete Your Payment</h1>
    <p class="text-xl md:text-2xl opacity-95">GJRTI 3rd International Research Symposium 2025</p>
  </div>
</section>

<!-- PAYMENT SECTION -->
<section class="py-20 bg-lightbg">
  <div class="max-w-5xl mx-auto px-6">
    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">

      <!-- Registration Fee Table -->
      <div class="bg-gradient-to-r from-primary to-richpurple text-white p-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Registration Fee</h2>
      </div>
      <div class="p-8">
        <table class="w-full text-center text-lg md:text-xl border-collapse">
          <thead class="bg-gray-100">
            <tr>
              <th class="px-6 py-5 font-bold text-primary">Participant Type</th>
              <th class="px-6 py-5 font-bold text-primary">Local (LKR)</th>
              <th class="px-6 py-5 font-bold text-primary">International (USD)</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            <tr class="hover:bg-gray-50">
              <td class="py-6 font-semibold">Presenting Author</td>
              <td class="py-6 text-2xl font-bold text-green-600">LKR 1,000</td>
              <td class="py-6 text-2xl font-bold text-blue-600">USD 10</td>
            </tr>
            <tr class="hover:bg-gray-50">
              <td class="py-6 font-semibold">Co-Author</td>
              <td class="py-6 text-2xl font-bold text-green-600">LKR 1,500</td>
              <td class="py-6 text-2xl font-bold text-blue-600">USD 15</td>
            </tr>
            <tr class="hover:bg-gray-50">
              <td class="py-6 font-semibold">Other Participants</td>
              <td class="py-6 text-2xl font-bold text-green-600">LKR 5,000</td>
              <td class="py-6 text-2xl font-bold text-blue-600">USD 50</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Payment Method Selection -->
      <div class="px-8 pb-12">
        <h3 class="text-2xl md:text-3xl font-bold text-primary text-center mb-10">
          Choose Your Payment Method
        </h3>

        <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">

          <!-- Option 1: Online Payment -->
          <div class="border-4 border-accent/30 rounded-2xl p-8 text-center hover:border-accent transition-all cursor-pointer"
               onclick="document.getElementById('online-pay').checked = true;">
            <input type="radio" id="online-pay" name="payment_method" value="online" class="hidden">
            <div class="bg-accent/10 rounded-xl p-8">
              <svg class="w-20 h-20 text-accent mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h10m-8 4h6a2 2 0 002-2V7a2 2 0 00-2-2H9a2 2 0 00-2 2v10a2 2 0 002 2z"/>
              </svg>
              <h4 class="text-2xl font-bold text-primary mb-4">Pay Online</h4>
              <p class="text-gray-700 mb-6">Secure payment via Credit/Debit Card<br>Instant confirmation</p>
              <div class="bg-accent text-primary px-10 py-5 rounded-xl text-xl font-bold hover:bg-warmgold transition shadow-xl inline-block">
                Proceed to Payment Gateway
              </div>
            </div>
          </div>

          <!-- Option 2: Upload Bank Slip -->
          <div class="border-4 border-gray-300 rounded-2xl p-8 text-center hover:border-primary transition-all cursor-pointer"
               onclick="document.getElementById('upload-slip').checked = true;">
            <input type="radio" id="upload-slip" name="payment_method" value="slip" class="hidden">
            <div class="bg-gray-50 rounded-xl p-8">
              <svg class="w-20 h-20 text-primary mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v6h5"/>
              </svg>
              <h4 class="text-2xl font-bold text-primary mb-4">Upload Bank Slip</h4>
              <p class="text-gray-700 mb-6">Pay via bank transfer<br>Upload slip for verification</p>
              <div class="border-2 border-primary text-primary px-10 py-5 rounded-xl text-xl font-bold hover:bg-primary hover:text-white transition inline-block">
                Choose File to Upload
              </div>
            </div>
          </div>

        </div>

        <!-- Submit Button (Appears after selection) -->
        <div class="text-center mt-12">
          <button type="submit" disabled id="submit-btn"
                  class="bg-gray-400 text-white px-16 py-6 rounded-xl text-2xl font-bold cursor-not-allowed">
            Please Select a Payment Method
          </button>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  // Enable submit button when option is selected
  document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
    radio.addEventListener('change', function() {
      const btn = document.getElementById('submit-btn');
      if (this.value === 'online') {
        btn.disabled = false;
        btn.className = 'bg-accent text-primary px-16 py-6 rounded-xl text-2xl font-bold hover:bg-warmgold transition shadow-2xl';
        btn.textContent = 'Proceed to Secure Payment →';
        btn.onclick = () => alert('Redirecting to IPG...');
      } else {
        btn.disabled = false;
        btn.className = 'bg-primary text-white px-16 py-6 rounded-xl text-2xl font-bold hover:bg-richpurple transition shadow-2xl';
        btn.innerHTML = 'Upload Slip & Submit <svg class="inline w-8 h-8 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>';
        btn.onclick = () => alert('Opening file upload...');
      }
    });
  });
</script>

<?php include 'includes/footer.php'; ?>