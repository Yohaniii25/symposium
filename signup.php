<?php

require_once 'config/config.php';
require_once 'classes/database.php';
require_once 'classes/user.php';
require_once 'classes/auth.php';

$db = new Database();
$userModel = new User($db);
$auth = new Auth();

$message = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $regType = $_POST['reg_type'] ?? 'presenting';

  $data = [
    'title'            => trim($_POST['title']),
    'full_name'        => trim($_POST['full_name']),
    'nic_passport'     => !empty(trim($_POST['nic_passport'] ?? '')) ? trim($_POST['nic_passport']) : null,
    'email'            => trim($_POST['email']),
    'phone'            => trim($_POST['phone']),
    'food_preference'  => 'No Preference',
    'country_type'     => 'local', // Defaulting to local if omitted
  ];

  if ($regType === 'presenting') {
    $data['participant_type'] = 'Presenting Author';
    $data['abstract_name']    = trim($_POST['abstract_name']);
    $data['password']         = $_POST['password'];
    $data['confirm_password'] = $_POST['confirm_password'];
  } else {
    $data['participant_type'] = $_POST['participant_type'];
    $data['abstract_name']    = null;
    $data['password']         = null;
    $data['confirm_password'] = null;
  }

  // Validation
  $errors = [];
  if (empty($data['title'])) $errors[] = "Title is required";
  if (empty($data['full_name'])) $errors[] = "Full name is required";
  if ($regType === 'presenting' && empty($data['nic_passport'])) $errors[] = "NIC/Passport is required";
  if (empty($data['email'])) $errors[] = "Email is required";
  if (empty($data['phone'])) $errors[] = "Phone is required";

  if ($regType === 'presenting') {
    if (empty($data['abstract_name'])) $errors[] = "Abstract Name/Number is required for Presenting Authors";
    if (empty($data['password'])) $errors[] = "Password is required";
    if ($data['password'] !== $data['confirm_password']) $errors[] = "Passwords do not match";
    if (strlen($data['password']) < 6) $errors[] = "Password must be at least 6 characters";
  } else {
    if (empty($data['participant_type'])) $errors[] = "Participant Type is required";
  }

  if ($userModel->emailExists($data['email'])) $errors[] = "Email already registered";

  if (!empty($errors)) {
    $message = implode("<br>", $errors);
  } else {
    if ($userModel->register($data)) {
      $userId = $db->getConnection()->insert_id;

      // Generate reference number
      $year = date('Y');
      $refNumber = "GJRTI_SYMP_{$year}_" . str_pad($userId, 4, '0', STR_PAD_LEFT);

      // Save reference_no
      $stmt = $db->getConnection()->prepare("UPDATE users SET reference_no = ? WHERE id = ?");
      $stmt->bind_param("si", $refNumber, $userId);
      $stmt->execute();
      $stmt->close();

      if ($regType === 'presenting') {
        // Auto login
        $user = $userModel->login($data['email'], $_POST['password']);
        if ($user) {
          $_SESSION['user_reference'] = $refNumber;
          $auth->loginParticipant($user);
          header("Location: user-profile.php");
          exit();
        }
      } else {
        $success = "Registration successful! Thank you for registering.";
        // Clear form data for a fresh state
        $data = [];
      }
    } else {
      $message = "Registration failed. " . ($userModel->error ? "Error: " . $userModel->error : "Please try again.");
    }
  }
}
?>

<?php include 'includes/header.php'; ?>

<!-- HERO -->
<section class="subpage-hero">
  <div class="subpage-hero-bg">
    <img src="./assets/img/breadcrumb.jpeg" alt="">
    <div class="subpage-hero-overlay"></div>
  </div>
  <div class="subpage-hero-content">
    <h1 class="subpage-hero-title">Online Registration</h1>
    <p class="subpage-hero-subtitle">GJRTI 3rd International Research Symposium 2025</p>
  </div>
</section>

