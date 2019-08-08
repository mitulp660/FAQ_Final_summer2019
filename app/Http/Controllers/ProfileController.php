<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Profile;
use App\User;
use App\Http\Requests;

//added for Image upload
use Image;//image uploaded class
use App\Traits\UploadTrait;
class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        {
            $users = \App\User::all();
            return view('users.profile', compact($users));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function profile(){
        return view('user', array('user' => Auth::user()) );
    }
    public function update_pic(Request $request){
        // Handle the user upload of pictures for profile
        if($request->hasFile('pic')){
            $pic = $request->file('pic');
            $filename = time() . '.' . $pic->getClientOriginalExtension();
            Image::make($pic)->resize(300, 300)->save( public_path('/uploads/pics/' . $filename ) );
            $user = Auth::user();
            $user->pic = $filename;
            $user->save();
        }
        return view('profile', array('user' => Auth::user()) );
    }
    public function create()
    {
        $profile = new Profile();
        $edit = FALSE;
        return view('profileForm', ['profile' => $profile,'edit' => $edit  ]);
    }// below are called to upload Images for profile

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'body' => 'required',
        ], [
            'fname.required' => ' First is required',
            'lname.required' => ' Last is required',
            'body.required' => ' Body is required',
        ]);
        $input = request()->all();
        $profile = new Profile($input);
        $profile->user()->associate(Auth::user());
        $profile->save();
        return redirect()->route('home')->with('message', 'Profile Created');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $user = Auth::user();
        $profile = $user->profile;
        return view('profile')->with('profile', $profile);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($user, $profile)
    {
        $user = User::find($user);
        $profile = $user->profile;
        $edit = TRUE;
        return view('profileForm', ['profile' => $profile, 'edit' => $edit ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $user, $profile)
    {
        $input = $request->validate([
            'fname' => 'required',
            'lname' => 'required',
        ], [
            'fname.required' => ' First is required',
            'lname.required' => ' Last is required',
        ]);
        $profile = Profile::find($profile);
        $profile->fname = $request->lname;
        $profile->lname = $request->lname;
        $profile->body = $request->body;
        $profile->save();
        return redirect()->route('home')->with('message', 'Updated Profile');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
