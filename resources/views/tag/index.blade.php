@extends('layouts.app', ['activePage' => 'tag-management', 'titlePage' => __('messages.tag_management')])

@section('content')
  <div class="content">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header card-header-primary">
                <h4 class="card-title ">{{ __('messages.tags') }}</h4>
                <p class="card-category"> {{ __('messages.tags_detail') }}</p>
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
                <form method="post" method="post" action="{{ route('tag.store') }}" autocomplete="off" class="form-horizontal">
                  @csrf
                  @method('post')
                  <div class="row">
                    <div class="col-5 offset-2">
                      <input name="tag" class="form-control" placeholder="{{ __('messages.tag') }}" value="{{ old('tag') }}"  required>
                    </div>
                    <div class="col-3">
                      <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                  </div>
                </form>

                <div class="table-responsive">
                  <table  class="table table-striped table-hover" cellspacing="0" width="100%" id="tag-table">
                    <thead class=" text-primary">
                      <th>
                        {{ __('messages.tag') }}
                      </th>
                      <th class="text-center">
                        {{ __('messages.action') }}
                      </th>
                    </thead>
                    <tbody>
                      @foreach($tags as $tag)
                        <tr>
                          <td class="text-center"  onclick="showUpdateDlg({{ $tag->id}}, '{{ $tag->tag }}')" style="cursor: pointer">
                            {{ $tag->tag }}
                          </td>
                          <td class="td-actions text-center">
                            <form action="{{ route('tag.destroy', $tag) }}" method="post">
                                @csrf
                                @method('delete')
                                <button type="button" class="btn btn-danger btn-link" data-original-title="{{ __('messages.delete') }}" title="{{ __('messages.delete') }}" onclick="confirm('{{ __('messages.delete_tag_detail') }}') ? this.parentElement.submit() : ''">
                                    <i class="material-icons">close</i>
                                    <div class="ripple-container"></div>
                                </button>
                            </form>
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

<div class="modal" tabindex="-1" role="dialog" id="update-dlg">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">{{ __('messages.tag_edit') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" method="post" id="tag-update-form" autocomplete="off" class="form-horizontal">
          @csrf
          @method('put')
          <div class="row">
            <div class="col-5 offset-2">
              <input id="tag-tag" name="tag" class="form-control" placeholder="{{ __('messages.tag') }}" required>
            </div>
            <div class="col-3">
              <button type="submit" class="btn btn-primary">Save</button>
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
    $('#tag-table').DataTable();
  });

  function showUpdateDlg(id, tag) {
    $("#tag-update-form").attr("action", "/tag/" + id);
    $("#tag-tag").val(tag);
    $("#update-dlg").modal("show");
  }
</script>
@endpush