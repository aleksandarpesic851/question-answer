<div class="sidebar" data-color="orange" data-background-color="white" data-image="{{ asset('material') }}/img/sidebar-1.jpg">
  <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
  <div class="logo">
    <a href="/" class="simple-text logo-normal">
      <div style="text-align: center; width: 100%">
        <img src="{{ asset('material') }}/img/logo.png" width="100px" height="100px" style="border-radius: 50px">
      </div>
      <div style="text-align: center; width: 100%">
        Q&A Platform
      </div>
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
          <i class="material-icons">dashboard</i>
            <p>{{ __('Dashboard') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'profile' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('profile.edit') }}">
          <i class="material-icons">person</i>
          <span class="sidebar-normal">{{ __('My profile') }} </span>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'user-management' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('user.index') }}">
          <i class="material-icons">people</i>
          <span class="sidebar-normal"> {{ __('User Management') }} </span>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'tag-management' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('tag.index') }}">
          <i class="material-icons">code</i>
          <span class="sidebar-normal"> {{ __('messages.tag_management') }} </span>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'question-management' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('question.index') }}">
          <i class="material-icons">help_outline</i>
          <span class="sidebar-normal"> {{ __('messages.question_management') }} </span>
        </a>
      </li>
    </ul>
  </div>
</div>