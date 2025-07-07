@extends('layout.master')

@section('title', __('MyAce | Add Banner'))

@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>New Banner</h4>
                        <h6>Create new banner</h6>
                    </div>
                </div>
                <ul class="table-top-head">
                    <li>
                        <div class="page-btn">
                            <a href="{{ route('admin.banner') }}" class="btn btn-secondary">
                                <i data-feather="arrow-left" class="me-2"></i>Back to Banners
                            </a>
                        </div>
                    </li>
                    <li>
                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header">
                            <i data-feather="chevron-up" class="feather-chevron-up"></i>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Form Start -->
            <form name="add_banner" id="add_banner" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body add-product pb-0">
                        <div class="accordion-card-one accordion" id="accordionExample">
                            <div class="accordion-item">
                                <div class="accordion-header" id="headingOne">
                                    <div class="accordion-button" aria-controls="collapseOne">
                                        <div class="addproduct-icon">
                                            <h5>
                                                <i data-feather="info" class="add-info"></i><span>Banner Information</span>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-lg-6 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Type</label>
                                                    <select class="select form-control" id="banner_type" name="banner_type">
                                                        <option value="">Select Type</option>
                                                        <option value="banner">Banner Image</option>
                                                        <option value="benefit">Benefit Image</option>
                                                        <option value="video">Video</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Redirect URL</label>
                                                    <input type="text" class="form-control" name="redirect_url"
                                                        id="redirect_url" />
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Banner Image Section -->
                                        <div class="row banner_img" style="display:none;">
                                            <div class="col-lg-6 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Banner Image</label>
                                                    <input type="file" class="form-control" name="banner_img"
                                                        id="banner_img" onchange="previewImage(this, 'banner_img_canv1')">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <canvas id="banner_img_canv1" class="imgcanvas"
                                                        style="display:none; width: 200px; height: 150px; border: 1px solid #ccc;"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Video  Image Section -->
                                        <div class="row video" style="display:none;">
                                            <div class="col-lg-6 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Video</label>
                                                    <input type="file" class="form-control" name="video" id="video"
                                                        onchange="previewImage(this, 'video_canv1')">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <canvas id="video_canv1" class="imgcanvas"
                                                        style="display:none; width: 200px; height: 150px; border: 1px solid #ccc;"></canvas>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Benefit Image Section -->
                                        <div class="row benfit_img" style="display:none;">
                                            <div class="col-lg-6 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Product Image</label>
                                                    <input type="file" class="form-control" name="product_img"
                                                        id="product_img" onchange="previewImage(this, 'product_img_canv1')">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Product Benefit Image</label>
                                                    <input type="file" class="form-control" name="product_ben_img"
                                                        id="product_ben_img"
                                                        onchange="previewImage(this, 'product_ben_img_canv')">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <canvas id="product_img_canv1" class="imgcanvas"
                                                        style="display:none; width: 200px; height: 150px; border: 1px solid #ccc;"></canvas>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <canvas id="product_ben_img_canv" class="imgcanvas"
                                                        style="display:none; width: 200px; height: 150px; border: 1px solid #ccc;"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="alert alert-success success_msg" role="alert"></div>
                <div class="alert alert-danger error_msg" role="alert"></div>
                <!-- Buttons -->
                <div class="col-lg-12">
                    <div class="btn-addproduct mb-4">
                        <button type="button" class="btn btn-cancel me-2">Cancel</button>
                        <button type="submit" class="btn btn-submit">Save Product</button>
                    </div>
                </div>
            </form>
            <!-- /Form End -->
        </div>
    </div>
@endsection

