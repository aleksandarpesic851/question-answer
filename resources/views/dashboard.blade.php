@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-warning card-header-icon">
              <div class="card-icon">
                <i class="material-icons">people</i>
              </div>
              <p class="card-category">{{ __('messages.number_joined_user') }}</p>
              <h3 class="card-title">{{ $nUsers }}</h3>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-success card-header-icon">
              <div class="card-icon">
                <i class="material-icons">store</i>
              </div>
              <p class="card-category">{{ __('messages.number_post_question') }}</p>
              <h3 class="card-title">{{ $nQuestions }}</h3>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-info card-header-icon">
              <div class="card-icon">
                <i class="material-icons">help_outline</i>
              </div>
              <p class="card-category">{{ __('messages.number_answered_question') }}</p>
              <h3 class="card-title">{{ $nAnsweredQuestions }}</h3>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-danger card-header-icon">
              <div class="card-icon">
                <i class="material-icons">help_outline</i>
                <!-- <i class="fa fa-twitter"></i> -->
              </div>
              <p class="card-category">{{ __('messages.number_unanswered_question') }}</p>
              <h3 class="card-title">{{ $nUnAnsweredQuestions }}</h3>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header card-header-primary">
                <h4 class="card-title ">{{ __('messages.questions') }}</h4>
              </div>
              <div class="card-body">
                <div class="row" style="padding-left: 10px">
                  <div class="col-3">
                    <label for="filter-from-date">{{ __('messages.from_date') }}</label>
                    <input placeholder="{{ __('messages.from_date') }}" data-toggle="datepicker" id="filter-from-date" class="form-control" type="text" >
                  </div>
                  <div class="col-3">
                    <label for="filter-to-date">{{ __('messages.to_date') }}</label>
                    <input placeholder="{{ __('messages.to_date') }}" data-toggle="datepicker" id="filter-to-date" class="form-control" type="text" >
                  </div>
                  <div class="col-2">
                    <label for="filter-tag">{{ __('messages.tags') }}</label>
                    <select id="filter-tag" class="form-control">
                      <option value="0"> {{ __('messages.all') }}</option>
                      @foreach($tags as $tag)
                      <option value="{{ $tag->id }}"> {{ $tag->tag }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-2">
                    <label for="filter-tag">{{ __('messages.state') }}</label>
                    <select id="state" class="form-control">
                      <option value=""> {{ __('messages.all') }}</option>
                      <option value="open">Open</option>
                      <option value="search found">Search Found</option>
                      <option value="user answered">User Answered</option>
                      <option value="admin answered">Admin Answered</option>
                    </select>
                  </div>
                  <div class="col-2 text-center">
                    <br>
                    <button type="button" onclick="searchQuestion()" class="btn btn-primary"> <i class='material-icons'>search</i> Search</button>
                  </div>
                </div>

                <div class="table-responsive">
                  <table  class="table table-striped table-hover" cellspacing="0" width="100%" id="question-table">
                    <thead class=" text-primary">
                      <th>{{ __('messages.id') }}</th>
                      <th>{{ __('messages.no') }}</th>
                      <th>
                        {{ __('messages.question_posted_by') }}
                      </th>
                      <th>
                          {{ __('messages.create_date') }}
                      </th>
                      <th>
                        {{ __('messages.content') }}
                      </th>
                      <th>
                        {{ __('messages.follow') }}
                      </th>
                      <th>
                        {{ __('messages.type') }}
                      </th>
                      <th>
                        {{ __('messages.tag') }}
                      </th>
                      <th>
                        {{ __('messages.state') }}
                      </th>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  
<div class="modal fade" tabindex="-1" role="dialog" id="answer-dlg">
  <div class="modal-dialog modal-dialog-centered" role="document" style="margin-left: 10%; margin-right: 10%; max-width: 80%; width: 80%">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">{{ __('messages.answer') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="card">
          <div class="card-header card-header-primary">
            <h5 class="card-title ">{{ __('messages.question') }}</h5>
          </div>
          <div class="card-body">
            <div class="row" style="margin: 0px; padding: 10px">
              <span id="question-content" style="width: 100%"> </span>
              <img id="question-img" class="content-image">
            </div>
            <div class="row">
              <div class="col-xs-12 col-md-6" id="question-tags">
              </div>
              <div class="col-xs-6 col-md-3">
                <span id="question-created-at"> </span>
              </div>
              <div class="col-xs-6 col-md-3">
                <img id="question-avatar" class="avatar-account">
                <span id="question-user"></span>
              </div>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-header card-header-primary">
            <h5 class="card-title ">{{ __('messages.answers') }}</h5>
          </div>
          <div class="card-body" id="answer-contents">
          </div>
        </div>
      
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="add-answer">Add Answer</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@endsection

@push('js')
  <script>
    let questionTable;
    $(document).ready(function() {
      //Datatable initialize
      questionTable = $('#question-table').DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        rowId: "id",
        ajax: {
          url: "/home/datatable",
          type: 'GET',
          data: function(d) {
            d.tag = $("#filter-tag").val();
            d.fromDate = $("#filter-from-date").val();
            d.toDate = $("#filter-to-date").val();
            d.state = $("#state").val();
          }
        },
        columns: [
                { data: 'id', name: 'id', 'visible': false },
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false},
                { data: 'question_posted_by', name: 'question_posted_by', orderable: false,searchable: false},
                { data: 'created_at', name: 'created_at' },
                { data: 'content', name: 'content' },
                { data: 'follow_cnt', name: 'follow_cnt' },
                { data: 'type', name: 'type', orderable: false },
                { data: 'tag_name', name: 'tag_name', orderable: false,searchable: false },
                { data: 'state', name: 'state' }
              ],
        order: [[0, 'desc']]
      });

      //Datatable event
      $('#question-table').on('click', 'tr', function (event) {
        const id = questionTable.row(this).id();
        $.ajax({
              type: "GET",
              url: "/question/getquestion",
              data: {
                id: id
              },
              success: function (response) {
                if (response && response.isSuccess) {
                  initDialog(response.data);
                  $("#answer-dlg").modal("show");
                } else {
                  console.log("Error:", response);
                }
              },
              error: function (response) {
                  console.log('Error:', response);
              }
          });
        return false;
      });
  //DatePicker
      $('[data-toggle="datepicker"]').datepicker();
      
    });

    function searchQuestion() {
      questionTable.draw(false);
    }

    
    function initDialog(data) {
      let question = data.question;
      if (question.type === "text") {
        $("#question-img").hide();
        $("#question-content").show();
        $("#question-content").html(question.content);
      } else {
        $("#question-content").hide();
        $("#question-img").show();
        $("#question-img").attr("src", question.image);
      }
      
      let tags = "";
      question.tag_name.forEach((e, index) => {
        tags += "<button type='button' class='btn tag'>" + e + "</button>";
      });
      $("#question-tags").html(tags);

      $("#question-created-at").html("Created at " + question.created_at);
      $("#question-avatar").attr('src', question.user_avatar);
      $("#question-user").html(question.user_name);

      let answersHtml = "";
      let answers = data.answers;

      answers.forEach((e, index) => {
        answersHtml += "<div class='answer-div' id='answer-" + e.id + "'>";
        answersHtml += "<div class='row' style='margin: 0px; padding: 10px'>";
        if (e.type === "text") {
          answersHtml += "<span style='width: 100%'>" + e.content + "</span>";
        } else {
          answersHtml += "<img class='content-image' src='" + e.image + "'>";
        }
        answersHtml += "</div>";
        answersHtml += "<div class='row'>";
        answersHtml += "<div class='col-5'>";
        answersHtml += "<span>Created at " + e.created_at + "</span>";
        answersHtml += "</div>";
        answersHtml += "<div class='col-5'>";
        answersHtml += "<img class='avatar-account' src='" + e.user_avatar + "'>";
        answersHtml += "<span>" + e.user_name + "</span>";
        answersHtml += "</div>";
        answersHtml += "<div class='col-2 text-right'>";
        answersHtml += "<button type='button' class='btn btn-danger' onclick='deleteAnswer(" + e.id + ")'> delete </button>";
        answersHtml += "</div>";
        
        answersHtml += "</div>";
        answersHtml += "</div>";
      });
      if (!answersHtml) {
        answersHtml = "There is no answer yet";
      }
      $("#answer-contents").empty().html(answersHtml);

      $("#add-answer").off('click');
      $("#add-answer").on('click', function() {
        document.location.href = '/answer/add/' + question.id;
      });
    }

    function deleteAnswer(id) {
      if (!confirm("{{ __('messages.delete_question_detail') }}"))
            return false;

      $.ajax({
          type: "GET",
          url: "/answer/delete/"+id,
          success: function (data) {
            $("#answer-" + id).remove();
          },
          error: function (data) {
              console.log('Error:', data);
          }
      });
    }
  </script>
@endpush