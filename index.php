<?php include 'includes/header.php'; ?>

<!-- HERO BANNER – Full Screen with Responsive Images -->
<section class="relative h-screen min-h-[600px] flex items-center justify-center overflow-hidden">
  <!-- Responsive Background Images -->
  <div class="absolute inset-0 z-0">
    <picture>
      <!-- Mobile (portrait/landscape) -->
      <source media="(max-width: 768px)" srcset="assets/img/hero-mobile.jpg">
      <!-- Tablet -->
      <source media="(max-width: 1024px)" srcset="assets/img/hero-tablet.jpg">
      <!-- Desktop & Large Screens -->
      <source media="(min-width: 1025px)" srcset="./assets/img/bg.png">
      <!-- Fallback -->
      <img src="./assets/img/bg.png" alt="GJRTI 3rd International Research Symposium 2025"
        class="w-full h-full object-cover object-center">
    </picture>
    <!-- Dark + Color Gradient Overlay -->
    <div class="absolute inset-0 bg-gradient-to-br from-primary/90 via-richpurple/85 to-black/80"></div>
  </div>

  <!-- Hero Content -->
  <div class="relative z-20 max-w-7xl mx-auto px-6 text-center text-white">
    <!-- Symposium Logo -->
    <img src="assets/img/logo.png" alt="GJRTI Logo" class="h-32 md:h-48 mx-auto mb-8 drop-shadow-2xl">

    <!-- Main Title -->
    <h1 class="text-4xl md:text-6xl lg:text-5xl font-bold leading-tight drop-shadow-2xl">
      GJRTI 3rd International Research Symposium 2025
    </h1>

    <!-- Theme -->
    <p class="text-5xl md:text-4xl lg:text-3xl font-bold text-accent mt-8 drop-shadow-2xl leading-snug">
      “Advancements in Recent Technologies in the Gem and Jewellery Industry”
    </p>

    <!-- Date & Venue -->
    <div class="mt-10 text-xl md:text-2xl lg:text-2xl space-y-4 font-medium">
      <p class="flex items-center justify-center gap-3">
        <svg class="w-8 h-8 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        Friday, 10th October 2025
      </p>
      <p class="flex items-center justify-center gap-3">
        <svg class="w-8 h-8 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        Sri Lanka Foundation Institute, Colombo, Sri Lanka
      </p>
    </div>

    <!-- Host -->
    <p class="mt-8 text-lg md:text-xl opacity-90 font-medium">
      Hosted by <span class="text-accent font-bold">Gem and Jewellery Research and Training Institute</span>
    </p>


  </div>
</section>

<section class="bg-white">
  <div class="bg-white py-8 ">
    <div class="mx-auto px-6 text-center">
      <h2 class="text-4xl md:text-5xl font-bold leading-tight text-primary mb-8">
        GJRTI 3rd International Research Symposium 2025
      </h2>
      <p class="text-xl md:text-2xl leading-relaxed max-w-5xl mx-auto px-4 gray-700">
        The <strong>Gem and Jewellery Research and Training Institute</strong> proudly presents its
        3rd International Research Symposium, focusing on the crucial theme:
      </p>
      <p class="text-2xl md:text-2xl font-bold text-accent mt-8 leading-snug">
        “Advancements in Recent Technologies in the Gem and Jewellery Industry”
      </p>
    </div>
  </div>

  <!-- TWO-COLUMN SECTION BELOW THE BANNER -->
  <div class="py-20 md:py-14">
    <div class="max-w-7xl mx-auto px-6">
      <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">

        <!-- LEFT: Text Content -->
        <div class="space-y-8 order-2 lg:order-1">
          <div class="space-y-6 text-lg md:text-xl text-gray-700 leading-relaxed">
            <p class="flex items-center gap-4">
              <svg class="w-8 h-8 text-accent flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
              <strong>Friday, 10th October 2025</strong>
            </p>
            <p class="flex items-center gap-4">
              <svg class="w-8 h-8 text-accent flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
              <strong>Sri Lanka Foundation Institute, Colombo, Sri Lanka</strong>
            </p>
          </div>

          <p class="text-lg md:text-xl text-gray-700 leading-relaxed">
            This symposium is designed to bring together researchers, academics, industry professionals, and policymakers to exchange knowledge and innovative ideas that will shape the future of the global gem and jewellery sector. The event offers an essential platform for discussing cutting-edge research and fostering international collaboration.
          </p>

          <p class="text-lg md:text-xl text-gray-700 leading-relaxed">
            The program will feature insightful discussions across <strong>ten specialized tracks</strong>, providing a comprehensive view of the industry's contemporary challenges and opportunities.
          </p>
        </div>

        <!-- RIGHT: Image -->
        <div class="order-1 lg:order-2">
          <div class="relative group">
            <div class="absolute inset-0 bg-gradient-to-br from-primary/20 to-accent/20 rounded-3xl blur-3xl group-hover:blur-2xl transition"></div>
            <img src="./assets/img/gem_venue.png"
              alt="GJRTI 3rd International Research Symposium 2025"
              class="relative rounded-3xl shadow-2xl w-full object-cover h-[500px] border-10 border-white">
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent rounded-3xl flex items-end">

            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>
