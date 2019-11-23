<?php

namespace App\Http\Controllers;

use App\Question;
use App\Answer;
use App\Tag;
use Illuminate\Http\Request;
use App\Http\DataHelper;

class QuestionController extends Controller
{
    public function index(Question $model)
    {
        $tags = Tag::get();
        return view('question.index', ['tags' => $tags]);
    }

    public function store(Request $request, Question $model)
    {
        $newTag = $model->create($request->post());
        $newTag->save();
        return redirect()->route('question.index')->withStatus(__('messages.question_create_message'));
    }

    public function destroy($id)
    {
        $question = Question::where('id', $id)->delete();
        return response()->json($question);
//      return redirect()->route('question.index')->withStatus(__('messages.question_delete_message'));
    }

    //get all question list as datatable
    public function getDatatable(Request $request)
    {
        $questions =Question::getQuestionDetailList($request);
        $datatable = datatables()->of($questions)
                                ->addIndexColumn();
        $datatable = $datatable
                    ->editColumn('content', function($row) {
                        $contentLen = 200;
                        return strlen($row->content) > $contentLen ? substr($row->content, 0, $contentLen) . "..." : $row->content;
                    })
                    ->addColumn('question_posted_by', function($row) {
                        return "<img src='$row->user_avatar' class='avatar-account'>$row->user_name";
                    })
                    ->addColumn('active_action', function($row) {
                        $check = $row->active == 1 ? "check_box" : "check_box_outline_blank";
                        return "<a href='#' alt='Active/Deactive' data-active=$row->active class='active_item' data-id=$row->id> <i class='material-icons'>$check</i></a>";
                    })
                    ->addColumn('action', function ($row) {
                        return " <a href='#' alt='Delete' class='delete_item' data-id=$row->id> <i class='material-icons'>delete</i></a>";
                    })
                    ->rawColumns(['action', 'question_posted_by', 'active_action']);

        return $datatable->make(true);
    }

    //activate/deactivate a question
    public function activate(Request $request)
    {
        Question::activate($request);
    }

    public function getQuestion(Request $request)
    {
        $id = (isset($request->id)) ? $request->id : ('');
        $question = Question::getQuestionDetail($id);

        $answers = Answer::getAnswersByQuestionId($id);    
        return DataHelper::makeResponse(true, '', ['question' => $question, 'answers' => $answers]);
    }

    public function getQuestionLists(Request $request)
    {
        $questions =Question::getQuestionDetailList($request);
        return DataHelper::makeResponse(true, '', $questions);
    }
}
