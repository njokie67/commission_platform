<div class="modal fade" id="loadingmessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body form-group" action="#">
            <div class="row">
              <div class="col-md-12 text-center text-success">
                <p><i class="fa fa-lightbulb fa-4x" aria-hidden="true"></i><br> Transfering data from CLOSE api to the System</p>
                <img src="/ajax-loader.gif">
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>
  <script src="/assets/vendor/jquery/dist/jquery.min.js"></script>
  <script src="/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="/assets/vendor/js-cookie/js.cookie.js"></script>
  <script src="/assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
  <script src="/assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>
  <script src="/assets/vendor/chart.js/dist/Chart.min.js"></script>
  <script src="/assets/vendor/chart.js/dist/Chart.extension.js"></script>
  <script src="/assets/js/argon.js?v=1.2.0"></script>
  <script>
  $('#dateselect').datepicker({
  });
  </script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
  <script>
      $(document).ready(function () {
            toastr.options.fadeOut = 250;
            toastr.options.fadeIn = 250;
            toastr.options.closeButton = true;
            toastr.options.timeOut = 5000;
            @isset($error)
            toastr['error']("{{ $error }}");
            @endisset

            @if($errors->all())
                @foreach($errors->all() as $message)
                toastr['error']("{{ $message }}");
                @endforeach
            @endif

            @isset($success)
                toastr['success']("{{ $success }}");
            @endisset

            @isset($info)
                toastr['info']("{{ $info }}");
            @endisset
            @if(session()->has('message'))
                toastr['info']("{{ session()->get('message') }}");
            @endif
            @if(session()->has('error'))
                toastr['error']("{{ session()->get('error') }}");
            @endif
            @if(session()->has('success'))
                toastr['success']("{{ session()->get('success') }}");
            @endif
            @if(session()->has('info'))
                toastr['info']("{{ session()->get('info') }}");
            @endif
      });
  </script>
  <script>
    $('.select2').select2();
  </script>
@isset($organisation)

<script type="text/javascript">
    $('.refreshDataBtn').click(function (e) { 
        e.preventDefault();
        $(".refreshDataBtn").attr("disabled", true);
        $('#loadingmessage').modal('show');
        $.ajax({
        type: 'GET', //THIS NEEDS TO BE GET
        url: '/refresh/{{$organization->system_id}}',
        success: function () {
            $(".refreshDataBtn").attr("enable", true);
            $('#loadingmessage').modal('hide');
            location.reload(true);
        },
    });
        
    });
</script>
    @endisset
    <script type='text/javascript'>
    $(".organizationapiadd").click(function(event){
      event.preventDefault();
      let name = $("input[name=organization_name]").val();
      let apikey = $("input[name=organization_apikey]").val();
      let _token   = $('meta[name="csrf-token"]').attr('content');
      $(".organizationapiadd").attr("disabled", true);
      $('#loadingmessage').modal('show');
      $.ajax({
        url: "/add/new/api",
        type:"POST",
        data:{
          name:name,
          apikey:apikey,
          _token: _token
        },
        success:function(response){
          if(response) {
            toastr['success'](response.success);
            $("#organizationapiadd")[0].reset();
            $(".organizationapiadd").attr("enable", true);
            $('#loadingmessage').modal('hide'); 
          }
          location.reload(true);
        },
       });
  });

</script>
</body>

</html>