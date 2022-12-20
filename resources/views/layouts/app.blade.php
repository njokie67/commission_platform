@include('layouts.header')
<body style="margin-top: 80px;">
    <div id='loadingmessage' style='display:none'>
      <img src='/ajax-loader.gif'/>
    </div>
    @yield('content')
  @include('layouts.footer')