<!-- SYMPOSIUM TRACKS -->
<section class="py-16 bg-lightbg">
  <div class="max-w-7xl mx-auto px-6">
    <div class="text-center mb-12">
      <h2 class="text-3xl md:text-4xl font-bold text-primary mb-3">Symposium Tracks</h2>
      <div class="w-20 h-1 bg-accent mx-auto"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
      <div class="bg-white p-6 border-l-4 border-primary hover:shadow-lg transition">
        <div class="flex items-center">
          <span class="text-3xl font-bold text-primary/30 mr-4">01</span>
          <h3 class="text-lg font-semibold text-gray-900 leading-snug">Technological Innovations of the Industry</h3>
        </div>
      </div>
      <div class="bg-white p-6 border-l-4 border-accent hover:shadow-lg transition">
        <div class="flex items-center">
          <span class="text-3xl font-bold text-accent mr-4">02</span>
          <h3 class="text-lg font-semibold text-gray-900 leading-snug">Gem Tourism</h3>
        </div>
      </div>
      <div class="bg-white p-6 border-l-4 border-primary hover:shadow-lg transition">
        <div class="flex items-center">
          <span class="text-3xl font-bold text-primary/30 mr-4">03</span>
          <h3 class="text-lg font-semibold text-gray-900 leading-snug">Environmental Consequences</h3>
        </div>
      </div>
      <div class="bg-white p-6 border-l-4 border-accent hover:shadow-lg transition">
        <div class="flex items-center">
          <span class="text-3xl font-bold text-accent mr-4">04</span>
          <h3 class="text-lg font-semibold text-gray-900 leading-snug">Industry Socio-economic Context</h3>
        </div>
      </div>
      <div class="bg-white p-6 border-l-4 border-primary hover:shadow-lg transition">
        <div class="flex items-center">
          <span class="text-3xl font-bold text-primary/30 mr-4">05</span>
          <h3 class="text-lg font-semibold text-gray-900 leading-snug">Sectorial Archaeological Perspectives</h3>
        </div>
      </div>
      <div class="bg-white p-6 border-l-4 border-accent hover:shadow-lg transition">
        <div class="flex items-center">
          <span class="text-3xl font-bold text-accent mr-4">06</span>
          <h3 class="text-lg font-semibold text-gray-900 leading-snug">Survey and Appraisal of Gem and Precious Metal Deposits</h3>
        </div>
      </div>
      <div class="bg-white p-6 border-l-4 border-primary hover:shadow-lg transition">
        <div class="flex items-center">
          <span class="text-3xl font-bold text-primary/30 mr-4">07</span>
          <h3 class="text-lg font-semibold text-gray-900 leading-snug">Sustainable Mining of Gemstones towards Fulfilling Sustainable Development Goals in 2030</h3>
        </div>
      </div>
      <div class="bg-white p-6 border-l-4 border-accent hover:shadow-lg transition">
        <div class="flex items-center">
          <span class="text-3xl font-bold text-accent mr-4">08</span>
          <h3 class="text-lg font-semibold text-gray-900 leading-snug">Ethical Practices in the Gem and Jewellery Industry</h3>
        </div>
      </div>
      <div class="bg-white p-6 border-l-4 border-primary hover:shadow-lg transition">
        <div class="flex items-center">
          <span class="text-3xl font-bold text-primary/30 mr-4">09</span>
          <h3 class="text-lg font-semibold text-gray-900 leading-snug">Treatments, Synthetics and Simulants</h3>
        </div>
      </div>
      <div class="bg-white p-6 border-l-4 border-accent hover:shadow-lg transition">
        <div class="flex items-center">
          <span class="text-3xl font-bold text-accent mr-4">10</span>
          <h3 class="text-lg font-semibold text-gray-900 leading-snug">Gem and Jewellery Trade</h3>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- REGISTRATION FEE -->
