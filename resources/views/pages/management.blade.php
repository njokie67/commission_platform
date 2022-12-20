@extends('layouts.admin')

@section('content')
<div class="header bg-primary pb-6">
    <div class="container-fluid">
      <div class="header-body">
        <div class="row align-items-center py-4">
          <div class="col-lg-6 col-7">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
              <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                <li class="breadcrumb-item"><a href="/dashboard"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item"><a href="#">Management</a></li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </div>
</div>

<div class="container-fluid mt--6">
    <div class="row">
      <div class="col-xl-7">
        <div class="card">
          <div class="card-header border-0">
            <div class="row align-items-center">
              <div class="col">
                <h3 class="mb-0">Users level access</h3>
              </div>
            </div>
          </div>
          <div class="table-responsive">
            <!-- Projects table -->
            <table class="table align-items-center table-flush">
              <thead class="thead-light">
                <tr>
                  <th scope="col">User Name</th>
                  <th scope="col">Email</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <th scope="row">
                        {{$user->name}}
                        </th>
                        <td>
                            <i class="fa fa-envelope" aria-hidden="true"></i> {{$user->email}}
                        </td>
                        <td>
                            @if ($user->email == 'suspended')
                                <a href="">Activate</a>
                            @else                  
                                <a href="">Suspend</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach                
              </tbody>
            </table>
            {{$users->links()}}
          </div>
        </div>
      </div>
      <div class="col-xl-5">
        <div class="card">
          <div class="card-header border-0">
            <div class="row align-items-center">
              <div class="col">
                <h3 class="mb-0">Create user level access</h3>
              </div>
            </div>
          </div>
          <div class="card-body">
            <form method="POST" action="/organization/{{$organization->system_id}}/register">
                @csrf

                <div class="form-group row">
                    <div class="col-md-12">
                      <select class="form-control select2" name="salesrep">
                        @foreach ($salesrep as $salerep)
                          <option value="{{$salerep->id}}">{{$salerep->first_name}} {{$salerep->second_name}} - {{$salerep->email}}</option>    
                        @endforeach 
                      </select>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                  </div>

                <div class="form-group row mb-0">
                    <div class="col-md-4 offset-md-8">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Register') }}
                        </button>
                    </div>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
@endsection
