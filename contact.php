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
            <!-- Symposium Co-Secretaries -->
            <div class="contact-card border-accent-top">
                <div class="contact-card-inner">
                    <div class="contact-card-icon-wrapper">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="contact-card-title">Co-Secretaries</h3>

                    <div class="officers-list-wrapper">
                        <div class="officer-detail-item">
                            <p class="officer-name">Mr. Sandun Illangasinghe <span class="officer-org">(GJRTI)</span></p>
                            <a href="tel:+94718160944" class="officer-phone-link">+94 (71) 816 0944</a>
                        </div>

                        <div class="officer-detail-item">
                            <p class="officer-name">Mr. Chamal Jaliya <span class="officer-org">(GASL)</span></p>
                            <a href="tel:+94714771844" class="officer-phone-link">+94 (71) 477 1844</a>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Symposium Co-Chairs -->
            <div class="contact-card border-accent-top">
                <div class="contact-card-inner">
                    <div class="contact-card-icon-wrapper">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                    </div>
                    <h3 class="contact-card-title">Co-Chairs</h3>

                    <div class="officers-list-wrapper">
                        <div class="officer-detail-item">
                            <p class="officer-name">Mr. Naleen Jayasinghe <span class="officer-org">(GJRTI)</span></p>
                            <a href="tel:+94713262622" class="officer-phone-link">+94 (71) 326 2622</a>
                        </div>

                        <div class="officer-detail-item">
                            <p class="officer-name">Mr. Nuwan Balage <span class="officer-org">(GASL)</span></p>
                            <a href="tel:+94777034670" class="officer-phone-link">+94 (77) 703 4670</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CONTACT FORM SECTION -->
<section class="section-padding-medium section-light">
    <!-- heading for contact form -->
    <div class="section-header">
        <h2 class="section-header-title">Contact Us</h2>
        <p class="section-header-subtitle">We're here to help with any questions about GJRTI 2026</p>
    </div>
    <div class="container-max-medium">
        <div class="contact-form-container">

            <form action="send-message.php" method="POST" class="contact-form-grid">

                <!-- Row 1: Dropdown and Text Input -->
                <div class="form-row-2col">
                    <div class="form-field-group">
                        <label for="contact-subject-dropdown" class="form-field-label">Subject <span class="required-star">*</span></label>
                        <select name="subject_select" id="contact-subject-dropdown" class="form-field-input select-input" required>
                            <option value="General" selected>General</option>
                            <option value="Registration help">Registration Help</option>
                            <option value="Abstract submission">Abstract Submission</option>
                            <option value="Payment issue">Payment Issue</option>
                            <option value="Sponsorship">Sponsorship Opportunities</option>
                        </select>
                    </div>

                    <div class="form-field-group">
                        <label for="contact-subject-input" class="form-field-label">Subject <span class="required-star">*</span></label>
                        <input type="text" name="subject_text" id="contact-subject-input" class="form-field-input" placeholder="Subject" required>
                    </div>
                </div>

                <!-- Row 2: Message Textarea -->
                <div class="form-row-full">
                    <div class="form-field-group">
                        <label for="contact-message" class="form-field-label">Message <span class="required-star">*</span></label>
                        <textarea name="message" id="contact-message" class="form-field-input textarea-input" placeholder="Message" rows="5" required></textarea>
                    </div>
                </div>

                <!-- Row 3: Name and Email -->
                <div class="form-row-2col">
                    <div class="form-field-group">
                        <label for="contact-name" class="form-field-label">Full Name <span class="required-star">*</span></label>
                        <input type="text" name="name" id="contact-name" class="form-field-input" placeholder="Full Name" required>
                    </div>

                    <div class="form-field-group">
                        <label for="contact-email" class="form-field-label">Email <span class="required-star">*</span></label>
                        <input type="email" name="email" id="contact-email" class="form-field-input" placeholder="Email" required>
                    </div>
                </div>

                <!-- Row 4: Address and Phone Number -->
                <div class="form-row-2col">
                    <div class="form-field-group">
                        <label for="contact-address" class="form-field-label">Address <span class="required-star">*</span></label>
                        <input type="text" name="address" id="contact-address" class="form-field-input" placeholder="Address" required>
                    </div>

                    <div class="form-field-group">
                        <label class="form-field-label">Phone Number <span class="required-star">*</span></label>
                        <div class="composite-phone-field">
                            <select name="country_code" id="contact-country-code" class="phone-country-code select-input" required>
                                <option value="+94" selected>🇱🇰 (+94)</option>
                                <option value="+91">🇮🇳 (+91)</option>
                                <option value="+1">🇺🇸 (+1)</option>
                                <option value="+44">🇬🇧 (+44)</option>
                                <option value="+61">🇦🇺 (+61)</option>
                            </select>
                            <input type="tel" name="phone" id="contact-phone" class="phone-number-field" placeholder="Phone Number" required>
                        </div>
                    </div>
                </div>

                <!-- Row 5: Action Buttons (Bottom Left Aligned) -->
                <div class="form-actions-left">
                    <button type="submit" class="btn-form-primary">Send</button>
                    <button type="button" class="btn-form-secondary" onclick="window.history.back();">Cancel</button>
                </div>

            </form>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>