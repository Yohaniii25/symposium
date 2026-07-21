<?php include 'includes/header.php'; ?>

<!-- HERO -->
<section class="subpage-hero">
    <div class="subpage-hero-bg">
        <img src="./assets/img/breadcrumb.jpeg" alt="GJRTI 2026">
        <div class="subpage-hero-overlay"></div>
    </div>
    <div class="subpage-hero-content">
        <h1 class="subpage-hero-title">Contact Us</h1>
        <p class="subpage-hero-subtitle">We're here to help with any questions about GJRTI 2026</p>
    </div>
</section>

<!-- OFFICIAL CONTACT DETAILS -->
<section class="section-white-to-light">
    <div class="container-max">
        <div class="section-header">
            <h2 class="section-header-title">The Gem and Jewelry Research and Training Institute</h2>
            <p class="section-header-subtitle">(Public Organization)</p>
        </div>

        <div class="contact-grid">
            <!-- Phone -->
            <div class="contact-card">
                <div class="contact-card-inner">
                    <div class="contact-card-icon-wrapper">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>
                    <img src="" alt="" class="hidden"> <!-- spacer placeholder to maintain layout if needed, empty img is hidden -->
                    <h3 class="contact-card-title">Phone</h3>
                    <p class="contact-card-text">+94 11 2579 185</p>
                </div>
            </div>

            <!-- Fax -->
            <div class="contact-card">
                <div class="contact-card-inner">
                    <div class="contact-card-icon-wrapper">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="contact-card-title">Fax</h3>
                    <p class="contact-card-text">+94 11 2579 182</p>
                </div>
            </div>

            <!-- Email -->
            <div class="contact-card">
                <div class="contact-card-inner">
                    <div class="contact-card-icon-wrapper">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="contact-card-title">Email</h3>
                    <a href="mailto:sym.gjrti@gmail.com" class="text-accent hover:underline font-medium break-all">sym.gjrti@gmail.com</a>
                </div>
            </div>

            <!-- Address -->
            <div class="contact-card">
                <div class="contact-card-inner">
                    <div class="contact-card-icon-wrapper">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="contact-card-title">Address</h3>
                    <p class="contact-card-text text-sm leading-relaxed">
                        No: 73/5/A, "Ruwan Sewana",<br>Welivita, Kaduwela,<br>Sri Lanka
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CONTACT FORM SECTION -->
<section class="section-padding-medium section-light">
    <div class="container-max-medium">
        <!-- Section Header -->
        <div class="section-header">
            <h2 class="section-header-title">Send us a Message</h2>
            <p class="section-header-subtitle">Have a question? We'd love to hear from you. Fill out the form below.</p>
        </div>

        <!-- Form Card -->
        <div class="form-card">
            <form action="send-message.php" method="POST" class="form-grid">

                <!-- Name and Email Row -->
                <div class="form-grid">
                    <div>
                        <label class="form-label-theme">
                            Full Name <span class="form-required-star">*</span>
                        </label>
                        <input
                            type="text"
                            name="name"
                            required
                            placeholder="John Doe"
                            class="form-input-theme">
                    </div>

                    <div>
                        <label class="form-label-theme">
                            Email Address <span class="form-required-star">*</span>
                        </label>
                        <input
                            type="email"
                            name="email"
                            required
                            placeholder="john@example.com"
                            class="form-input-theme">
                    </div>
                </div>

                <!-- Phone Number Row -->
                <div class="form-grid-three">
                    <div>
                        <label class="form-label-theme">
                            Country Code <span class="form-required-star">*</span>
                        </label>
                        <select
                            name="country_code"
                            required
                            class="form-input-theme form-select-theme">
                            <option value="+94" selected>🇱🇰 +94</option>
                            <option value="+91">🇮🇳 +91</option>
                            <option value="+1">🇺🇸 +1</option>
                            <option value="+44">🇬🇧 +44</option>
                            <option value="+61">🇦🇺 +61</option>
                            <option value="+81">🇯🇵 +81</option>
                            <option value="+49">🇩🇪 +49</option>
                            <option value="+33">🇫🇷 +33</option>
                            <option value="+86">🇨🇳 +86</option>
                            <option value="+971">🇦🇪 +971</option>
                            <option value="+66">🇹🇭 +66</option>
                            <option value="+65">🇸🇬 +65</option>
                        </select>
                    </div>

                    <div class="col-span-2-md">
                        <label class="form-label-theme">
                            Phone Number <span class="form-required-star">*</span>
                        </label>
                        <input
                            type="tel"
                            name="phone"
                            required
                            placeholder="77 123 4567"
                            class="form-input-theme">
                    </div>
                </div>

                <!-- Subject -->
                <div class="form-group-full">
                    <label class="form-label-theme">
                        Subject <span class="form-required-star">*</span>
                    </label>
                    <select
                        name="subject"
                        required
                        class="form-input-theme form-select-theme">
                        <option value="">Select a subject</option>
                        <option value="General Inquiry">General Inquiry</option>
                        <option value="Registration Help">Registration Help</option>
                        <option value="Abstract Submission">Abstract Submission</option>
                        <option value="Payment Issue">Payment Issue</option>
                        <option value="Sponsorship">Sponsorship Opportunities</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <!-- Message -->
                <div class="form-group-full">
                    <label class="form-label-theme">
                        Message <span class="form-required-star">*</span>
                    </label>
                    <textarea
                        name="message"
                        rows="6"
                        required
                        placeholder="Write your message here..."
                        class="form-input-theme form-textarea-theme"></textarea>
                </div>

                <!-- Address (Optional) -->
                <div class="form-group-full">
                    <label class="form-label-theme">
                        Address <span class="subtitle-light">(Optional)</span>
                    </label>
                    <textarea
                        name="address"
                        rows="2"
                        placeholder="Your address"
                        class="form-input-theme form-textarea-theme"></textarea>
                </div>

                <!-- Submit Button -->
                <div class="pt-4 form-group-full">
                    <button
                        type="submit"
                        class="btn-submit">
                        <span class="mr-2">Send Message</span>
                        <svg class="w-5 h-5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                    </button>
                </div>

            </form>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>