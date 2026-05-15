@extends('Template::layouts.master')
@section('content')
    <div class="row">
        <div class="col-12">
            <form class="user-profile-form" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card card--lg custom--card">
                    <div class="profile-settings-wrapper">
                        <div class="preview-thumb profile-wallpaper">
                            <div class="avatar-preview">
                                <div class="profilePicPreview bg_img"
                                    data-background="{{ getImage(getFilePath('userBgImage') . '/' . @$user->bg_image, null, true) }}"
                                    style="background-image: url('{{ getImage(getFilePath('userBgImage') . '/' . @$user->bg_image, null, true) }}');">
                                </div>
                            </div>
                            <div class="avatar-edit">
                                <input class="profilePicUpload" id="profilePicUpload1" name="bg_image" type="file"
                                    accept=".png, .jpg, .jpeg">
                                <label for="profilePicUpload1" class="update-btn" data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="Supported Files: .png, .jpg, .jpeg. Image will be resized into {{ getFileSize('userBgImage') }}">
                                    <i class="las la-cloud-upload-alt me-1"></i> @lang('Update')
                                </label>
                            </div>
                        </div>
                        <div class="profile-thumb-content">
                            <div class="preview-thumb profile-thumb">
                                <div class="avatar-preview">
                                    <div class="profilePicPreview bg_img"
                                        data-background="{{ getImage(getFilePath('userProfile') . '/' . @$user->image, isAvatar: true) }}"
                                        style="background-image: url('{{ getImage(getFilePath('userProfile') . '/' . @$user->image, isAvatar: true) }}');">
                                    </div>
                                </div>
                                <div class="avatar-edit">
                                    <input class="profilePicUpload" id="profilePicUpload2" name="image" type="file"
                                        accept=".png, .jpg, .jpeg">
                                    <label for="profilePicUpload2" class="edit-btn" data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        title="@lang('Supported Files'): @lang('.png, .jpg, .jpeg'). @lang('Image will be resized into') {{ getFileSize('userProfile') }}"><i
                                            class="las la-pen"></i></label>
                                </div>
                            </div>
                            <div class="profile-content">
                                <h6 class="username">{{ $user->username }}</h6>
                                <ul class="user-info-list mt-md-3">
                                    <li><i class="las la-envelope text--base"></i> {{ $user->email }}</li>
                                    <li><i class="las la-phone text--base"></i> {{ $user->mobile }}</li>
                                    <li><i class="las la-map-marked-alt text--base"></i> {{ __(@$user->country_name) }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="px-5 pt-3 pb-5">
                        <!-- Basic Information -->
                        <div class="form--group-lg mt-4">
                            <div class="row align-items-start">
                                <div class="col-lg-3">
                                    <label class="form-label form--label required">@lang('First Name')</label>
                                </div>
                                <div class="col-lg-9">
                                    <input class="form-control form--control" name="firstname" type="text"
                                        value="{{ __($user->firstname) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="form--group-lg">
                            <div class="row align-items-start">
                                <div class="col-lg-3">
                                    <label class="form-label form--label required">@lang('Last Name')</label>
                                </div>
                                <div class="col-lg-9">
                                    <input class="form-control form--control" name="lastname" type="text"
                                        value="{{ __($user->lastname) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="form--group-lg">
                            <div class="row align-items-start">
                                <div class="col-lg-3">
                                    <label class="form-label form--label required">@lang('Designation')</label>
                                </div>
                                <div class="col-lg-9">
                                    <input class="form-control form--control" name="designation" type="text"
                                        value="{{ __(@$user->designation) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="form--group-lg">
                            <div class="row align-items-start">
                                <div class="col-lg-3">
                                    <label class="form-label form--label">@lang('Address')</label>
                                </div>
                                <div class="col-lg-9">
                                    <input class="form-control form--control" name="address" type="text"
                                        value="{{ __(@$user->address) }}">
                                </div>
                            </div>
                        </div>

                        <div class="form--group-lg">
                            <div class="row align-items-start">
                                <div class="col-lg-3">
                                    <label class="form-label form--label">@lang('State')</label>
                                </div>
                                <div class="col-lg-9">
                                    <input class="form-control form--control" name="state" type="text"
                                        value="{{ __(@$user->state) }}">
                                </div>
                            </div>
                        </div>

                        <div class="form--group-lg">
                            <div class="row align-items-start">
                                <div class="col-lg-3">
                                    <label class="form-label form--label">@lang('Zip Code')</label>
                                </div>
                                <div class="col-lg-9">
                                    <input class="form-control form--control" name="zip" type="text"
                                        value="{{ __(@$user->zip) }}">
                                </div>
                            </div>
                        </div>

                        <div class="form--group-lg">
                            <div class="row align-items-start">
                                <div class="col-lg-3">
                                    <label class="form-label form--label">@lang('City')</label>
                                </div>
                                <div class="col-lg-9">
                                    <input class="form-control form--control" name="city" type="text"
                                        value="{{ __(@$user->city) }}">
                                </div>
                            </div>
                        </div>

                        <div class="form--group-lg">
                            <div class="row align-items-start">
                                <div class="col-lg-3">
                                    <label class="form-label form--label required">@lang('About Me')</label>
                                </div>
                                <div class="col-lg-9">
                                    <textarea class="form-control form--control" name="about_me" rows="5" required>{{ __(@$user->about_me) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="form--group-lg text-end mt-4">
                            <button class="btn btn--base btn--lg" type="submit">@lang('Update Profile')</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        "use strict";

        function proPicURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var preview = $(input).parents('.preview-thumb').find('.profilePicPreview');
                    $(preview).css('background-image', 'url(' + e.target.result + ')');
                    $(preview).addClass('has-image');
                    $(preview).hide();
                    $(preview).fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $(".profilePicUpload").on('change', function() {
            proPicURL(this);
        });

        $(".remove-image").on('click', function() {
            $(".profilePicPreview").css('background-image', 'none');
            $(".profilePicPreview").removeClass('has-image');
        });
    </script>
@endpush