<section class="py-16 bg-white">
  <div class="max-w-5xl mx-auto px-6">
    <div class="text-center mb-12">
      <h2 class="text-3xl md:text-4xl font-bold text-primary mb-3">Registration Fee</h2>
      <div class="w-20 h-1 bg-accent mx-auto"></div>
    </div>

    <div class="bg-white rounded-lg shadow-lg border overflow-hidden">
      <table class="w-full">
        <thead>
          <tr class="bg-gradient-to-r from-primary to-richpurple text-white">
            <th class="px-6 py-4 text-left font-semibold">Participant Type</th>
            <th class="px-6 py-4 text-center font-semibold">Local (LKR)</th>
            <th class="px-6 py-4 text-center font-semibold">International (USD)</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          <tr class="hover:bg-gray-50">
            <td class="px-6 py-4 font-medium text-gray-900">Presenting Author</td>
            <td class="px-6 py-4 text-center text-lg font-semibold text-green-700">LKR 1,000</td>
            <td class="px-6 py-4 text-center text-lg font-semibold text-blue-700">USD 10</td>
          </tr>
          <tr class="hover:bg-gray-50">
            <td class="px-6 py-4 font-medium text-gray-900">Co-Author</td>
            <td class="px-6 py-4 text-center text-lg font-semibold text-green-700">LKR 1,500</td>
            <td class="px-6 py-4 text-center text-lg font-semibold text-blue-700">USD 15</td>
          </tr>
          <tr class="hover:bg-gray-50">
            <td class="px-6 py-4 font-medium text-gray-900">Other Participants</td>
            <td class="px-6 py-4 text-center text-lg font-semibold text-green-700">LKR 5,000</td>
            <td class="px-6 py-4 text-center text-lg font-semibold text-blue-700">USD 50</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="text-center mt-8">
      <a href="registration-guideline.php" class="inline-block bg-accent hover:bg-warmgold text-white font-semibold px-8 py-3 rounded-lg shadow-lg transition transform hover:scale-105">
        Register Now
      </a>
    </div>
  </div>
</section>

