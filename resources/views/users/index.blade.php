@extends('layouts.app', ['activePage' => 'user-management', 'titlePage' => __('messages.user_management')])

@section('content')
  <div class="content">
    
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header card-header-primary">
                <h4 class="card-title ">{{ __('messages.users') }}</h4>
                <p class="card-category"> {{ __('messages.users_detail') }}</p>
              </div>
              <div class="card-body">
                @if (session('status'))
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <i class="material-icons">close</i>
                        </button>
                        <span>{{ session('status') }}</span>
                      </div>
                    </div>
                  </div>
                @endif
                <div class="row">
                  <div class="col-12 text-right">
                    <a href="{{ route('user.create') }}" class="btn btn-sm btn-primary">{{ __('messages.add_user') }}</a>
                  </div>
                </div>
                <div class="table-responsive">
                  <table  class="table table-striped table-hover" cellspacing="0" width="100%" id="user-table">
                    <thead class=" text-primary">
                      <th>
                        {{ __('messages.avatar') }}
                      </th>
                      <th>
                          {{ __('messages.name') }}
                      </th>
                      <th>
                        {{ __('messages.email') }}
                      </th>
                      <th>
                        {{ __('messages.create_date') }}
                      </th>
                      <th>
                        {{ __('messages.status') }}
                      </th>
                      <th class="text-center">
                        {{ __('messages.action') }}
                      </th>
                    </thead>
                    <tbody>
                      @foreach($users as $user)
                        <tr>
                          <td class="text-center">
                            <img src="{{ $user->avatar}}" class="avatar-account"> 
                          </td>
                          <td>
                            {{ $user->name }}
                          </td>
                          <td>
                            {{ $user->email }}
                          </td>
                          <td>
                            {{ $user->created_at->format('Y-m-d') }}
                          </td>
                          <td id="state-{{ $user->id }}">
                            {{ $user->active ? __('messages.active') : __('messages.deactive') }}
                          </td>
                          <td class="td-actions text-center">
                          @if (!$user->admin)
                              <form action="{{ route('user.destroy', $user) }}" method="post">
                                  @csrf
                                  @method('delete')
                                  <a rel="tooltip" class="btn btn-success btn-link" href="{{ route('user.edit', $user) }}" data-original-title="{{ __('messages.edit') }}" title="{{ __('messages.edit') }}">
                                    <i class="material-icons">edit</i>
                                  </a>
                                  <a rel="tooltip" class="btn btn-success btn-link" href="#" data-original-title="{{ __('messages.activate_deactive') }}" title="{{ __('messages.activate_deactive') }}" style="padding-top: 10px">
                                    <input type="checkbox" onclick="activateUser({{ $user->id }}, this.checked)" {{ $user->active ?  "checked" : "" }} style="cursor: pointer">
                                  </a>
                              </form>
                          @endif
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
        </div>
      </div>
    
  </div>
@endsection

@push('js')

<script type="text/javascript">

  const ACTIVE = "{{ __('messages.active') }} ";
  const DEACTIVE = "{{ __('messages.deactive') }}";

  $(document).ready(function() {
    $('#user-table').DataTable();
  });
  
  function activateUser(id, active) {
    $.ajax({
      type: "GET",
      url: "/user/activate/",
      data: {
        "id": id,
        "active": active ? 1 : 0
      },
      success: function () {
        if (active)
          $("#state-" + id).html(ACTIVE);
        else
          $("#state-" + id).html(DEACTIVE);
      },
      error: function (data) {
          console.log('Error:', data);
      }
    });
  }
</script>
@endpush