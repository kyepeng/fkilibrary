@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="type" id="type">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                        <label for="gender" class="col-md-4 control-label">Gender</label>

                            <div class="col-md-6">
                            <select name="gender" id="gender" class="form-control select2">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            </select>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('matric') ? ' has-error' : '' }}">
                            <label for="matric" class="col-md-4 control-label">Matric No</label>

                            <div class="col-md-6">
                                <input id="matric" type="text" class="form-control" name="matric" placeholder="BI12345678"  value="{{ old('matric') }}" required>

                                @if ($errors->has('matric'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('matric') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                        <label for="year" class="col-md-4 control-label">Year</label>

                            <div class="col-md-6">
                                <select name="year" id="year" class="form-control select2">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                        <label for="course" class="col-md-4 control-label">Course</label>

                            <div class="col-md-6">
                                <select name="course" id="course" class="form-control select2">
                                <option value="1">HC 12 Multimedia Technology</option>
                                <option value="2">HC 13 Business Computing</option>
                                
                                </select>
                            </div>
                        </div>

                       
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="phone" class="col-md-4 control-label">Phone</label>
                        <div class="col-md-6">
                          <input type="text" class="form-control" name="phone" required>

                            @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                            @endif
                        </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
