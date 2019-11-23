<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Image;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model)
    {
        return view('users.index', ['users' => $model->get()]);
    }

    /**
     * Show the form for creating a new user
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created user in storage
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\User  $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request, User $model)
    {
        $avatar = $this->save_avatar($request);
        $newUser = $model->create($request->merge(['password' => Hash::make($request->get('password'))])->all());
        $newUser->avatar = $avatar;
        $newUser->save();
        return redirect()->route('user.index')->withStatus(__('messages.user_create_message'));
    }

    private function save_avatar(UserRequest $request){
        // Logic for user upload of avatar
        $filename = "user.png";
        if($request->hasFile('avatar')){
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(200, 200)->save( public_path('/uploads/avatars/' . $filename ) );
        }
        return '/uploads/avatars/' . $filename;
    }
    /**
     * Show the form for editing the specified user
     *
     * @param  \App\User  $user
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, User  $user)
    {
        $avatar = $this->save_avatar($request);
        $user->update(
            $request->merge(['password' => Hash::make($request->get('password'))])
                ->except([$request->get('password') ? '' : 'password']
        ));
        if ($avatar != "user.png")
        {
            $user->update(['avatar' => $avatar]);
        }
        return redirect()->route('user.index')->withStatus(__('messages.user_update_message'));
    }

    /**
     * Remove the specified user from storage
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User  $user)
    {
        $user->delete();

        return redirect()->route('user.index')->withStatus(__('messages.user_delete_message'));
    }

    public function activate(Request $request)
    {
        $id = $request->get('id');
        $active = $request->get('active');

        $user = User::find($id);
        $user->active = $active;
        $user->save();
    }
}
