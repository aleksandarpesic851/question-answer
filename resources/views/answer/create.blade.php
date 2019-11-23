@extends('layouts.app', ['activePage' => 'question-management', 'titlePage' => __('messages.add_answer')])

@section('content')
  <div class="content">
      <div class="row">
        <div class="col-md-12">
<!-- Question -->
          <div class="card">

            <div class="card-header card-header-primary">
              <h5 class="card-title ">{{ __('messages.question') }}</h5>
            </div>

            <div class="card-body">
              <div class="row" style="margin: 0px; padding: 10px;">
                @if($question->type == "text")
                  <span id="question-content" style="width: 100%">{{ $question->content }}</span>
                @else
                  <img id="question-img" style="width: 100%;" src="{{ $question->image }}">
                @endif
              </div>
              <div class="row">
                <div class="col-xs-12 col-md-6" id="question-tags">
                  @foreach($question->tag_name as $tag)
                    <button type="button" class="btn tag">{{ $tag }}</button>
                  @endforeach
                </div>

                <div class="col-xs-6 col-md-3">
                  <span id="question-created-at">{{ __('messages.created_at') }} &nbsp {{ $question->created_at }}</span>
                </div>
                <div class="col-xs-6 col-md-3">
                  <img id="question-avatar" class="avatar-account" src="{{ $question->user_avatar }}">
                  <span id="question-user">{{ $question->user_name }}</span>
                </div>
              </div>
            </div>

          </div>
<!-- Answer -->
          <div class="card">

            <div class="card-header card-header-primary">
              <h5 class="card-title ">{{ __('messages.question') }}</h5>
            </div>

            <div class="card-body">
              <form method="post" enctype="multipart/form-data" id="answer-form">
                @csrf
                <input type="hidden" name="question_id" value="{{ $question->id }}">
                <div class="row" style="background: rgb(245, 245, 245); padding: 10px">
                  <div class="form-check col-6 text-center">
                    <label class="form-check-label">
                      <input class="form-check-input" type="radio" value="text" checked name="type" id="type-text" onclick="changeType()">
                      <span class="form-check-sign">
                        <span class="check"></span>
                      </span>
                      Text
                    </label>
                  </div>

                  <div class="form-check col-6 text-center">
                    <label class="form-check-label">
                      <input class="form-check-input" type="radio" value="image" name="type" id="type-image" onclick="changeType()">
                      <span class="form-check-sign">
                        <span class="check"></span>
                      </span>
                      Image
                    </label>
                  </div>
                </div>
                <textarea class="form-control" id="answer-content" name="content" rows="15" placeholder="{{ __('messages.type_answer') }}"></textarea>
                <div class="row text-center" style="align-items: center; display: none" id="answer-image-div">
                  <img class="content-image" id="answer_image" src="/images/upload.png" title="Upload Answer Image">
                  <input id="image" type="file" name="image" style="display: none" onchange="updateImage(this)">
                </div>
                <br>
                <div class="row">
                  <div class="col-11 text-right">
                    <button class="btn btn-primary"> {{ __('messages.save') }} </button>
                  </div>
                </div>
              </form>
            </div>

          </div>

        </div>
      </div>
  </div>
@endsection

@push('js')

<script type="text/javascript">

  $(document).ready(function() {
    $('#answer_image').click(function() {
      $('#image').click();
    });
    changeType();
  });

  function changeType() {
      if ($("#type-text").is(':checked')) {
        $("#answer-content").show();
        $("#answer-image-div").hide();
      } else {
        $("#answer-content").hide();
        $("#answer-image-div").show();
      }
  }

  function updateImage(input) {
    const answerImage = document.getElementById('answer_image');
    const file = input.files[0];
    answerImage.src = createObjectURL(file);
    answerImage.onload = function() {
          window.URL.revokeObjectURL(this.src);
      }
  }

  function createObjectURL(object) {
    return (window.URL) ? window.URL.createObjectURL(object) : window.webkitURL.createObjectURL(object);
  }

  $("#answer-form").submit( function(e) {
    e.preventDefault();
    if ($("#type-text").is(':checked')) {
      if (!$("#answer-content").val()) {
        alert("Please type answer");
        return;
      } 
    } else {
      if (!$("#image").val()) {
        alert("Please add image");
        return;
      }
    }
    $.ajax({
      type: "POST",
      url: "/answer/create",
      data: new FormData(this),
      success: function(response)
      {
          if (response && response.isSuccess) {
            alert("Your answer saved successfully.");
            history.back();
            return;
          }
          alert(response.message);
      },
      cache: false,
      contentType: false,
      processData: false
    });
  });
</script>
@endpush