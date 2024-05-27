@extends('layouts.frontend.app')

@section('title','Register')
    
@section('content')


<div class="container-fluid login-register">
    <div class="row">
      <div class="col-md-3 col-lg-3 col-sm-2 col-xs-2">
      
      </div>
      <div class="col-md-6 col-lg-6  col-sm-8 col-xs-8">
        <div class="card">
          <div class="card-header">
            
            <h3 style="color: white;"> <strong>Register</strong> </h3>
          </div>

          <div class="card-body">
            
             <form action="{{ route('register') }}" method="POST"> 
               @csrf

               @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                @endif



            <div class="input-group mb-3">
              <input type="text" class="form-control" placeholder="Enter your name" name="name" value="{{ old('name') }}">
            </div>

            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Enter your username" name="username" value="{{ old('username') }}">
            </div>


            <div class="input-group mb-3">
               <select name="role_id" class="form-control" value="{{ old('role_id') }}">
                        <option value="">select a role</option>
                        <option value="2" {{ old('role_id') == 2 ? 'selected' : ''   }} >Landlord</option>
                        <option value="3" {{ old('role_id') == 3 ? 'selected' : ''  }} >Renter</option>
                </select>
            </div>

            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Nid number" name="nid" value="{{ old('nid') }}">
            </div>

            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="contact (please add 88 before number)" name="contact" value="{{ old('contact') }}">
            </div>

            <div class="input-group mb-3">
                <input type="email" class="form-control" placeholder="email" name="email" value="{{ old('email') }}">
            </div>

            <div class="input-group mb-3">
                <input id="password" type="password" class="form-control" placeholder="password (must be 8 digits)" name="password">
            </div>


            <div class="input-group mb-3">
                <input id="password-confirm" type="password" placeholder="confirm password" class="form-control" name="password_confirmation" >

            </div>
            
            <button type="submit" class="btn btn-primary btn-block">Register</button>
        
          </form> 
          </div>
          
        </div>
      </div>
      <div class="col-md-3 col-lg-3  col-sm-2 col-xs-2">
        
      </div>
    </div>
  </div>
@endsection



@section('css')
<style>
    .card{
        background: black;
        background-color: rgba(0,0,0,.5);
        margin-top: 70px;
        margin-bottom: 70px;
    }
    .icon {
        font-size: 25px;
    }

</style>
@endsection
