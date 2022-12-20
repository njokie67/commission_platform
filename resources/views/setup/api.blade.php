@include('layouts.header')
<body>
    <div class="container">
        <div class="row mt-5 justify-content-center">
            <div class="col-md-8 card">
                <form class="card-body form-group" id='organizationapiadd'>
                    <div class="row">
                        <div class="col-lg-12">
                        <label>Organization Name</label>
                        <input type="text" class="form-control" required name="organization_name" placeholder="Organization Name">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 mt-3">
                        <label>API Key</label>
                        <input type="text" name="organization_apikey" class="form-control" required placeholder="Organization API key">
                        </div>
                    </div>
                    <div class="mt-4">
                        @csrf
                        <button class="btn btn-primary organizationapiadd">Add Organization</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@include('layouts.footer')