@extends('layouts.app', ['activePage' => 'user-management', 'titlePage' => __('messages.user_management')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form enctype="multipart/form-data" method="post" action="{{ route('user.store') }}" autocomplete="off" class="form-horizontal">
            @csrf
            @method('post')

            <div class="card ">
              <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('messages.add_user') }}</h4>
                <p class="card-category"></p>
              </div>
              <div class="card-body ">
                <div class="row">
                  <div class="col-md-12 text-right">
                      <a href="{{ route('user.index') }}" class="btn btn-sm btn-primary">{{ __('messages.back_list') }}</a>
                  </div>
                </div>
                
                <div class="row">

                  <div class="col-12 col-md-4">
                    <div class="row " style=" min-height: 100%; align-items: center;">
                      <img class="avatar-image" id="avatar_image" src="/uploads/avatars/user.png">
                    </div>
                    <input id="avatar" type="file" name="avatar" style="display: none" onchange="updateAvatarImage(this)">
                  </div>

                  <div class="col-12 col-md-8">

                    <div class="row">
                      <label class="col-4 col-sm-3 col-md-3 col-form-label">{{ __('messages.name') }}</label>
                      <div class="col-8 col-sm-9 col-md-7">
                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                          <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="input-name" type="text" placeholder="{{ __('messages.name') }}" value="{{ old('name') }}" required="true" aria-required="true"/>
                          @if ($errors->has('name'))
                            <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('name') }}</span>
                          @endif
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-sm-3 col-md-3 col-form-label">{{ __('messages.email') }}</label>
                      <div class="col-8 col-sm-9 col-md-7">
                        <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}"  data-toggle="tooltip" title="{{ __('messages.email_tooltip') }}">
                          <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" id="input-email" type="email" placeholder="{{ __('messages.email') }}" value="{{ old('email') }}" required />
                          @if ($errors->has('email'))
                            <span id="email-error" class="error text-danger" for="input-email">{{ $errors->first('email') }}</span>
                          @endif
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-sm-3 col-md-3 col-form-label">{{ __('messages.phone') }}</label>
                      <div class="col-8 col-sm-9 col-md-7">
                        <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
                          <input class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" id="input-phone" type="text" placeholder="{{ __('messages.phone') }}" value="{{ old('phone') }}" required />
                          @if ($errors->has('phone'))
                            <span id="phone-error" class="error text-danger" for="input-phone">{{ $errors->first('phone') }}</span>
                          @endif
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-sm-3 col-md-3 col-form-label" for="input-password">{{ __('messages.password') }}</label>
                      <div class="col-8 col-sm-9 col-md-7">
                        <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                          <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" input type="password" name="password" id="input-password" placeholder="{{ __('messages.password') }}" value="" required />
                          @if ($errors->has('password'))
                            <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('password') }}</span>
                          @endif
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-sm-3 col-md-3 col-form-label" for="input-password-confirmation">{{ __('messages.confirm_password') }}</label>
                      <div class="col-8 col-sm-9 col-md-7">
                        <div class="form-group">
                          <input class="form-control" name="password_confirmation" id="input-password-confirmation" type="password" placeholder="{{ __('messages.confirm_password') }}" value="" required />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="card-footer ml-auto mr-auto">
                <button type="submit" class="btn btn-primary">{{ __('messages.add_user') }}</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('js')
<script type="text/javascript">
    $(document).ready(function() {
      $('#avatar_image').click(function() {
        $('#avatar').click();
      });
    });

    function createObjectURL(object) {
      return (window.URL) ? window.URL.createObjectURL(object) : window.webkitURL.createObjectURL(object);
    }

    function updateAvatarImage(input) {
      const avatarImage = document.getElementById('avatar_image');
      const file = input.files[0];
      avatarImage.src = createObjectURL(file);
      avatarImage.onload = function() {
            window.URL.revokeObjectURL(this.src);
        }

    }
</script>
@endpush