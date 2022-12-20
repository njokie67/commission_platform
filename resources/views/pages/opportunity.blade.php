@extends('layouts.admin')

@section('content')
@php
    use App\Models\SaleRep;
@endphp
<div class="header bg-primary pb-6">
    <div class="container-fluid">
      <div class="header-body">
        <div class="row align-items-center py-4">
          <div class="col-lg-6 col-7">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
              <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item"><a href="#">Opportunities</a></li>
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
                    $total = $formatter->formatCurrency($opportunitiesall->sum('value'), 'USD');
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
                    $commission = $formatter->formatCurrency(((($organization->commission / 100)*$opportunitiesall->sum('value'))-SaleRep::all()->sum('commissionpaid')), 'USD');
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
                <h3 class="mb-0">Opportunities Summary</h3>
              </div>
              <div class="col text-right">
                Total: {{$opportunitiesall->count()}}
              </div>
            </div>
          </div>
          <div class="table-responsive">
            <!-- Projects table -->
            <table class="table align-items-center table-flush">
              <thead class="thead-light">
                <tr>
                  <th scope="col">Name</th>
                  <th scope="col">Sales Rep</th>
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
                        <a href="/organization/{{ $organization->system_id }}/reps/{{$opportunity->salesrep->id}}">{{$opportunity->salesrep->first_name}} {{$opportunity->salesrep->second_name}}</a>
                      </td>
                      <td>
                        {{$opportunity->value_formatted }}
                      </td>
                      <td>
                        {{$opportunity->date_won }}
                      </td>
                    </tr>
                    @endforeach                
              </tbody>
            </table>
            <p class="mt-4 d-flex justify-content-center">{!!$opportunities->links()!!}</p>
          </div>
        </div>
      </div>
    </div>
@endsection
