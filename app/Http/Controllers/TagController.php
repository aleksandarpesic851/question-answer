<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index(Tag $model)
    {
        return view('tag.index', ['tags' => $model->get()]);
    }

    public function store(Request $request, Tag $model)
    {
        $newTag = $model->create($request->post());
        $newTag->save();
        return redirect()->route('tag.index')->withStatus(__('messages.tag_create_message'));
    }

    public function update(Request $request, $id)
    {
        $tag = Tag::find($id);
        $tag->update($request->post());
        return redirect()->route('tag.index')->withStatus(__('messages.tag_update_message'));
    }

    public function destroy($id)
    {
        Tag::where('id', $id)->delete();

        return redirect()->route('tag.index')->withStatus(__('messages.tag_delete_message'));
    }

}
