<?php

namespace App\Http\Controllers;
use App\Question;
use App\User;
use App\Tag;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $nUsers = User::count();
        $nQuestions = Question::count();
        $nAnsweredQuestions = Question::where('state', 'LIKE', '%answer%')->count();
        $nUnAnsweredQuestions = $nQuestions - $nAnsweredQuestions;
        $tags = Tag::get();
        return view('dashboard', compact(
            'nUsers',
            'nQuestions',
            'nAnsweredQuestions',
            'nUnAnsweredQuestions',
            'tags'
        ));
    }

    public function getQuestions(Request $request)
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
                    ->rawColumns(['question_posted_by']);

        return $datatable->make(true);
    }
}
