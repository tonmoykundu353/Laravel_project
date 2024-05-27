@extends('layouts.backend.app')
@section('title')
    Renter - All Booking History
@endsection
@section('content')
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
               @include('partial.successMessage')  

                <div class="card my-5 mx-4">
                    <div class="card-header">
                      <h3 class="card-title float-left"><strong>Booking History ({{ $books->count() }})</strong></h3>
                      
                    </div>
                    <!-- /.card-header -->
                    @if ($books->count() > 0)
                    <div class="">
                    <div class="table-responsive">
                      <table id="dataTableId" class="table table-bordered table-striped table-background">
                        <thead>
                        <tr>
                          <th>Address</th>
                          <th>Entry</th>
                          <th>Leave</th>
                          <th>Rent</th>
                          <th>Renter Name</th>
                          <th>Landlord Name</th>
                          <th>Landlord Contact</th>
                          <th>Landlord Nid</th>
                          <th>Landlord Email</th>
                          
                       
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($books as $book)
                        <tr>
                          <td>{{ $book->address }}</td>
                          <td>{{ $book->created_at->format('F d, Y') }}</td>
                          <td>{{ $book->leave }}</td>
                          <td>{{ $book->rent }}</td>
                          <td>
                            @isset($book->renter->name)
                                {{ $book->renter->name }}
                            @else 
                                This renter is deleted by admin
                            @endisset
                          </td>
                          <td>
                            @isset($book->landlord->name)
                                {{ $book->landlord->name }}
                            @else 
                                This landlord is deleted by admin
                            @endisset
                          </td>
                          <td>
                            @isset($book->landlord->contact)
                                {{ $book->landlord->contact }}
                            @else 
                                This landlord is deleted by admin
                            @endisset
                          </td>
                          <td>
                            @isset($book->landlord->nid)
                                {{ $book->landlord->nid }}
                            @else 
                                This landlord is deleted by admin
                            @endisset  
                          </td>
                          <td>
                            @isset($book->landlord->email)
                                {{ $book->landlord->email }}
                            @else 
                                This landlord is deleted by admin
                            @endisset
                          </td>
                         
                          
                        </tr>
                        @endforeach    
                        </tbody>
                      </table>
                    </div>
                      
            </div> <!-- /.card-body -->
              @else 
                 <h2 class="text-center text-info font-weight-bold m-3">No Booking History Found</h2>
              @endif

               <div class="pagination">
                  
                </div>
                   
            </div>
                  <!-- /.card -->
            </div>
        </div>
    </div><!-- /.container -->
 @endsection

 