/**
 * Luxury Authentication Interaction Script
 * Handles show/hide password, client validation, interactive alerts, and tab switches
 */
(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        // 1. Password visibility toggle
        var toggleBtns = document.querySelectorAll('.password-toggle-btn');
        toggleBtns.forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                var input = btn.parentElement.querySelector('input');
                var icon = btn.querySelector('i');
                if (!input) return;

                if (input.type === 'password') {
                    input.type = 'text';
                    if (icon) {
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    }
                    btn.setAttribute('aria-label', 'Hide password');
                } else {
                    input.type = 'password';
                    if (icon) {
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    }
                    btn.setAttribute('aria-label', 'Show password');
                }
            });
        });

        // 2. Password Strength Evaluation (for register & reset password)
        var newPasswordInput = document.getElementById('reg-password') || document.getElementById('reset-password');
        var strengthBars = document.querySelectorAll('.strength-bar');
        var strengthText = document.querySelector('.strength-text');

        if (newPasswordInput && strengthBars.length > 0) {
            newPasswordInput.addEventListener('input', function () {
                var val = newPasswordInput.value;
                var score = 0;
                if (val.length >= 8) score++;
                if (/[A-Z]/.test(val) && /[a-z]/.test(val)) score++;
                if (/[0-9]/.test(val)) score++;
                if (/[^A-Za-z0-9]/.test(val)) score++;

                strengthBars.forEach(function (bar, idx) {
                    if (val.length === 0) {
                        bar.style.backgroundColor = 'rgba(5, 31, 52, 0.1)';
                    } else if (idx < score) {
                        if (score <= 1) bar.style.backgroundColor = '#d32f2f';
                        else if (score === 2) bar.style.backgroundColor = '#f57c00';
                        else if (score === 3) bar.style.backgroundColor = '#fbc02d';
                        else bar.style.backgroundColor = '#388e3c';
                    } else {
                        bar.style.backgroundColor = 'rgba(5, 31, 52, 0.1)';
                    }
                });

                if (strengthText) {
                    if (val.length === 0) strengthText.textContent = '';
                    else if (score <= 1) strengthText.textContent = 'Weak password';
                    else if (score === 2) strengthText.textContent = 'Moderate password';
                    else if (score === 3) strengthText.textContent = 'Strong password';
                    else strengthText.textContent = 'Very strong password';
                }
            });
        }

        // 3. Login Form handler
        var loginForm = document.getElementById('login-form');
        if (loginForm) {
            loginForm.addEventListener('submit', function (e) {
                e.preventDefault();
                var alertBox = document.getElementById('auth-alert');
                var submitBtn = loginForm.querySelector('.auth-btn-submit');
                var originalText = submitBtn ? submitBtn.innerHTML : 'Sign In';

                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Signing In...';
                }

                setTimeout(function () {
                    if (alertBox) {
                        alertBox.className = 'auth-alert alert-success show';
                        alertBox.innerHTML = '<i class="fas fa-check-circle"></i> <span>Welcome back! Authentication successful. Redirecting to your account...</span>';
                    }
                    if (submitBtn) {
                        submitBtn.innerHTML = '<i class="fas fa-check"></i> Success';
                    }
                    setTimeout(function () {
                        window.location.href = '../index.php';
                    }, 1200);
                }, 800);
            });
        }

        // 4. Register Form handler
        var registerForm = document.getElementById('register-form');
        if (registerForm) {
            registerForm.addEventListener('submit', function (e) {
                e.preventDefault();
                var pwd = document.getElementById('reg-password');
                var confirmPwd = document.getElementById('reg-confirm-password');
                var alertBox = document.getElementById('auth-alert');
                var submitBtn = registerForm.querySelector('.auth-btn-submit');

                if (pwd && confirmPwd && pwd.value !== confirmPwd.value) {
                    if (alertBox) {
                        alertBox.className = 'auth-alert alert-error show';
                        alertBox.innerHTML = '<i class="fas fa-exclamation-circle"></i> <span>The passwords do not match. Please verify and try again.</span>';
                    }
                    return;
                }

                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating Account...';
                }

                setTimeout(function () {
                    if (alertBox) {
                        alertBox.className = 'auth-alert alert-success show';
                        alertBox.innerHTML = '<i class="fas fa-check-circle"></i> <span>Account successfully created! Welcome to our exclusive circle. Redirecting...</span>';
                    }
                    setTimeout(function () {
                        window.location.href = './login.php?registered=1';
                    }, 1200);
                }, 900);
            });
        }

        // 5. Forgot Password Form handler
        var forgotForm = document.getElementById('forgot-form');
        if (forgotForm) {
            forgotForm.addEventListener('submit', function (e) {
                e.preventDefault();
                var emailInput = document.getElementById('forgot-email');
                var alertBox = document.getElementById('auth-alert');
                var submitBtn = forgotForm.querySelector('.auth-btn-submit');

                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending Link...';
                }

                setTimeout(function () {
                    var email = emailInput ? emailInput.value : 'your email';
                    if (alertBox) {
                        alertBox.className = 'auth-alert alert-success show';
                        alertBox.innerHTML =
                            '<i class="fas fa-envelope-open-text"></i> ' +
                            '<div>' +
                            '<strong>Reset link dispatched!</strong><br>' +
                            'An email has been sent to <u>' + email + '</u> with instructions to reset your password.<br>' +
                            '<div style="margin-top: 8px;"><a href="./reset-password.php?token=demo" class="auth-forgot-link" style="text-decoration: underline; font-weight: 600;">&rarr; Click here to simulate opening the Reset Link</a></div>' +
                            '</div>';
                    }
                    if (submitBtn) {
                        submitBtn.innerHTML = '<i class="fas fa-check"></i> Email Dispatched';
                    }
                }, 750);
            });
        }

        // 6. Reset Password Form handler
        var resetForm = document.getElementById('reset-form');
        if (resetForm) {
            resetForm.addEventListener('submit', function (e) {
                e.preventDefault();
                var pwd = document.getElementById('reset-password');
                var confirmPwd = document.getElementById('reset-confirm-password');
                var alertBox = document.getElementById('auth-alert');
                var submitBtn = resetForm.querySelector('.auth-btn-submit');

                if (pwd && confirmPwd && pwd.value !== confirmPwd.value) {
                    if (alertBox) {
                        alertBox.className = 'auth-alert alert-error show';
                        alertBox.innerHTML = '<i class="fas fa-exclamation-circle"></i> <span>Passwords do not match. Please verify and re-enter.</span>';
                    }
                    return;
                }

                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating Password...';
                }

                setTimeout(function () {
                    if (alertBox) {
                        alertBox.className = 'auth-alert alert-success show';
                        alertBox.innerHTML = '<i class="fas fa-check-circle"></i> <span>Your password has been securely updated! Redirecting to sign in...</span>';
                    }
                    setTimeout(function () {
                        window.location.href = './login.php?reset=success';
                    }, 1400);
                }, 850);
            });
        }
    });
})();

