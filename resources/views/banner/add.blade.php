@extends('layout.master')

@section('title', __('MyAce | Add Banner'))

@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>{{ isset($bannerData) ? 'Edit' : 'Add' }} Banner</h4>
                        <h6>{{ isset($bannerData) ? 'Update banner details' : 'Create new banner' }}</h6>
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
                @if (isset($bannerData))
                    <input type="hidden" name="banner_id" value="{{ $bannerData->id }}">
                @endif
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
                                                    @if (isset($bannerData))
                                                        <input type="text" class="form-control"
                                                            value="{{ ucfirst($bannerData->type) }}" readonly>
                                                        <input type="hidden" name="banner_type"
                                                            value="{{ $bannerData->type }}">
                                                    @else
                                                        <select class="select form-control" id="banner_type"
                                                            name="banner_type">
                                                            <option value="">Select Type</option>
                                                            <option value="banner"
                                                                {{ isset($bannerData) && $bannerData->type == 'banner' ? 'selected' : '' }}>
                                                                Banner Image</option>
                                                            <option value="benefit"
                                                                {{ isset($bannerData) && $bannerData->type == 'benefit' ? 'selected' : '' }}>
                                                                Benefit Image</option>
                                                            <option value="video"
                                                                {{ isset($bannerData) && $bannerData->type == 'video' ? 'selected' : '' }}>
                                                                Video</option>
                                                        </select>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Redirect URL</label>
                                                    <input type="text" class="form-control" name="redirect_url"
                                                        id="redirect_url" value="{{ $bannerData->redirect_url ?? '' }}" />
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Banner Image Section -->
                                        <div class="row banner_img"
                                            style="display:{{ isset($bannerData) && $bannerData->type == 'banner' ? 'flex' : 'none' }};">
                                            <div class="col-lg-6 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Banner Image</label>
                                                    <input type="file" class="form-control" name="banner_img"
                                                        id="banner_img" accept="image/*"
                                                        onchange="previewImage(this, 'banner_img_canv1')">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <canvas id="banner_img_canv1" class="imgcanvas"
                                                        style="width: 200px; height: 150px; border: 1px solid #ccc; {{ isset($bannerData) && $bannerData->type == 'banner' && $bannerData->banner_img ? '' : 'display:none;' }}"></canvas>
                                                    <div class="remove-image-wrapper" data-type="banner_img"
                                                        style="display:none;">
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm mt-2 remove-image"
                                                            data-type="banner_img">Remove Image</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Video Section -->
                                        <div class="row video"
                                            style="display:{{ isset($bannerData) && $bannerData->type == 'video' ? 'flex' : 'none' }};">
                                            <div class="col-lg-6 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Video</label>
                                                    <input type="file" class="form-control" name="video" id="video"
                                                        accept="video/*" onchange="previewVideo(this, 'video_canv1')">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <canvas id="video_canv1" class="imgcanvas"
                                                        style="width: 200px; height: 150px; border: 1px solid #ccc; {{ isset($bannerData) && $bannerData->type == 'video' && $bannerData->video ? '' : 'display:none;' }}"></canvas>
                                                    <div class="remove-image-wrapper" data-type="video"
                                                        style="display:none;">
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm mt-2 remove-image"
                                                            data-type="video">Remove Video</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Benefit Image Section -->
                                        <div class="row benefit_img"
                                            style="display:{{ isset($bannerData) && $bannerData->type == 'benefit' ? 'flex' : 'none' }};">
                                            <div class="col-lg-6 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Product Image</label>
                                                    <input type="file" class="form-control" name="product_img"
                                                        id="product_img" accept="image/*"
                                                        onchange="previewImage(this, 'product_img_canv1')">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Product Benefit Image</label>
                                                    <input type="file" class="form-control" name="product_ben_img"
                                                        id="product_ben_img" accept="image/*"
                                                        onchange="previewImage(this, 'product_ben_img_canv')">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <canvas id="product_img_canv1" class="imgcanvas"
                                                        style="width: 200px; height: 150px; border: 1px solid #ccc; {{ isset($bannerData) && $bannerData->type == 'benefit' && $bannerData->product_img ? '' : 'display:none;' }}"></canvas>
                                                    <div class="remove-image-wrapper" data-type="product_img"
                                                        style="display:none;">
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm mt-2 remove-image"
                                                            data-type="product_img">Remove Image</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <canvas id="product_ben_img_canv" class="imgcanvas"
                                                        style="width: 200px; height: 150px; border: 1px solid #ccc; {{ isset($bannerData) && $bannerData->type == 'benefit' && $bannerData->product_ben_img ? '' : 'display:none;' }}"></canvas>
                                                    <div class="remove-image-wrapper" data-type="product_ben_img"
                                                        style="display:none;">
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm mt-2 remove-image"
                                                            data-type="product_ben_img">Remove Image</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="alert alert-success success_msg" role="alert" style="display:none;"></div>
                <div class="alert alert-danger error_msg" role="alert" style="display:none;"></div>
                <!-- Buttons -->
                <div class="col-lg-12">
                    <div class="btn-addproduct mb-4">
                        <button type="button" class="btn btn-cancel me-2">Cancel</button>
                        <button type="submit" class="btn btn-submit">{{ isset($bannerData) ? 'Update' : 'Save' }}
                            Banner</button>
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
            // Initialize visibility and load existing images/videos
            const selectedType = $('#banner_type').val() || '{{ $bannerData->type ?? '' }}';
            if (selectedType === 'banner') {
                $('.banner_img').show();
                @if (isset($bannerData) && $bannerData->type == 'banner' && $bannerData->banner_img)
                    loadExistingImage('{{ asset('storage/' . $bannerData->banner_img) }}', 'banner_img_canv1');
                @endif
            } else if (selectedType === 'video') {
                $('.video').show();
                @if (isset($bannerData) && $bannerData->type == 'video' && $bannerData->video)
                    loadExistingVideo('{{ asset('storage/' . $bannerData->video) }}', 'video_canv1');
                @endif
            } else if (selectedType === 'benefit') {
                $('.benefit_img').show();
                @if (isset($bannerData) && $bannerData->type == 'benefit' && $bannerData->product_img)
                    loadExistingImage('{{ asset('storage/' . $bannerData->product_img) }}', 'product_img_canv1');
                @endif
                @if (isset($bannerData) && $bannerData->type == 'benefit' && $bannerData->product_ben_img)
                    loadExistingImage('{{ asset('storage/' . $bannerData->product_ben_img) }}',
                        'product_ben_img_canv');
                @endif
            }

            // Disable banner_type in edit mode
            @if (isset($bannerData))
                $('#banner_type').prop('disabled', true);
            @endif

            // Reset functions
            function resetBannerImage() {
                $('#banner_img').val('');
                clearCanvas('banner_img_canv1');
                $('.remove-image-wrapper[data-type="banner_img"]').hide();
                $('input[name="remove_banner_img"]').remove();
                @if (isset($bannerData) && $bannerData->type == 'banner' && $bannerData->banner_img)
                    loadExistingImage('{{ asset('storage/' . $bannerData->banner_img) }}', 'banner_img_canv1');
                @endif
            }

            function resetBenefitImage() {
                $('#product_img').val('');
                $('#product_ben_img').val('');
                clearCanvas('product_img_canv1');
                clearCanvas('product_ben_img_canv');
                $('.remove-image-wrapper[data-type="product_img"]').hide();
                $('.remove-image-wrapper[data-type="product_ben_img"]').hide();
                $('input[name="remove_product_img"]').remove();
                $('input[name="remove_product_ben_img"]').remove();
                @if (isset($bannerData) && $bannerData->type == 'benefit' && $bannerData->product_img)
                    loadExistingImage('{{ asset('storage/' . $bannerData->product_img) }}', 'product_img_canv1');
                @endif
                @if (isset($bannerData) && $bannerData->type == 'benefit' && $bannerData->product_ben_img)
                    loadExistingImage('{{ asset('storage/' . $bannerData->product_ben_img) }}',
                        'product_ben_img_canv');
                @endif
            }

            function resetVideo() {
                $('#video').val('');
                clearCanvas('video_canv1');
                $('.remove-image-wrapper[data-type="video"]').hide();
                $('input[name="remove_video"]').remove();
                @if (isset($bannerData) && $bannerData->type == 'video' && $bannerData->video)
                    loadExistingVideo('{{ asset('storage/' . $bannerData->video) }}', 'video_canv1');
                @endif
            }

            function clearCanvas(canvasId) {
                const canvas = document.getElementById(canvasId);
                const ctx = canvas.getContext('2d');
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                canvas.style.display = 'none';
            }

            // Load existing image
            function loadExistingImage(url, canvasId) {
                const canvas = document.getElementById(canvasId);
                const ctx = canvas.getContext('2d');
                const img = new Image();
                img.crossOrigin = 'Anonymous';
                img.onload = function() {
                    const canvasWidth = canvas.width = 200;
                    const canvasHeight = canvas.height = 150;
                    ctx.clearRect(0, 0, canvasWidth, canvasHeight);
                    const scale = Math.min(canvasWidth / img.width, canvasHeight / img.height);
                    const x = (canvasWidth - img.width * scale) / 2;
                    const y = (canvasHeight - img.height * scale) / 2;
                    ctx.drawImage(img, x, y, img.width * scale, img.height * scale);
                    canvas.style.display = 'inline-block';
                };
                img.src = url;
            }

            // Load existing video
            function loadExistingVideo(url, canvasId) {
                const canvas = document.getElementById(canvasId);
                const ctx = canvas.getContext('2d');
                const video = document.createElement('video');
                video.src = url;
                video.crossOrigin = 'Anonymous';
                video.addEventListener('loadeddata', function() {
                    video.currentTime = 1;
                    video.addEventListener('seeked', function() {
                        const canvasWidth = canvas.width = 200;
                        const canvasHeight = canvas.height = 150;
                        ctx.clearRect(0, 0, canvasWidth, canvasHeight);
                        const scale = Math.min(canvasWidth / video.videoWidth, canvasHeight / video
                            .videoHeight);
                        const x = (canvasWidth - video.videoWidth * scale) / 2;
                        const y = (canvasHeight - video.videoHeight * scale) / 2;
                        ctx.drawImage(video, x, y, video.videoWidth * scale, video.videoHeight *
                            scale);
                        canvas.style.display = 'inline-block';
                    });
                });
            }

            // Type change logic (only for create mode)
            @if (!isset($bannerData))
                $('#banner_type').on('change', function() {
                    const selectedType = $(this).val();

                    resetBannerImage();
                    resetBenefitImage();
                    resetVideo();

                    $('.banner_img, .benefit_img, .video').hide();

                    if (selectedType === 'banner') {
                        $('.banner_img').show();
                    } else if (selectedType === 'benefit') {
                        $('.benefit_img').show();
                    } else if (selectedType === 'video') {
                        $('.video').show();
                    }
                });
            @endif

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
                            ctx.drawImage(img, x, y, img.width * scale, img.height * scale);
                            canvas.style.display = 'inline-block';
                            $(`.remove-image-wrapper[data-type="${input.name}"]`).show();
                            $(`input[name="remove_${input.name}"]`).remove();
                            // Mark existing image for removal
                            @if (isset($bannerData))
                                if (input.name === 'banner_img' &&
                                    '{{ $bannerData->banner_img ?? '' }}') {
                                    $(`#${input.name}`).after(
                                        `<input type="hidden" name="remove_${input.name}" value="1">`
                                    );
                                } else if (input.name === 'product_img' &&
                                    '{{ $bannerData->product_img ?? '' }}') {
                                    $(`#${input.name}`).after(
                                        `<input type="hidden" name="remove_${input.name}" value="1">`
                                    );
                                } else if (input.name === 'product_ben_img' &&
                                    '{{ $bannerData->product_ben_img ?? '' }}') {
                                    $(`#${input.name}`).after(
                                        `<input type="hidden" name="remove_${input.name}" value="1">`
                                    );
                                }
                            @endif
                        };
                        img.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            };

            // Video Preview
            window.previewVideo = function(input, canvasId) {
                const file = input.files[0];
                if (file) {
                    const video = document.createElement('video');
                    const canvas = document.getElementById(canvasId);
                    const ctx = canvas.getContext('2d');
                    video.src = URL.createObjectURL(file);
                    video.addEventListener('loadeddata', function() {
                        video.currentTime = 1;
                        video.addEventListener('seeked', function() {
                            const canvasWidth = canvas.width = 200;
                            const canvasHeight = canvas.height = 150;
                            ctx.clearRect(0, 0, canvasWidth, canvasHeight);
                            const scale = Math.min(canvasWidth / video.videoWidth,
                                canvasHeight / video.videoHeight);
                            const x = (canvasWidth - video.videoWidth * scale) / 2;
                            const y = (canvasHeight - video.videoHeight * scale) / 2;
                            ctx.drawImage(video, x, y, video.videoWidth * scale, video
                                .videoHeight * scale);
                            canvas.style.display = 'inline-block';
                            $(`.remove-image-wrapper[data-type="${input.name}"]`).show();
                            $(`input[name="remove_${input.name}"]`).remove();
                            // Mark existing video for removal
                            @if (isset($bannerData) && $bannerData->type == 'video' && $bannerData->video)
                                if (input.name === 'video' &&
                                    '{{ $bannerData->video ?? '' }}') {
                                    $(`#${input.name}`).after(
                                        `<input type="hidden" name="remove_${input.name}" value="1">`
                                    );
                                }
                            @endif
                            URL.revokeObjectURL(video.src);
                        });
                    });
                }
            };

            // Remove image/video
            $(document).on('click', '.remove-image', function() {
                const type = $(this).data('type');
                if (type === 'banner_img') {
                    resetBannerImage();
                } else if (type === 'video') {
                    resetVideo();
                } else if (type === 'product_img') {
                    $('#product_img').val('');
                    clearCanvas('product_img_canv1');
                    $('.remove-image-wrapper[data-type="product_img"]').hide();
                    $('input[name="remove_product_img"]').remove();
                    @if (isset($bannerData) && $bannerData->type == 'benefit' && $bannerData->product_img)
                        loadExistingImage('{{ asset('storage/' . $bannerData->product_img) }}',
                            'product_img_canv1');
                    @endif
                } else if (type === 'product_ben_img') {
                    $('#product_ben_img').val('');
                    clearCanvas('product_ben_img_canv');
                    $('.remove-image-wrapper[data-type="product_ben_img"]').hide();
                    $('input[name="remove_product_ben_img"]').remove();
                    @if (isset($bannerData) && $bannerData->type == 'benefit' && $bannerData->product_ben_img)
                        loadExistingImage('{{ asset('storage/' . $bannerData->product_ben_img) }}',
                            'product_ben_img_canv');
                    @endif
                }
            });

            // Form validation
            $("form[name='add_banner']").validate({
                rules: {
                    banner_type: {
                        required: true
                    },
                    redirect_url: {
                        required: function() {
                            return ($('#banner_type').val() || '{{ $bannerData->type ?? '' }}') !==
                                'video';
                        },
                        url: true
                    },
                    banner_img: {
                        required: function() {
                            return ($('#banner_type').val() || '{{ $bannerData->type ?? '' }}') ===
                                'banner' && !$('#banner_img').val() && !$(
                                    'input[name="remove_banner_img"]').length && !
                                '{{ $bannerData->banner_img ?? '' }}';
                        }
                    },
                    product_img: {
                        required: function() {
                            return ($('#banner_type').val() || '{{ $bannerData->type ?? '' }}') ===
                                'benefit' && !$('#product_img').val() && !$(
                                    'input[name="remove_product_img"]').length && !
                                '{{ $bannerData->product_img ?? '' }}';
                        }
                    },
                    product_ben_img: {
                        required: function() {
                            return ($('#banner_type').val() || '{{ $bannerData->type ?? '' }}') ===
                                'benefit' && !$('#product_ben_img').val() && !$(
                                    'input[name="remove_product_ben_img"]').length && !
                                '{{ $bannerData->product_ben_img ?? '' }}';
                        }
                    },
                    video: {
                        required: function() {
                            return ($('#banner_type').val() || '{{ $bannerData->type ?? '' }}') ===
                                'video' && !$('#video').val() && !$('input[name="remove_video"]')
                                .length && !'{{ $bannerData->video ?? '' }}';
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
                        url: "{{ isset($bannerData) ? route('admin.banner.update') : route('admin.banner.insert') }}",
                        type: "POST",
                        data: new FormData(form),
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (response.status == 'success') {
                                $('.serverside_error').remove();
                                $('.success_msg').html(response.msg).fadeIn();
                                setTimeout(function() {
                                    $('.success_msg').fadeOut();
                                }, 2000);
                                @if (!isset($bannerData))
                                    $("form[name='add_banner']")[0].reset();
                                    $('.banner_img, .benefit_img, .video').hide();
                                    resetBannerImage();
                                    resetBenefitImage();
                                    resetVideo();
                                @endif
                                // window.location.href =
                                //     "{{ route('admin.banner') }}";
                            } else {
                                $('.serverside_error').remove();
                                $('.error_msg').html(response.msg).fadeIn();
                                setTimeout(function() {
                                    $('.error_msg').fadeOut();
                                }, 5000);
                            }
                        },
                        error: function(xhr) {
                            $('.serverside_error').remove();
                            $('.error_msg').html(
                                    'An error occurred. Please try again.')
                                .fadeIn();
                            setTimeout(function() {
                                $('.error_msg').fadeOut();
                            }, 5000);
                        }
                    });
                }
            });
        });
    </script>
@endpush
