<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Answer;
use App\Question;
use App\User;
use App\Http\DataHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;

class AnswerController extends Controller
{
    public function addAnswer($question_id) 
    {
        $question = Question::getQuestionDetail($question_id);
        return view('answer.create', ['question' => $question]);
    }

    public function createAnswer(Request $request)
    {
        $type = $request->type;
        $content = $request->content;
        $image = null;
        $created_by = empty($request->created_by) ? Auth::user()->id : $request->created_by;

        if ($type == "image") 
        {
            //save image
            if(!$request->hasFile('image')){
                return DataHelper::makeResponse(false, 'Invalid Requirement');
            }
            $image = $this->saveImage($request);
            //Call API to get text from image
            $content = "API Text recognition results.";
        } else {
            if (empty($request->content))
            {
                return DataHelper::makeResponse(false, 'Invalid Requirement');
            }
        }

        $res = Answer::create(["content" => $content, "image" => $image, "created_by" => $created_by, "type" => $type, "question_id" => $request->question_id]);
        $question = Question::find($request->question_id);
        $user = User::find($created_by);
        if ($question->state != "admin answered")
        {
            $question->state = $user->isAdmin() ? "admin answered" : "user answered";
            $question->save();
        }
        return DataHelper::makeResponse(true, '', $res);
    }

    public function destroy($id)
    {
        $answer = Answer::where('id', $id)->delete();
        return response()->json($answer);
    }

    private function saveImage(Request $request){
        $image = $request->file('image');
        $filename = time() . '.' . $image->getClientOriginalExtension();
        Image::make($image)->save( public_path('/uploads/answers/' . $filename ) );

        return '/uploads/answers/' . $filename;
    }

}