<!-- SYMPOSIUM PROGRAM -->
<section class="py-16 bg-lightbg">
  <div class="max-w-7xl mx-auto px-6">
    <div class="text-center mb-12">
      <h2 class="text-3xl md:text-4xl font-bold text-primary mb-2">Official Symposium Program</h2>
      <p class="text-xl text-accent font-semibold">Friday, 10th October 2025</p>
      <p class="text-gray-600">Sri Lanka Foundation Institute, Colombo</p>
      <div class="w-20 h-1 bg-accent mx-auto mt-4"></div>
    </div>

    <!-- MAIN SCHEDULE -->
    <div class="bg-white rounded-lg shadow-lg border overflow-hidden mb-12">
      <table class="w-full border-collapse">
        <thead>
          <tr class="bg-gradient-to-r from-primary to-richpurple text-white">
            <th class="px-8 py-5 text-left font-bold text-lg">Time</th>
            <th class="px-8 py-5 text-left font-bold text-lg relative">
              <!-- Vertical Divider Line in Header -->
              <span class="absolute left-0 top-4 bottom-4 w-px bg-white/30"></span>
              Activity
            </th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          <tr class="hover:bg-gray-50 transition">
            <td class="px-8 py-4 font-medium text-primary align-top">08:30 AM – 09:00 AM</td>
            <td class="px-8 py-4 relative align-top">
              <!-- Vertical Divider Line in Body -->
              <span class="absolute left-0 top-0 bottom-0 w-px bg-gray-300"></span>
              <span class="pl-6 block">Registration</span>
            </td>
          </tr>
          <tr class="hover:bg-gray-50 transition">
            <td class="px-8 py-4 font-medium text-primary align-top">09:00 AM – 09:10 AM</td>
            <td class="px-8 py-4 relative align-top">
              <span class="absolute left-0 top-0 bottom-0 w-px bg-gray-300"></span>
              <span class="pl-6 block">Arrival of Guests</span>
            </td>
          </tr>
          <tr class="hover:bg-gray-50 transition">
            <td class="px-8 py-4 font-medium text-primary align-top">09:10 AM – 09:15 AM</td>
            <td class="px-8 py-4 relative align-top">
              <span class="absolute left-0 top-0 bottom-0 w-px bg-gray-300"></span>
              <span class="pl-6 block">Lighting of the Traditional Oil Lamp</span>
            </td>
          </tr>
          <tr class="hover:bg-gray-50 transition">
            <td class="px-8 py-4 font-medium text-primary align-top">09:15 AM – 09:20 AM</td>
            <td class="px-8 py-4 relative align-top">
              <span class="absolute left-0 top-0 bottom-0 w-px bg-gray-300"></span>
              <span class="pl-6 block">Welcome Speech – <strong>Prof. Rohan Fernando</strong>, Chairman, GJRTI</span>
            </td>
          </tr>
          <tr class="hover:bg-gray-50 transition">
            <td class="px-8 py-4 font-medium text-primary align-top">09:20 AM – 09:25 AM</td>
            <td class="px-8 py-4 relative align-top">
              <span class="absolute left-0 top-0 bottom-0 w-px bg-gray-300"></span>
              <span class="pl-6 block">Handing over Symposium Materials to Guests and Invitees</span>
            </td>
          </tr>
          <tr class="hover:bg-gray-50 transition">
            <td class="px-8 py-4 font-medium text-primary align-top">09:25 AM – 09:35 AM</td>
            <td class="px-8 py-4 relative align-top">
              <span class="absolute left-0 top-0 bottom-0 w-px bg-gray-300"></span>
              <span class="pl-6 block">Speech – <strong>Mrs. J.M. Thilaka Jayasundara</strong>, Secretary, Ministry of Industry</span>
            </td>
          </tr>
          <tr class="hover:bg-gray-50 transition">
            <td class="px-8 py-4 font-medium text-primary align-top">09:35 AM – 09:45 AM</td>
            <td class="px-8 py-4 relative align-top">
              <span class="absolute left-0 top-0 bottom-0 w-px bg-gray-300"></span>
              <span class="pl-6 block">Awarding of Tokens of Appreciation for the Panel of Reviewers</span>
            </td>
          </tr>
          <tr class="hover:bg-gray-50 transition">
            <td class="px-8 py-4 font-medium text-primary align-top">09:45 AM – 09:55 AM</td>
            <td class="px-8 py-4 relative align-top">
              <span class="absolute left-0 top-0 bottom-0 w-px bg-gray-300"></span>
              <span class="pl-6 block">Speech – <strong>Hon. Sunil Handunneththi</strong>, Minister of Industry</span>
            </td>
          </tr>
          <tr class="hover:bg-gray-50 transition">
            <td class="px-8 py-4 font-medium text-primary align-top">09:55 AM – 10:00 AM</td>
            <td class="px-8 py-4 relative align-top">
              <span class="absolute left-0 top-0 bottom-0 w-px bg-gray-300"></span>
              <span class="pl-6 block">Vote of Thanks – <strong>Mr. Naleen Jayasinghe</strong>, Symposium Secretary</span>
            </td>
          </tr>

          <!-- Highlighted Rows -->
          <tr class="bg-amber-50 border-l-4 border-amber-500">
            <td class="px-8 py-5 font-bold text-accent">10:00 AM – 10:30 AM</td>
            <td class="px-8 py-5 relative">
              <span class="absolute left-0 top-0 bottom-0 w-px bg-amber-300"></span>
              <span class="pl-6 block font-bold">Refreshments & Poster Session Begins</span>
            </td>
          </tr>
          <tr class="bg-blue-50 border-l-4 border-blue-600">
            <td class="px-8 py-5 font-bold text-primary">10:30 AM – 11:15 AM</td>
            <td class="px-8 py-5 relative">
              <span class="absolute left-0 top-0 bottom-0 w-px bg-gray-300"></span>
              <span class="pl-6 block">
                <div class="font-bold text-gray-900">Panel Discussion</div>
                <div class="text-sm italic text-gray-700 mt-1">"Driving Economic Growth through a Sustainable Gem and Jewellery Sector"</div>
              </span>
            </td>
          </tr>
          <tr class="bg-gray-100">
            <td class="px-8 py-5 font-semibold text-gray-700">12:45 PM – 01:30 PM</td>
            <td class="px-8 py-5 relative">
              <span class="absolute left-0 top-0 bottom-0 w-px bg-gray-300"></span>
              <span class="pl-6 block font-semibold">Lunch Break</span>
            </td>
          </tr>
          <tr class="bg-amber-50 border-l-4 border-amber-500">
            <td class="px-8 py-5 font-bold text-accent">04:10 PM – 04:25 PM</td>
            <td class="px-8 py-5 relative">
              <span class="absolute left-0 top-0 bottom-0 w-px bg-amber-300"></span>
              <span class="pl-6 block font-bold">Refreshments</span>
            </td>
          </tr>
          <tr class="bg-green-50 border-l-4 border-green-600">
            <td class="px-8 py-5 font-bold text-primary">04:25 PM – 04:40 PM</td>
            <td class="px-8 py-5 relative">
              <span class="absolute left-0 top-0 bottom-0 w-px bg-green-300"></span>
              <span class="pl-6 block font-bold">Awarding of Certificates</span>
            </td>
          </tr>
          <tr class="bg-primary text-white font-bold">
            <td class="px-8 py-5">04:40 PM</td>
            <td class="px-8 py-5 relative">
              <span class="absolute left-0 top-0 bottom-0 w-px bg-white/30"></span>
              <span class="pl-6 block">End of the Symposium</span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>



    <!-- TECHNICAL SESSIONS -->
    <div class="space-y-8">
      <!-- Session I -->
      <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-200">
        <!-- Colored Header -->
        <div class="bg-gradient-to-r from-warmblue to-lightblue text-white p-6">
          <h3 class="text-2xl md:text-3xl font-bold">Technical Session I</h3>
          <p class="text-lg opacity-95 mt-2">11:15 AM – 12:45 PM</p>
          <p class="text-sm mt-3 opacity-90">
            <span class="font-semibold">Chairperson:</span> Prof. Chaminda Wijesinghe |
            <span class="font-semibold">Rapporteur:</span> Dr. Sarath Munasinghe
          </p>
        </div>

        <!-- Table with Vertical Divider -->
        <table class="w-full border-collapse">
          <tbody class="divide-y divide-gray-200">
            <tr class="hover:bg-gray-50 transition">
              <td class="px-8 py-5 font-medium text-blue align-top">11:30 – 11:45</td>
              <td class="px-8 py-5 relative align-top">
                <span class="absolute left-0 top-0 bottom-0 w-px bg-gray-300"></span>
                <div class="pl-6">
                  <p class="font-medium text-gray-900 leading-relaxed">
                    The Future of Geuda Heat Treatment Outcome Prediction with Machine Learning and Deep Learning Techniques
                  </p>
                  <p class="text-sm text-gray-600 italic mt-2">
                    Nimendra Nawanjana, Sandun Illangasinghe, Hiran Jayaweera, T.L.M.D. Fonseka, Sajuran Koodeswaran
                  </p>
                </div>
              </td>
            </tr>
            <tr class="hover:bg-gray-50 transition">
              <td class="px-8 py-5 font-medium text-blue align-top">11:45 – 12:00</td>
              <td class="px-8 py-5 relative align-top">
                <span class="absolute left-0 top-0 bottom-0 w-px bg-gray-300"></span>
                <div class="pl-6">
                  <p class="font-medium text-gray-900 leading-relaxed">
                    Development of a Standardized, Technology-Driven Jewellery Valuation System for the Sri Lankan Gem and Jewellery Industry
                  </p>
                  <p class="text-sm text-gray-600 italic mt-2">
                    R.A.P.G.J. Vinodani, S. Sutharshan, U.W.K.A.R. Chandrakantha, Mudith Roshan, R.M.N.P.K. Jayasinghe
                  </p>
                </div>
              </td>
            </tr>
            <tr class="hover:bg-gray-50 transition">
              <td class="px-8 py-5 font-medium text-blue align-top">12:00 – 12:15</td>
              <td class="px-8 py-5 relative align-top">
                <span class="absolute left-0 top-0 bottom-0 w-px bg-gray-300"></span>
                <div class="pl-6">
                  <p class="font-medium text-gray-900 leading-relaxed">
                    Legal Innovations for Promoting Sustainable Gem Tourism under the UN Sustainable Development Goals (SDGs)
                  </p>
                  <p class="text-sm text-gray-600 italic mt-2">C.L.Y.L. Fonseka, C.W.S. Fonseka</p>
                </div>
              </td>
            </tr>
            <tr class="hover:bg-gray-50 transition">
              <td class="px-8 py-5 font-medium text-blue align-top">12:15 – 12:30</td>
              <td class="px-8 py-5 relative align-top">
                <span class="absolute left-0 top-0 bottom-0 w-px bg-gray-300"></span>
                <div class="pl-6">
                  <p class="font-medium text-gray-900 leading-relaxed">
                    Study on potential automated color grading of colored gemstones together with an insight of quantitative analysis of colors
                  </p>
                  <p class="text-sm text-gray-600 italic mt-2">G.U.I. Ramadasa, D.N.S. Wanniarachchi</p>
                </div>
              </td>
            </tr>
            <tr class="hover:bg-gray-50 transition">
              <td class="px-8 py-5 font-medium text-blue align-top">12:30 – 12:45</td>
              <td class="px-8 py-5 relative align-top">
                <span class="absolute left-0 top-0 bottom-0 w-px bg-gray-300"></span>
                <div class="pl-6">
                  <p class="font-medium text-gray-900 leading-relaxed">
                    Smart Destination Development: Integrating IoT and GIS for Gem Tourism Mapping in Sri Lanka
                  </p>
                  <p class="text-sm text-gray-600 italic mt-2">W.H.A.U. Abeyrathne, K.G. Samarawickrama</p>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Session II -->
      <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-200">
        <!-- Emerald-Teal Header -->
        <div class="bg-gradient-to-r from-emerald-600 to-teal-600 text-white p-6">
          <h3 class="text-2xl md:text-3xl font-bold">Technical Session II</h3>
          <p class="text-lg opacity-95 mt-2">01:30 PM – 02:50 PM</p>
          <p class="text-sm mt-3 opacity-90">
            <span class="font-semibold">Chairperson:</span> Dr. L.V. Ranaweera |
            <span class="font-semibold">Rapporteur:</span> Dr. P. L. Dharmapriya
          </p>
        </div>

        <!-- Table with Vertical Divider -->
        <table class="w-full border-collapse">
          <tbody class="divide-y divide-gray-200">
            <tr class="hover:bg-gray-50 transition">
              <td class="px-8 py-5 font-medium text-emerald-700 align-top w-40">01:30 – 01:45</td>
              <td class="px-8 py-5 relative align-top">
                <span class="absolute left-0 top-0 bottom-0 w-px bg-gray-300"></span>
                <div class="pl-6">
                  <p class="font-medium text-gray-900 leading-relaxed">
                    Bead Making in the Indus Valley Civilization: An Archaeological Perspective on Cultural Identity
                  </p>
                  <p class="text-sm text-gray-600 italic mt-2">
                    Dilshad Fatima
                  </p>
                </div>
              </td>
            </tr>
            <tr class="hover:bg-gray-50 transition">
              <td class="px-8 py-5 font-medium text-emerald-700 align-top">01:45 – 02:00</td>
              <td class="px-8 py-5 relative align-top">
                <span class="absolute left-0 top-0 bottom-0 w-px bg-gray-300"></span>
                <div class="pl-6">
                  <p class="font-medium text-gray-900 leading-relaxed">
                    Heat-Induced Transformation of Brown Inclusions in Kahata Silky Geuda
                  </p>
                  <p class="text-sm text-gray-600 italic mt-2">
                    Sandun Illangasinghe, M.A.N.C. Manthrirathna, Pasindu Seenigama
                  </p>
                </div>
              </td>
            </tr>
            <tr class="hover:bg-gray-50 transition">
              <td class="px-8 py-5 font-medium text-emerald-700 align-top">02:00 – 02:15</td>
              <td class="px-8 py-5 relative align-top">
                <span class="absolute left-0 top-0 bottom-0 w-px bg-gray-300"></span>
                <div class="pl-6">
                  <p class="font-medium text-gray-900 leading-relaxed">
                    Discriminating Natural Beryllium Anomalies from Diffusion Treatment in Sapphires: A Multi-Technical Approach
                  </p>
                  <p class="text-sm text-gray-600 italic mt-2">
                    K.G.S.S.W. Bandara
                  </p>
                </div>
              </td>
            </tr>
            <tr class="hover:bg-gray-50 transition">
              <td class="px-8 py-5 font-medium text-emerald-700 align-top">02:15 – 02:30</td>
              <td class="px-8 py-5 relative align-top">
                <span class="absolute left-0 top-0 bottom-0 w-px bg-gray-300"></span>
                <div class="pl-6">
                  <p class="font-medium text-gray-900 leading-relaxed">
                    Tech Enabled Value Chains: Enhancing Sri Lanka's Gem Tourism from Mines to Markets
                  </p>
                  <p class="text-sm text-gray-600 italic mt-2">
                    W.H.A.U. Abeyrathne, R.A. Pathum
                  </p>
                </div>
              </td>
            </tr>
            <tr class="hover:bg-gray-50 transition">
              <td class="px-8 py-5 font-medium text-emerald-700 align-top">02:30 – 02:45</td>
              <td class="px-8 py-5 relative align-top">
                <span class="absolute left-0 top-0 bottom-0 w-px bg-gray-300"></span>
                <div class="pl-6">
                  <p class="font-medium text-gray-900 leading-relaxed">
                    A New Heat Treatment Technique to Remove Rutile Inclusions in Red Geuda without Formation of Unwanted Blue in Pink Sapphire
                  </p>
                  <p class="text-sm text-gray-600 italic mt-2">
                    Sandun Illangasinghe, Vimukthi Fernando, Sanjaya Madusanka
                  </p>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Session III -->
      <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-200">
        <!-- Purple Gradient Header -->
        <div class="bg-gradient-to-r from-purple to-softpurple text-white p-6">
          <h3 class="text-2xl md:text-3xl font-bold">Technical Session III</h3>
          <p class="text-lg opacity-95 mt-2">02:50 PM – 04:10 PM</p>
          <p class="text-sm mt-3 opacity-90">
            <span class="font-semibold">Chairperson:</span> Prof. Daham Jayawardena |
            <span class="font-semibold">Rapporteur:</span> Dr. Saranga Diyabalanage
          </p>
        </div>

        <!-- Table with Vertical Divider -->
        <table class="w-full border-collapse">
          <tbody class="divide-y divide-gray-200">
            <tr class="hover:bg-gray-50 transition">
              <td class="px-8 py-5 font-medium text-purple-700 align-top w-40">02:55 – 03:10</td>
              <td class="px-8 py-5 relative align-top">
                <span class="absolute left-0 top-0 bottom-0 w-px bg-gray-300"></span>
                <div class="pl-6">
                  <p class="font-medium text-gray-900 leading-relaxed">
                    Advancing Sustainable Gemstone Mining in Sri Lanka: The Role of International Trade Law and Technological Innovation
                  </p>
                  <p class="text-sm text-gray-600 italic mt-2">
                    C.W.S. Fonseka
                  </p>
                </div>
              </td>
            </tr>
            <tr class="hover:bg-gray-50 transition">
              <td class="px-8 py-5 font-medium text-purple-700 align-top">03:10 – 03:25</td>
              <td class="px-8 py-5 relative align-top">
                <span class="absolute left-0 top-0 bottom-0 w-px bg-gray-300"></span>
                <div class="pl-6">
                  <p class="font-medium text-gray-900 leading-relaxed">
                    Geo-Spatial Characterization of Gem Deposits in the Kanthale Region, Eastern Sri Lanka: A Field-Based Investigation of Occurrence, Distribution, and Genesis
                  </p>
                  <p class="text-sm text-gray-600 italic mt-2">
                    T.E.S. De Silva, I.M.R.I. Ilankoon, K.M.J.P. Wickaramage
                  </p>
                </div>
              </td>
            </tr>
            <tr class="hover:bg-gray-50 transition">
              <td class="px-8 py-5 font-medium text-purple-700 align-top">03:25 – 03:40</td>
              <td class="px-8 py-5 relative align-top">
                <span class="absolute left-0 top-0 bottom-0 w-px bg-gray-300"></span>
                <div class="pl-6">
                  <p class="font-medium text-gray-900 leading-relaxed">
                    Impacts of Illegal Gem Mining on Montane Forest Ecosystems in Harita Kanda–Manik Palama Region, Bopaththalawa, Central Highlands of Sri Lanka
                  </p>
                  <p class="text-sm text-gray-600 italic mt-2">
                    P. M. Perera, I.D.B. Gamage
                  </p>
                </div>
              </td>
            </tr>
            <tr class="hover:bg-gray-50 transition">
              <td class="px-8 py-5 font-medium text-purple-700 align-top">03:40 – 03:55</td>
              <td class="px-8 py-5 relative align-top">
                <span class="absolute left-0 top-0 bottom-0 w-px bg-gray-300"></span>
                <div class="pl-6">
                  <p class="font-medium text-gray-900 leading-relaxed">
                    Green Certification and Eco-Labelling of Gems: Integrating Environmental Sustainability with Luxury Branding in Sri Lanka
                  </p>
                  <p class="text-sm text-gray-600 italic mt-2">
                    C.L.Y.L. Fonseka, A.M.C.J.B. Attanayake, H.M.C. Hewamallimma, C.W.S. Fonseka
                  </p>
                </div>
              </td>
            </tr>
            <tr class="hover:bg-gray-50 transition">
              <td class="px-8 py-5 font-medium text-purple-700 align-top">03:55 – 04:10</td>
              <td class="px-8 py-5 relative align-top">
                <span class="absolute left-0 top-0 bottom-0 w-px bg-gray-300"></span>
                <div class="pl-6">
                  <p class="font-medium text-gray-900 leading-relaxed">
                    From Mining Waste to Construction Material: Performance Evaluation of Rounded Quartz-Based Paving Blocks
                  </p>
                  <p class="text-sm text-gray-600 italic mt-2">
                    Kishari Dayananda, Nimila Dushyantha, Jagath Kulathilaka
                  </p>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  </div>
