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

        // 3. Dynamic Login Form handler (AJAX with PHP + MySQL)
        var loginForm = document.getElementById('login-form');
        if (loginForm) {
            loginForm.addEventListener('submit', function (e) {
                e.preventDefault();

                var alertBox = document.getElementById('auth-alert');
                var submitBtn = document.getElementById('login-submit-btn') || loginForm.querySelector('.auth-btn-submit');
                if (!submitBtn) return;

                var emailInput = document.getElementById('login-email');
                var passwordInput = document.getElementById('login-password');

                var errEmail = document.getElementById('error-login-email');
                var errPassword = document.getElementById('error-login-password');

                function clearLoginErrors() {
                    [errEmail, errPassword].forEach(function (el) {
                        if (el) {
                            el.textContent = '';
                            el.classList.remove('show');
                        }
                    });
                    [emailInput, passwordInput].forEach(function (inp) {
                        if (inp) {
                            inp.classList.remove('is-invalid');
                        }
                    });
                    if (alertBox) {
                        alertBox.className = 'auth-alert';
                        alertBox.innerHTML = '';
                    }
                }

                function showLoginFieldError(input, errorEl, message) {
                    if (input) input.classList.add('is-invalid');
                    if (errorEl) {
                        errorEl.textContent = message;
                        errorEl.classList.add('show');
                    }
                }

                clearLoginErrors();

                var email = emailInput ? emailInput.value.trim() : '';
                var password = passwordInput ? passwordInput.value : '';
                var hasClientError = false;

                if (!email) {
                    showLoginFieldError(emailInput, errEmail, 'Email Address is required.');
                    hasClientError = true;
                } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                    showLoginFieldError(emailInput, errEmail, 'Please enter a valid email address.');
                    hasClientError = true;
                }

                if (!password) {
                    showLoginFieldError(passwordInput, errPassword, 'Password is required.');
                    hasClientError = true;
                }

                if (hasClientError) {
                    if (alertBox) {
                        alertBox.className = 'auth-alert alert-error show';
                        alertBox.innerHTML = '<i class="fas fa-exclamation-circle"></i> <span>Please fill in all required fields.</span>';
                    }
                    return;
                }

                // Prevent multiple submissions
                if (submitBtn.disabled) {
                    return;
                }

                // Button loading state
                submitBtn.disabled = true;
                var originalHtml = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Signing In...';

                var formData = new FormData(loginForm);
                formData.append('ajax', '1');

                var targetUrl = loginForm.getAttribute('action') || window.location.href;

                fetch(targetUrl, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(function (response) {
                    return response.json().then(function (data) {
                        return { ok: response.ok, status: response.status, data: data };
                    });
                })
                .then(function (result) {
                    var data = result.data;
                    if (result.ok && data.success) {
                        if (alertBox) {
                            alertBox.className = 'auth-alert alert-success show';
                            alertBox.innerHTML = '<i class="fas fa-check-circle"></i> <span>' + (data.message || 'Login successful! Welcome back.') + '</span>';
                        }
                        submitBtn.innerHTML = '<i class="fas fa-check"></i> Success';

                        setTimeout(function () {
                            window.location.href = data.redirect || '../index.php';
                        }, 600);
                    } else {
                        if (alertBox) {
                            alertBox.className = 'auth-alert alert-error show';
                            alertBox.innerHTML = '<i class="fas fa-exclamation-circle"></i> <span>' + (data.message || 'Sign in failed. Please check your credentials.') + '</span>';
                        }
                        if (data.errors) {
                            if (data.errors.email) showLoginFieldError(emailInput, errEmail, data.errors.email);
                            if (data.errors.password) showLoginFieldError(passwordInput, errPassword, data.errors.password);
                        }
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalHtml;
                    }
                })
                .catch(function (error) {
                    console.error('Login AJAX Error:', error);
                    if (alertBox) {
                        alertBox.className = 'auth-alert alert-error show';
                        alertBox.innerHTML = '<i class="fas fa-exclamation-triangle"></i> <span>A network error occurred. Please try again.</span>';
                    }
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalHtml;
                });
            });
        }

        // 4. Dynamic Register Form handler (AJAX with PHP + MySQL)
        var registerForm = document.getElementById('register-form');
        if (registerForm) {
            registerForm.addEventListener('submit', function (e) {
                e.preventDefault();

                var alertBox = document.getElementById('auth-alert');
                var submitBtn = document.getElementById('reg-submit-btn') || registerForm.querySelector('.auth-btn-submit');
                if (!submitBtn) return;

                // Inputs
                var fullNameInput = document.getElementById('reg-full-name');
                var emailInput = document.getElementById('reg-email');
                var passwordInput = document.getElementById('reg-password');
                var confirmPasswordInput = document.getElementById('reg-confirm-password');

                // Error text containers below inputs
                var errFullName = document.getElementById('error-full_name');
                var errEmail = document.getElementById('error-email');
                var errPassword = document.getElementById('error-password');
                var errConfirmPassword = document.getElementById('error-confirm_password');

                function clearErrors() {
                    [errFullName, errEmail, errPassword, errConfirmPassword].forEach(function (el) {
                        if (el) {
                            el.textContent = '';
                            el.classList.remove('show');
                        }
                    });
                    [fullNameInput, emailInput, passwordInput, confirmPasswordInput].forEach(function (inp) {
                        if (inp) {
                            inp.classList.remove('is-invalid');
                        }
                    });
                    if (alertBox) {
                        alertBox.className = 'auth-alert';
                        alertBox.innerHTML = '';
                    }
                }

                function showFieldError(input, errorEl, message) {
                    if (input) input.classList.add('is-invalid');
                    if (errorEl) {
                        errorEl.textContent = message;
                        errorEl.classList.add('show');
                    }
                }

                clearErrors();

                // Quick client-side pre-validation
                var fullName = fullNameInput ? fullNameInput.value.trim() : '';
                var email = emailInput ? emailInput.value.trim() : '';
                var password = passwordInput ? passwordInput.value : '';
                var confirmPassword = confirmPasswordInput ? confirmPasswordInput.value : '';

                var hasClientError = false;

                if (!fullName) {
                    showFieldError(fullNameInput, errFullName, 'Full Name is required.');
                    hasClientError = true;
                } else if (fullName.length < 2) {
                    showFieldError(fullNameInput, errFullName, 'Full Name must be at least 2 characters.');
                    hasClientError = true;
                }

                if (!email) {
                    showFieldError(emailInput, errEmail, 'Email Address is required.');
                    hasClientError = true;
                } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                    showFieldError(emailInput, errEmail, 'Please enter a valid email address.');
                    hasClientError = true;
                }

                if (!password) {
                    showFieldError(passwordInput, errPassword, 'Password is required.');
                    hasClientError = true;
                } else if (password.length < 8) {
                    showFieldError(passwordInput, errPassword, 'Password must contain at least 8 characters.');
                    hasClientError = true;
                }

                if (!confirmPassword) {
                    showFieldError(confirmPasswordInput, errConfirmPassword, 'Please confirm your password.');
                    hasClientError = true;
                } else if (password && password !== confirmPassword) {
                    showFieldError(confirmPasswordInput, errConfirmPassword, 'Passwords do not match.');
                    hasClientError = true;
                }

                if (hasClientError) {
                    if (alertBox) {
                        alertBox.className = 'auth-alert alert-error show';
                        alertBox.innerHTML = '<i class="fas fa-exclamation-circle"></i> <span>Please correct the highlighted errors.</span>';
                    }
                    return;
                }

                // Prevent multiple submissions
                if (submitBtn.disabled) {
                    return;
                }

                // Loading state on Register button
                submitBtn.disabled = true;
                var originalHtml = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Registering...';

                var formData = new FormData(registerForm);
                formData.append('ajax', '1');

                var targetUrl = registerForm.getAttribute('action') || window.location.href;

                fetch(targetUrl, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(function (response) {
                    return response.json().then(function (data) {
                        return { ok: response.ok, status: response.status, data: data };
                    });
                })
                .then(function (result) {
                    var data = result.data;
                    if (result.ok && data.success) {
                        // Display success message
                        if (alertBox) {
                            alertBox.className = 'auth-alert alert-success show';
                            alertBox.innerHTML = '<i class="fas fa-check-circle"></i> <span>' + (data.message || 'Account registered successfully!') + '</span>';
                        }
                        registerForm.reset();
                        submitBtn.innerHTML = '<i class="fas fa-check"></i> Registered!';
                        submitBtn.disabled = false;

                        // Clear strength bars if any
                        strengthBars.forEach(function (b) { b.style.backgroundColor = 'rgba(5, 31, 52, 0.1)'; });
                        if (strengthText) strengthText.textContent = '';

                        // Reset button text after 3 seconds
                        setTimeout(function () {
                            submitBtn.innerHTML = originalHtml;
                        }, 3000);
                    } else {
                        // Display error message
                        if (alertBox) {
                            alertBox.className = 'auth-alert alert-error show';
                            alertBox.innerHTML = '<i class="fas fa-exclamation-circle"></i> <span>' + (data.message || 'Registration failed.') + '</span>';
                        }
                        // Display validation errors below relevant fields
                        if (data.errors) {
                            if (data.errors.full_name) showFieldError(fullNameInput, errFullName, data.errors.full_name);
                            if (data.errors.email) showFieldError(emailInput, errEmail, data.errors.email);
                            if (data.errors.password) showFieldError(passwordInput, errPassword, data.errors.password);
                            if (data.errors.confirm_password) showFieldError(confirmPasswordInput, errConfirmPassword, data.errors.confirm_password);
                        }
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalHtml;
                    }
                })
                .catch(function (error) {
                    console.error('Registration AJAX Error:', error);
                    if (alertBox) {
                        alertBox.className = 'auth-alert alert-error show';
                        alertBox.innerHTML = '<i class="fas fa-exclamation-triangle"></i> <span>A network error occurred. Please try again.</span>';
                    }
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalHtml;
                });
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

