jQuery(document).ready(function($) {
    const overlay = $('#ukroa_sign_overlay');
    const modal = $('#ukroa_sign_modal');
    const loginForm = $('#ukroa_sign_login');
    const signupForm = $('#ukroa_sign_signup');

    // Open modal
    $('.ukroa_sign_trigger').on('click', function(e) {
        if ($(this).attr('href') !== '#') return;
        e.preventDefault();
        overlay.fadeIn(200);
        modal.fadeIn(300);
        loginForm.show();
        signupForm.hide();
        $('.ukroa_sign_message').empty();
    });

    // Close modal
    overlay.on('click', function() {
        overlay.fadeOut(200);
        modal.fadeOut(200);
    });
    $(document).on('keyup', function(e) {
        if (e.key === 'Escape') {
            overlay.fadeOut(200);
            modal.fadeOut(200);
        }
    });

    // Switch to Signup
    $('#ukroa_sign_to_signup').on('click', function(e) {
        e.preventDefault();
        loginForm.hide();
        signupForm.show();
        $('.ukroa_sign_message').empty();
    });

    // Switch to Login
    $('#ukroa_sign_to_login').on('click', function(e) {
        e.preventDefault();
        signupForm.hide();
        loginForm.show();
        $('.ukroa_sign_message').empty();
    });

    // Login Submit
    $('#ukroa_sign_login_form').on('submit', function(e) {
        e.preventDefault();
        const msg = $(this).find('.ukroa_sign_message');
        msg.removeClass('success error').html('Signing in...');

        $.post(ukroa_sign_ajax.ajax_url, {
            action: 'ukroa_sign_login',
            username: $(this).find('[name="username"]').val(),
            password: $(this).find('[name="password"]').val()
        }, function(res) {
            if (res.success) {
                msg.html('<div class="success">Login successful! Redirecting...</div>');
                setTimeout(() => location.reload(), 1500);
            } else {
                msg.html('<div class="error">' + (res.data || 'Invalid credentials.') + '</div>');
            }
        }).fail(function() {
            msg.html('<div class="error">Connection error.</div>');
        });
    });

    // Signup Submit
    $('#ukroa_sign_signup_form').on('submit', function(e) {
        e.preventDefault();
        const msg = $(this).find('.ukroa_sign_message');
        msg.removeClass('success error').html('Creating account...');

        const formData = new FormData(this);
        formData.append('action', 'ukroa_sign_signup');

        $.ajax({
            url: ukroa_sign_ajax.ajax_url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                if (res.success) {
                    msg.html('<div class="success">Thank You For signing Up, We will confirm soon and Authorize you if you are eligible</div>');
                    $('#ukroa_sign_signup_form')[0].reset();
                } else {
                    msg.html('<div class="error">' + (res.data || 'Signup failed. Try again.') + '</div>');
                }
            },
            error: function() {
                msg.html('<div class="error">Network error. Please try again.</div>');
            }
        });
    });
});