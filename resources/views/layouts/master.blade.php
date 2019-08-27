<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	@include('layouts.head')
</head>
<body>
  <div id="app">
    @include('layouts.nav')

    @include('layouts.sidebar')

    <div class="content-wrapper">
      @yield('content')
    </div>

    @include('layouts.footer')
  </div>

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}"></script>
  <script>
    $(function() {

      /* Dashboard sidebar */
      var docHeight = $(document).height() + 'px';
      $('.sidebar-wrapper').css('height', docHeight);

      /* Tooltip */
      $('[data-toggle="tooltip"]').tooltip();

    //active class
    var url = window.location;

    //for sidebar menu entirely but not cover treeview
    $('ul.sidebar-active a').filter(function() {
     return this.href == url;
   }).parent().addClass('active');

    $("li.active").parent().parent().addClass('open');
  });     
</script>

@role('super_admin')
<script>
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $(function poll(){
              //this makes the setTimeout a self run function it runs the first time always
              setTimeout(function(){
                $.ajax({
                      url:"/checkforpending", // Url to which the request is send
                      type: "GET",             // Type of request to be send, called as method
                      data : "",
                      success: function( data )   // A function to be called if request succeeds
                      {
                        if (data.pendingsale > 0) {
                          $('#salenotification').addClass("fa fa-exclamation fa-2x");
                        }
                        else {
                          $('#salenotification').removeClass("fa fa-exclamation fa-2x");
                        }

                        if (data.pendingexpense > 0) {
                          $('#expensenotification').addClass("fa fa-exclamation fa-2x");
                        }
                        else {
                          $('#expensenotification').removeClass("fa fa-exclamation fa-2x");
                        }

                        if (data.pendingpurchase > 0) {
                          $('#purchasenotification').addClass("fa fa-exclamation fa-2x");
                        }
                        else {
                          $('#purchasenotification').removeClass("fa fa-exclamation fa-2x");
                        }
                      },
              //this is where you call the function again so when ajax complete it will cal itself after the time out you set.
              complete: poll
            });
          //end setTimeout and ajax 
        },10000);
      //end poll function
    });

  </script>
  @endrole
  @yield('script')
  
</body>
</html>