<section class="section-padding-large section-light">
  <div class="container-max">
    <div class="card-container-medium overflow-hidden">

      <div class="card-header-gradient">
        <h2 class="text-3xl md:text-4xl font-bold text-white">Symposium Registration</h2>
        <p class="mt-3 text-lg opacity-90 text-white">Join us for the 2025 Symposium</p>
      </div>

      <div class="form-card-padding">
        <?php if ($message): ?>
          <div class="alert-box-danger">
            <?= $message ?>
          </div>
        <?php endif; ?>

        <?php if ($success): ?>
          <div class="alert-box-success" style="background-color: #d1fae5; color: #065f46; border: 1px solid #10b981; padding: 1rem 1.5rem; border-radius: 0.75rem; margin-bottom: 2rem; text-align: center;">
            <?= $success ?>
          </div>
        <?php endif; ?>

        <!-- Tabs -->
        <div class="modern-tabs-container">
          <button type="button" class="modern-tab-btn active" id="tab_presenting">Registration for Presenting Authors</button>
          <button type="button" class="modern-tab-btn" id="tab_other">Registration for Other Participants</button>
        </div>
        <p id="other_info_note" style="display: none; color: var(--color-gray-600); font-size: 0.875rem; font-style: italic; text-align: center; margin-bottom: 2rem;">Note: Registration is conducted solely for the purpose of data collection. No login required.</p>

        <form method="POST" id="registrationForm">
          <input type="hidden" name="reg_type" id="reg_type_input" value="presenting">

          <!-- Accordion 1: Personal Details -->
          <div class="modern-accordion-item active" id="acc_personal">
            <div class="modern-accordion-header" onclick="toggleAccordion('acc_personal')">
              <span>1. Personal Details</span>
              <svg class="modern-accordion-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
              </svg>
            </div>
            <div class="modern-accordion-body">
              <div class="form-grid">
                <!-- Title -->
                <div>
                  <label class="form-label-modern">Title <span class="form-required-star">*</span></label>
                  <select name="title" required class="form-input-modern form-select-theme">
                    <option value="">Select Title</option>
                    <option <?= ($data['title'] ?? '') == 'Prof.' ? 'selected' : '' ?>>Prof.</option>
                    <option <?= ($data['title'] ?? '') == 'Dr.' ? 'selected' : '' ?>>Dr.</option>
                    <option <?= ($data['title'] ?? '') == 'Mr.' ? 'selected' : '' ?>>Mr.</option>
                    <option <?= ($data['title'] ?? '') == 'Ms.' ? 'selected' : '' ?>>Ms.</option>
                  </select>
                </div>

                <!-- Full Name -->
                <div>
                  <label class="form-label-modern">Full Name <span class="form-required-star">*</span></label>
                  <input type="text" name="full_name" value="<?= htmlspecialchars($data['full_name'] ?? '') ?>" required placeholder="Enter your full name"
                    class="form-input-modern">
                </div>

                <!-- NIC/Passport -->
                <div>
                  <label class="form-label-modern">NIC/Passport/Driving License <span class="form-required-star" id="nic_star">*</span></label>
                  <input type="text" name="nic_passport" id="nic_passport" value="<?= htmlspecialchars($data['nic_passport'] ?? '') ?>" placeholder="e.g. 199812345678"
                    class="form-input-modern">
                </div>

                <!-- Email -->
                <div>
                  <label class="form-label-modern">Email Address <span class="form-required-star">*</span></label>
                  <input type="email" name="email" value="<?= htmlspecialchars($data['email'] ?? '') ?>" required placeholder="name@example.com"
                    class="form-input-modern">
                </div>

                <!-- Phone -->
                <div>
                  <label class="form-label-modern">Contact Number <span class="form-required-star">*</span></label>
                  <input type="tel" name="phone" id="phone" value="<?= htmlspecialchars($data['phone'] ?? '') ?>" required placeholder="+94 77 123 4567"
                    class="form-input-modern">
                </div>
              </div>
            </div>
          </div>

          <!-- Accordion 2: Symposium Options -->
          <div class="modern-accordion-item" id="acc_symposium">
            <div class="modern-accordion-header" onclick="toggleAccordion('acc_symposium')">
              <span>2. Symposium Options</span>
              <svg class="modern-accordion-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
              </svg>
            </div>
            <div class="modern-accordion-body">
              <div class="form-grid">
                <!-- Abstract Name/Number -->
                <div id="field_abstract">
                  <label class="form-label-modern">Name of the Abstract and/or Abstract Number <span class="form-required-star">*</span></label>
                  <input type="text" name="abstract_name" id="abstract_name" value="<?= htmlspecialchars($data['abstract_name'] ?? '') ?>" placeholder="Enter abstract name or number"
                    class="form-input-modern">
                </div>

                <!-- Participant Type -->
                <div id="field_participant_type" style="display: none;">
                  <label class="form-label-modern">Participant Type <span class="form-required-star">*</span></label>
                  <select name="participant_type" id="participant_type" class="form-input-modern form-select-theme">
                    <option value="">Select Type</option>
                    <option <?= ($data['participant_type'] ?? '') == 'Co-authors' ? 'selected' : '' ?>>Co-authors</option>
                    <option <?= ($data['participant_type'] ?? '') == 'Trade representatives' ? 'selected' : '' ?>>Trade representatives</option>
                    <option <?= ($data['participant_type'] ?? '') == 'General attendees' ? 'selected' : '' ?>>General attendees</option>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <!-- Accordion 3: Account Security -->
          <div class="modern-accordion-item" id="acc_security">
            <div class="modern-accordion-header" onclick="toggleAccordion('acc_security')">
              <span>3. Account Security</span>
              <svg class="modern-accordion-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
              </svg>
            </div>
            <div class="modern-accordion-body">
              <div class="form-grid">
                <!-- Password -->
                <div id="field_password">
                  <label class="form-label-modern">Password <span class="form-required-star">*</span></label>
                  <input type="password" name="password" id="password" minlength="6" placeholder="Create password"
                    class="form-input-modern">
                </div>

                <!-- Confirm Password -->
                <div id="field_confirm_password">
                  <label class="form-label-modern">Confirm Password <span class="form-required-star">*</span></label>
                  <input type="password" name="confirm_password" id="confirm_password" minlength="6" placeholder="Confirm password"
                    class="form-input-modern">
                </div>
              </div>
            </div>
          </div>

          <div class="text-center mt-10">
            <button type="submit"
              class="btn-accent-large" id="submit_btn_text">
              <span class="mr-4">Register & Login</span>

            </button>
          </div>

          <p class="text-center text-gray-600 mt-8" id="login_link_area">
            Already have an account?
            <a href="login.php" class="text-accent font-bold hover-underline">Login here</a>
          </p>
        </form>
      </div>
    </div>
  </div>