</section>

<!-- SYMPOSIUM PROGRAM - PROFESSIONAL TABLE FORMAT -->
<section class="py-24 bg-gray-50">
  <div class="max-w-7xl mx-auto px-6">

    <!-- POSTER SESSION -->
    <div class="mt-16 bg-gradient-to-br from-yellow-50 to-amber-50 rounded-3xl shadow-2xl p-10 border-4 border-dashed border-amber-300">
      <h3 class="text-3xl font-bold text-primary text-center mb-8">Poster Session (10:00 AM Onwards)</h3>
      <div class="grid md:grid-cols-2 gap-6 text-sm">
        <?php
        $posters = [
          "Integrating Contemporary Casting Technologies in Traditional Goldsmithing – S. Thaneesan, N. Gajaruban",
          "Cybersecurity in Gem Tourism E-Commerce – C.L.Y.L. Fonseka, C.W.S. Fonseka",
          "Stakeholder-Based SWOT Analysis to Establish Gem Tourism – W.R. Lakshanthi et al.",
          "Value-added utilization of kaolin deposits found in gem mines – Y.D.T.I. Karunarathna, R.C.L. De Silva",
          "Spatio-Temporal Mapping of Mechanized Gem Mining (2020–2022) – T.E.S. De Silva et al.",
          "Fe/Ti Anomaly as a Novel Geochemical Indicator – Ruwanthika Kumari et al.",
          "Evaluation of the Gem Potentiality in the Ayagama Region – W.G.C.N. Wewegedara et al.",
          "Analysis of Thermally Enhanced Sri Lankan Geuda Stones Using Raman Spectroscopy – P.G.B.R.L. Bandara et al."
        ];
        foreach ($posters as $poster) {
          echo '<div class="bg-white p-6 rounded-xl shadow hover:shadow-xl transition border border-amber-200">
                  <p class="font-medium text-gray-800 leading-relaxed">' . $poster . '</p>
                </div>';
        }
        ?>
      </div>
    </div>
  </div>
</section>
<?php include 'includes/footer.php'; ?>