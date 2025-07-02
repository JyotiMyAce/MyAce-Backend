@extends('layout.master')
@section('title', __('MyAce | Login'))
@section('content')
    @push('custom-css')
        <style>
            .pass-group {
                position: relative;
            }

            .toggle-password {
                position: absolute;
                top: 50%;
                right: 15px;
                transform: translateY(-50%);
                cursor: pointer;
                z-index: 2;
                color: #aaa;
                font-size: 16px;
                line-height: 1;
                pointer-events: auto;
            }

            label.error {
                margin-top: 4px;
                font-size: 13px;
                color: red;
                display: block;
                position: absolute;
                bottom: -33px;
                left: 0;
            }

            .pass-group {
                margin-bottom: 25px;
            }
        </style>
    @endpush
    <div class="account-content">
        <div class="login-wrapper">
            <div class="login-content">
                <form id="login_form" name="login_form">
                    @csrf
                    <div class="login-userset">
                        <div class="login-logo logo-normal">
                            <img src="{{ asset('assets/img/logo.png') }}" alt="img">
                        </div>
                        <a href="index.html" class="login-logo logo-white">
                            <img src="{{ asset('assets/img/logo-white.png') }}" alt="">
                        </a>
                        <div class="login-userheading">
                            <h3>Sign In</h3>
                            <h4>Access the Dreamspos panel using your email and passcode.</h4>
                        </div>

                        <div class="form-login">
                            <label>Email Address</label>
                            <div class="form-addons">
                                <input type="text" class="form-control" name="email" autocomplete="email">
                                <img src="{{ asset('assets/img/icons/mail.svg') }}" alt="img">
                            </div>
                        </div>

                        <div class="form-login position-relative">
                            <label>Password</label>
                            <div class="pass-group">
                                <input type="password" class="form-control" name="password" autocomplete="current-password">
                                <i class="toggle-password fa fa-fw fa-eye-slash"></i>
                            </div>
                        </div>
                        <div class="alert alert-success success_msg" style="display:none;" role="alert"> 
                        </div>
                        <div class="alert alert-danger error_msg" style="display:none;" role="alert"> 
                        </div>
                        <div class="form-login">
                            <button type="submit" class="btn btn-login">Sign In</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="login-img">
                <img src="{{ asset('assets/img/authentication/login02.png') }}" alt="img">
            </div>
        </div>
    </div>

@endsection

@push('custom-script')
    <script>
        $(document).ready(function() {

            $('#login_form').validate({
                rules: {
                    email: {
                        required: true,
                        email: true,
                    },
                    password: {
                        required: true,
                    },
                },
                messages: {
                    email: {
                        required: 'Please enter your email',
                        email: 'Please enter a valid email format',
                    },
                    password: {
                        required: 'Please enter your password'
                    },
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: `{{ route('admin.login') }}`,
                        type: "POST",
                        data: $(form).serialize(),
                        beforeSend: function() {
                            $('.error_msg, .success_msg').hide().html('');
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                $('.success_msg').html(response.message).fadeIn();
                                setTimeout(() => {
                                    $('.success_msg').fadeOut();
                                        window.location.href = `{{route('admin.dashboard')}}`;
                                }, 2000);
                            } else {
                                $('.error_msg').html(response.message).fadeIn();
                                setTimeout(() => $('.error_msg').fadeOut(), 4000);
                            }
                        },
                        error: function(xhr) {
                            $('.error_msg').html('Something went wrong. Please try again.')
                                .fadeIn();
                            setTimeout(() => $('.error_msg').fadeOut(), 4000);

                            if (xhr.responseJSON && xhr.responseJSON.errors) {
                                $.each(xhr.responseJSON.errors, function(key, value) {
                                    const input = $(`[name="${key}"]`);
                                    input.after(
                                        `<label class="error serverside_error">${value[0]}</label>`
                                    );
                                });
                            }
                        }
                    });
                }
            });
        });
    </script>
@endpush
