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
                <li class="breadcrumb-item"><a href="#">Settings</a></li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </div>
</div>

<div class="container-fluid mt--6">
    <div class="row">
      <div class="col-xl-12">
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
                  <th scope="col">Name</th>
                  <th scope="col">API key</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                    @foreach ($apiholders as $apiholder)
                    <tr>
                        <th scope="row">
                        {{$apiholder->name}}
                        </th>
                        <td>
                            <i class="fa fa-spinner" aria-hidden="true"></i> {{ substr($apiholder->api_key, 0, 5)}}......{{ substr($apiholder->api_key, -10)}}
                        </td>
                        <td>
                            <p><a data-toggle="modal" data-target="#removeApi{{$apiholder->id}}" class="text-danger"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a> </p>
                        </td>
                    </tr>

                    <div class="modal fade" id="removeApi{{$apiholder->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-body form-group" action="#">
                                <div class="row">
                                  <div class="col-md-12 text-center text-danger">
                                    <p><i class="fa fa-question-circle fa-4x" aria-hidden="true"></i><br> This action is irreversible. Please confirm whether you want to remove {{ $apiholder->name }} from your organizations?</p>
                                  </div>
                                </div>
                                <form action="/delete/apiholder/{{$apiholder->id}}" method="POST">
                                <div class="mt-4">
                                    @csrf
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                  <button type="submit" class="btn btn-success">Proceed</button>
                                </div>
                              </form>
                              </div>
                          </div>
                        </div>
                      </div>
                    @endforeach                
              </tbody>
            </table>
            {{$apiholders->links()}}
        </div>
    </div>
  </div>
</div>
@endsection