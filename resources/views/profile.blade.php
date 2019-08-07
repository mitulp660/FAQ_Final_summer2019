@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <img src="/uploads/pics/{{ $profile->pic }}" style="width:150px; height:150px; float:left; border-radius:50%; margin-right:25px;">
                        <h2>Profile of: -  {{ Auth::user()->email }}</h2>
                        <form enctype="multipart/form-data" action="{{route ('profile.update_pic')}}" method="POST">
                            <label>Update Profile Image</label>
                            <input type="file" name="pic">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="submit" class="pull-right btn btn-sm btn-primary">
                        </form>
                    </div>

                    <div class="card-body ">
                        <span class="font-weight-bold">First Name:</span> {{$profile->fname}}</br>
                        <span class="font-weight-bold">Last Name: </span>{{$profile->lname}}</br>
                        <span class="font-weight-bold">Body: </span>{{$profile->body}}</br>
                    </div>
                    <div class="card-footer">
                         <a class="btn btn-success float-right" href="{{ route('profile.edit', ['profile_id' => $profile->id,'user_id' => $profile->user->id]) }}">
                            Edit
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