@push('custom-script')
    <script>
        $(document).ready(function() {
            function resetBannerImage() {
                $('#banner_img').val('');
                clearCanvas('banner_img_canv1');
            }

            function resetBenefitImage() {
                $('#product_img').val('');
                $('#product_ben_img').val('');
                clearCanvas('product_img_canv1');
                clearCanvas('product_ben_img_canv');
            }

            function resetVideo() {
                $('#video').val('');
                clearCanvas('video_canv1');
            }

            function clearCanvas(canvasId) {
                const canvas = document.getElementById(canvasId);
                const ctx = canvas.getContext('2d');
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                canvas.style.display = 'none';
            }

            // Type change logic
            $('#banner_type').on('change', function() {
                const selectedType = $(this).val();

                resetBannerImage();
                resetBenefitImage();
                resetVideo();

                $('.banner_img, .benfit_img, .video').hide(); // Hide all first

                if (selectedType === 'banner') {
                    $('.banner_img').show();
                } else if (selectedType === 'benefit') {
                    $('.benfit_img').show();
                } else if (selectedType === 'video') {
                    $('.video').show();
                }
            });

            // Image Preview
            window.previewImage = function(input, canvasId) {
                const file = input.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const canvas = document.getElementById(canvasId);
                        const ctx = canvas.getContext('2d');
                        const img = new Image();
                        img.onload = function() {
                            const canvasWidth = canvas.width = 200;
                            const canvasHeight = canvas.height = 150;
                            ctx.clearRect(0, 0, canvasWidth, canvasHeight);
                            const scale = Math.min(canvasWidth / img.width, canvasHeight / img.height);
                            const x = (canvasWidth - img.width * scale) / 2;
                            const y = (canvasHeight - img.height * scale) / 2;
                            ctx.drawImage(img, 0, 0, img.width, img.height, x, y, img.width * scale, img
                                .height * scale);
                            canvas.style.display = 'inline-block';
                        };
                        img.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            };
            $("form[name='add_banner']").validate({
                rules: {
                    banner_type: {
                        required: true
                    },
                    redirect_url: {
                        required: function() {
                            return $('#banner_type').val() !==
                                'video';
                        },
                        url: true
                    },
                    banner_img: {
                        required: function() {
                            return $('#banner_type').val() === 'banner';
                        }
                    },
                    product_img: {
                        required: function() {
                            return $('#banner_type').val() === 'benefit';
                        }
                    },
                    product_ben_img: {
                        required: function() {
                            return $('#banner_type').val() === 'benefit';
                        }
                    },
                    video: {
                        required: function() {
                            return $('#banner_type').val() === 'video';
                        }
                    },
                },
                messages: {
                    banner_type: {
                        required: 'Select type'
                    },
                    redirect_url: {
                        required: 'Enter redirect URL',
                        url: 'Enter a valid URL (e.g., https://example.com)'
                    },
                    banner_img: {
                        required: 'Select banner image'
                    },
                    product_img: {
                        required: 'Select product image'
                    },
                    product_ben_img: {
                        required: 'Select product benefit image'
                    },
                    video: {
                        required: 'Select video'
                    }
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: "{{ route('admin.banner.insert') }}",
                        type: "POST",
                        data: new FormData(form),
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (response.status == 'success') {
                                $("form[name='add_banner']").find('.serverside_error')
                                    .remove();
                                $('.success_msg').html(response.msg).fadeIn();

                                setTimeout(function() {
                                    $('.success_msg').fadeOut();
                                }, 5000);
                                $("form[name='add_banner']")[0].reset();
                                $("form[name='add_banner']")[0].reset();
                                $('.banner_img, .benfit_img, .video').hide();
                                resetBannerImage();
                                resetBenefitImage();
                                resetVideo();
                            } else {
                                $("form[name='add_banner']").find('.serverside_error')
                                    .remove();
                                $('.error_msg').html(response.msg).fadeIn();

                                setTimeout(function() {
                                    $('.error_msg').fadeOut();
                                }, 5000);
                            }
                        },
                        error: function(xhr) {
                            handleServerError('add_banner', xhr.responseJSON.errors);
                        }
                    });
                }
            });
        });
    </script>
@endpush
