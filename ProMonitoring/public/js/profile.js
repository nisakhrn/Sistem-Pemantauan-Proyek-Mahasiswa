$(document).ready(function() {
    // Profile Picture Click Handler
    $('.profile-img-container').click(function() {
        const imgSrc = $('#profileImage').attr('src');
        
        // Check if user has profile picture or it's default
        if (imgSrc.includes('default-avatar.png')) {
            // If default image, directly open file selector
            $('#profilePictureInput').click();
        } else {
            // If has profile picture, show preview modal
            $('#previewImage').attr('src', imgSrc);
            $('#imagePreviewModal').modal('show');
        }
    });

    // Change Photo button in modal
    $('#changePhotoBtn').click(function() {
        $('#imagePreviewModal').modal('hide');
        $('#profilePictureInput').click();
    });

    // Profile Picture Upload
    $('#profilePictureInput').change(function() {
        const file = this.files[0];
        if (file) {
            // Validate file type
            const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            if (!validTypes.includes(file.type)) {
                showAlert('danger', 'File harus berupa gambar dengan format JPEG, PNG, atau GIF.');
                return;
            }

            // Validate file size (2MB)
            if (file.size > 2 * 1024 * 1024) {
                showAlert('danger', 'Ukuran file tidak boleh lebih dari 2MB.');
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                $('#profileImage').attr('src', e.target.result);
            };
            reader.readAsDataURL(file);
            
            // Upload profile picture
            uploadProfilePicture(file);
        }
    });

    // Update Profile Form
    $('#updateProfileForm').submit(function(e) {
        e.preventDefault();
        
        const btn = $(this).find('button[type="submit"]');
        const originalText = btn.html();
        
        btn.addClass('loading').prop('disabled', true);
        
        $.ajax({
            url: '/profile/update',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                showAlert('success', 'Profil berhasil diperbarui!');
                // Update profile name in header if exists
                $('.profile-name').text($('#name').val());
            },
            error: function(xhr) {
                let message = 'Terjadi kesalahan saat memperbarui profil.';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    message = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                }
                showAlert('danger', message);
            },
            complete: function() {
                btn.removeClass('loading').prop('disabled', false).html(originalText);
            }
        });
    });

    // Change Password Form
    $('#changePasswordForm').submit(function(e) {
        e.preventDefault();
        
        const btn = $(this).find('button[type="submit"]');
        const originalText = btn.html();
        
        // Validate password confirmation
        const newPassword = $('#new_password').val();
        const confirmPassword = $('#new_password_confirmation').val();
        
        if (newPassword !== confirmPassword) {
            showAlert('danger', 'Konfirmasi kata sandi tidak cocok!');
            return;
        }
        
        btn.addClass('loading').prop('disabled', true);
        
        $.ajax({
            url: '/profile/change-password',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                showAlert('success', 'Kata sandi berhasil diubah!');
                $('#changePasswordForm')[0].reset();
            },
            error: function(xhr) {
                let message = 'Terjadi kesalahan saat mengubah kata sandi.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                    message = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                }
                showAlert('danger', message);
            },
            complete: function() {
                btn.removeClass('loading').prop('disabled', false).html(originalText);
            }
        });
    });

    // Delete Account
    $('#confirmDeleteAccount').click(function() {
        const password = $('#delete_password').val();
        
        if (!password) {
            showAlert('danger', 'Masukkan kata sandi untuk konfirmasi!');
            return;
        }
        
        const btn = $(this);
        const originalText = btn.html();
        
        btn.addClass('loading').prop('disabled', true);
        
        $.ajax({
            url: '/profile/delete-account',
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                password: password
            },
            success: function(response) {
                showAlert('success', 'Akun berhasil dihapus. Mengalihkan ke halaman login...');
                setTimeout(function() {
                    window.location.href = '/login';
                }, 2000);
            },
            error: function(xhr) {
                let message = 'Terjadi kesalahan saat menghapus akun.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
                showAlert('danger', message);
                btn.removeClass('loading').prop('disabled', false).html(originalText);
            }
        });
    });

    // Upload Profile Picture Function
    function uploadProfilePicture(file) {
        const formData = new FormData();
        formData.append('profile_picture', file);
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
        
        // Show loading indicator
        $('.profile-img-overlay').addClass('uploading');
        
        $.ajax({
            url: '/profile/upload-picture',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                showAlert('success', 'Foto profil berhasil diperbarui!');
                // Update image source with new URL to prevent caching
                if (response.profile_picture_url) {
                    $('#profileImage').attr('src', response.profile_picture_url + '?t=' + new Date().getTime());
                }
            },
            error: function(xhr) {
                let message = 'Terjadi kesalahan saat mengupload foto profil.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
                showAlert('danger', message);
                
                // Reset image to original
                location.reload();
            },
            complete: function() {
                $('.profile-img-overlay').removeClass('uploading');
            }
        });
    }

    // Show Alert Function
    function showAlert(type, message) {
        // Remove existing alerts
        $('.alert').remove();
        
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        `;
        
        $('.card-body').first().prepend(alertHtml);
        
        // Auto hide success alerts after 5 seconds
        if (type === 'success') {
            setTimeout(function() {
                $('.alert-success').fadeOut();
            }, 5000);
        }
        
        // Scroll to top to show alert
        $('html, body').animate({
            scrollTop: $('.alert').offset().top - 100
        }, 300);
    }

    // Password strength indicator (optional enhancement)
    $('#new_password').on('input', function() {
        const password = $(this).val();
        const strength = checkPasswordStrength(password);
        
        // Remove existing strength indicator
        $('.password-strength').remove();
        
        if (password.length > 0) {
            const strengthHtml = `
                <div class="password-strength mt-1">
                    <small class="text-${strength.color}">
                        Kekuatan password: ${strength.text}
                    </small>
                </div>
            `;
            $(this).parent().append(strengthHtml);
        }
    });

    // Password Strength Checker
    function checkPasswordStrength(password) {
        let score = 0;
        
        if (password.length >= 8) score++;
        if (/[a-z]/.test(password)) score++;
        if (/[A-Z]/.test(password)) score++;
        if (/[0-9]/.test(password)) score++;
        if (/[^A-Za-z0-9]/.test(password)) score++;
        
        switch (score) {
            case 0:
            case 1:
                return { color: 'danger', text: 'Sangat Lemah' };
            case 2:
                return { color: 'warning', text: 'Lemah' };
            case 3:
                return { color: 'info', text: 'Sedang' };
            case 4:
                return { color: 'primary', text: 'Kuat' };
            case 5:
                return { color: 'success', text: 'Sangat Kuat' };
            default:
                return { color: 'secondary', text: 'Unknown' };
        }
    }

    // Form validation enhancements
    $('form input').on('blur', function() {
        validateField($(this));
    });

    function validateField(field) {
        const fieldName = field.attr('name');
        const fieldValue = field.val().trim();
        
        // Remove existing validation feedback
        field.removeClass('is-valid is-invalid');
        field.siblings('.invalid-feedback, .valid-feedback').remove();
        
        let isValid = true;
        let message = '';
        
        switch (fieldName) {
            case 'name':
                if (fieldValue.length < 2) {
                    isValid = false;
                    message = 'Nama harus minimal 2 karakter.';
                }
                break;
            case 'email':
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(fieldValue)) {
                    isValid = false;
                    message = 'Format email tidak valid.';
                }
                break;
            case 'new_password':
                if (fieldValue.length > 0 && fieldValue.length < 6) {
                    isValid = false;
                    message = 'Password harus minimal 6 karakter.';
                }
                break;
        }
        
        if (fieldValue.length > 0) {
            if (isValid) {
                field.addClass('is-valid');
            } else {
                field.addClass('is-invalid');
                field.parent().append(`<div class="invalid-feedback">${message}</div>`);
            }
        }
    }

    // Image error handler
    $('#profileImage').on('error', function() {
        $(this).attr('src', '/images/default-avatar.png');
    });
});