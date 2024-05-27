@extends('layouts.frontend.app')

@section('title','Login')
    

@section('content')

@if ($al)
<script>alert("{{$msg}}")</script>
    
@endif


<div class="container-fluid login-register">
    <div class="row">
      <div class="col-md-3 col-lg-4 col-sm-2 col-xs-2">
      
      </div>
      <div class="col-md-6 col-lg-4  col-sm-8 col-xs-8">
        <div class="card">
          <div class="card-header">
            
            <h3 style="color: white;"> <strong>Login</strong> </h3>
          </div>

          <div class="card-body">
            
             <form action="/log" method="POST"> 

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
              <input type="text" class="form-control" placeholder="Enter your username" name="username" value="{{ old('email') }}">
            </div>

            <div class="input-group mb-3">
                <input type="password" class="form-control" placeholder="Enter your password" name="password">
              </div>
            
            <button type="submit" class="btn btn-primary btn-block">Login</button>
            

              
          </form> 
          </div>
          
        </div>
      </div>
      <div class="col-md-3 col-lg-4  col-sm-2 col-xs-2">
        
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