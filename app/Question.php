<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Question extends Model
{
    protected $fillable = [
        'created_by', 'tag', 'active', 'type', 'content', 'image', 'state'
    ];

    private static function getTagNames($keys) {
        $tags = Tag::whereIn('id', json_decode($keys))->select("tag")->get()->toArray();
        $result = array();
        foreach($tags as $tag) 
        {
            array_push($result, $tag["tag"]);
        }
        return $result;
    }

    public static function getQuestionDetail($id)
    {
        $question = Question::leftJoin('users', 'users.id', '=', 'questions.created_by')
                ->select('questions.*', 'users.name as user_name', 'users.email as user_email', 'users.avatar as user_avatar', 'users.phone as user_phone')
                ->find($id);
        $question->tag_name = Question::getTagNames($question->tag);
        $follows = Follow::where('question_id', '=', $question->id)->where('state', '=', 'follow')->select(['user_id'])->get();
        $question->follow_cnt = $follows->count();
        $arrFollow = array();
        foreach($follows as $follow)
        {
            array_push($arrFollow, $follow["user_id"]);
        }
        $question->follow_users = $arrFollow;
        return $question;
    }

    //Get all question list
    public static function getQuestionDetailList(Request $request)
    {
        $questionQuery = Question::leftJoin('tags', 'tags.id', '=', 'questions.tag')
                                ->leftJoin('users', 'users.id', '=', 'questions.created_by');
        $tag = (isset($request->tag)) ? $request->tag : '';
        $fromDate = (isset($request->fromDate)) ? $request->fromDate : '';
        $toDate = (isset($request->toDate)) ? $request->toDate : '';
        $state = (isset($request->state)) ? $request->state : '';

        if ($tag)
        {

            $questionQuery = $questionQuery->where(function($query) use($tag) {
                return $query->where('questions.tag', 'LIKE', '%'.$tag.'%')
                            ->orWhere('questions.tag', 'LIKE', '%['.$tag.',%')
                            ->orWhere('questions.tag', 'LIKE', '%,'.$tag.',%')
                            ->orWhere('questions.tag', 'LIKE', '%,'.$tag.']%');
            });
        }
        if ($fromDate)
        {
            $fromDate = date('Y-m-d', strtotime($fromDate));
            $questionQuery = $questionQuery->whereRaw("date(questions.created_at) >= '" . $fromDate . "'");
        }
        if ($toDate)
        {
            $toDate = date('Y-m-d', strtotime($toDate));
            $questionQuery = $questionQuery->whereRaw("date(questions.created_at) <= '" . $toDate . "'");
        }
        if ($state)
        {
            $questionQuery = $questionQuery->where('state', '=', $state);
        }
        $questions = $questionQuery->select('questions.*', 'users.name as user_name', 'users.email as user_email', 'users.avatar as user_avatar', 'users.phone as user_phone')
                                    ->orderby('created_at', 'desc')->get();
        foreach($questions as $question)                                    
        {
            $question->tag_name = Question::getTagNames($question->tag);
            $follows = Follow::where('question_id', '=', $question->id)->where('state', '=', 'follow')->select(['user_id'])->get();
            $question->follow_cnt = $follows->count();
            $arrFollow = array();
            foreach($follows as $follow)
            {
                array_push($arrFollow, $follow["user_id"]);
            }
            $question->follow_users = $arrFollow;
        }
        return $questions;
    }

    public static function activate(Request $request)
    {
        $id = $request->get('id');
        $active = $request->get('active');

        $question = Question::find($id);
        $question->active = $active;
        $question->save();
    }
}
