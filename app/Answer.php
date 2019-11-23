<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = [
        'created_by', 'type', 'content', 'image', 'state', 'question_id'
    ];

    //get answer detail list , which is answered for this question
    public static function getAnswersByQuestionId($question_id) 
    {
        return Answer::leftJoin('users', 'users.id', '=', 'answers.created_by')
                        ->where('answers.question_id', '=', $question_id)
                        ->select('answers.*', 'users.name as user_name', 'users.email as user_email', 'users.avatar as user_avatar', 'users.phone as user_phone')
                        ->get();
    }
}
