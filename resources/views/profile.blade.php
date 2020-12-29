@extends('layouts.dashboard')    

@section('content')


<div class="content">
    <div class="animated fadeIn">

        <div class="col-md-12">
            <div class="card">                
                <div class="card-body">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                    </div>
                @endif

                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
                    </div>
                @endif

    
                    
                    <div class="text-center">
                    <img class="user-avatar rounded-circle" src="{{asset('/images/user.png')}}" alt="User Avatar" style="width:150px;height:150px">
			                </div>
			                <h3 class="profile-username text-center">{{$me->name}}</h3>
                    </div>
        <form id="profileform" enctype="multipart/form-data" method="POST" action="updateprofile">
        
                
                
        <div class="card-body">
                <div class="row">
                
                        <div class="col-md-6">  
                        {{csrf_field()}}  
                        <input type="hidden" name="id" value="{{$me->id}}">                   
                          <label>Name</label>
                          <input type="text" class="form-control" name="name" value="{{$me->name}}" disabled>
                        </div>

                        <div class="col-md-6">
                          <label>Matric No</label>
                          <input type="text" class="form-control" name="matric" value="{{$me->matric}}" disabled>
                        </div>
                

                        <div class="col-md-6">
                          <label>Course</label>
                          <select name="course" id="course" class="form-control select2">
                          <option value="">Please Select</option>
                          @foreach($course as $courses)
                          <option value="{{$courses->id}}" <?php if($me->course == $courses->id) echo "selected"; ?>>{{$courses->course_code}} [{{$courses->course_name}}]</option>
                          @endforeach
                          </select>
                        </div>

                        <div class="col-md-6">
                          <label>Year</label>
                          <input type="text" class="form-control" name="year" value="{{$me->year}}" disabled>
                        </div>

                        <div class="col-md-6">
                          <label>Phone</label>
                          <input type="text" class="form-control" name="phone" value="{{$me->phone}}">
                        </div>

                        <div class="col-md-6">
                          <label>Gender</label>
                          <input type="text" class="form-control" name="gender" value="{{$me->gender}}" disabled>
                        </div>
                    </div>
                    <br><br>

                    <button class="btn btn-success"  style="float:right" type="submit">Update</button>
            </div>
        </form>



                  
                      
                </div>
            </div>
        </div>

    </div><!-- .animated -->
</div><!-- .content -->
@endsection

			