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
                <li class="breadcrumb-item"><a href="#">Sales Representative</a></li>
              </ol>
            </nav>
          </div>
        </div>
        <div class="row">
            <div class="col-xl-6 col-md-6">
              <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Total cash collected</h5>
                      @php
                      $formatter = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
                      $total = $formatter->formatCurrency($salesrep->opportunities->sum('value'), 'USD');
                      @endphp
                      <span class="h2 font-weight-bold mb-0">{{ $total }}</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                        <i class="ni ni-sound-wave"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-6 col-md-6">
              <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      @php
                      $formatter = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
                      $commission = $formatter->formatCurrency(((($organization->commission / 100)*$salesrep->opportunities->sum('value'))-$salesrep->commissionpaid), 'USD');
                      @endphp
                      <h5 class="card-title text-uppercase text-muted mb-0">Total Commission Owed</h5>
                      <span class="h2 font-weight-bold mb-0">{{$commission}}</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                        <i class="ni ni-chart-pie-35"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
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
                <h3 class="mb-0">{{$salesrep->first_name}} {{$salesrep->second_name}} Summary</h3>
              </div>
            </div>
          </div>
          <div class="table-responsive">
            <!-- Projects table -->
            <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Value</th>
                    <th scope="col">Date Won</th>
                  </tr>
                </thead>
                <tbody>
                  
                      @foreach ($opportunities as $opportunity)
                      <tr>
                          <th scope="row">
                          {{$opportunity->lead_name}}
                        </th>
                        <td>
                          {{$opportunity->value_formatted }}
                        </td>
                        <td>
                          {{$opportunity->date_won}}
                        </td>
                      </tr>
                      @endforeach                
                </tbody>
              </table>
              {!!$opportunities->links()!!}
          </div>
        </div>
      </div>
    </div>
@endsection