</section>

<script>
  function toggleAccordion(id) {
    const item = document.getElementById(id);
    const siblings = document.querySelectorAll('.modern-accordion-item');
    siblings.forEach(el => {
      if (el.id !== id && el.style.display !== 'none') {
        el.classList.remove('active');
      }
    });
    item.classList.toggle('active');
  }

  document.addEventListener('DOMContentLoaded', function() {
    const tabPresenting = document.getElementById('tab_presenting');
    const tabOther = document.getElementById('tab_other');
    const regTypeInput = document.getElementById('reg_type_input');

    const accSecurity = document.getElementById('acc_security');
    const fieldAbstract = document.getElementById('field_abstract');
    const fieldParticipantType = document.getElementById('field_participant_type');

    const inputAbstract = document.getElementById('abstract_name');
    const inputParticipantType = document.getElementById('participant_type');
    const inputPassword = document.getElementById('password');
    const inputConfirmPassword = document.getElementById('confirm_password');
    const inputNic = document.getElementById('nic_passport');
    const nicStar = document.getElementById('nic_star');

    const submitBtnText = document.querySelector('#submit_btn_text span');
    const loginLinkArea = document.getElementById('login_link_area');
    const otherInfoNote = document.getElementById('other_info_note');

    function selectTab(type) {
      if (type === 'presenting') {
        tabPresenting.classList.add('active');
        tabOther.classList.remove('active');

        regTypeInput.value = 'presenting';

        fieldAbstract.style.display = 'block';
        accSecurity.style.display = 'block';
        fieldParticipantType.style.display = 'none';
        otherInfoNote.style.display = 'none';

        inputAbstract.required = true;
        inputPassword.required = true;
        inputConfirmPassword.required = true;
        inputParticipantType.required = false;

        inputNic.required = true;
        nicStar.style.display = 'inline';

        submitBtnText.textContent = 'Register & Login';
        loginLinkArea.style.display = 'block';
      } else {
        tabOther.classList.add('active');
        tabPresenting.classList.remove('active');

        regTypeInput.value = 'other';

        fieldAbstract.style.display = 'none';
        accSecurity.style.display = 'none';
        fieldParticipantType.style.display = 'block';
        otherInfoNote.style.display = 'block';

        inputAbstract.required = false;
        inputPassword.required = false;
        inputConfirmPassword.required = false;
        inputParticipantType.required = true;

        inputNic.required = false;
        nicStar.style.display = 'none';

        submitBtnText.textContent = 'Submit Registration';
        loginLinkArea.style.display = 'none';

        // Auto close security accordion if open
        accSecurity.classList.remove('active');
      }
    }

    tabPresenting.addEventListener('click', () => selectTab('presenting'));
    tabOther.addEventListener('click', () => selectTab('other'));

    selectTab('presenting');
  });
</script>

<?php include 'includes/footer.php'; ?>