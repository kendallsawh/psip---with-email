<!doctype html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.87.0">
    <title>Public Sector Investment Program Web Application</title>

    <!-- Bootstrap core CSS -->
    <link href="{!! url('assets/bootstrap/css/bootstrap.min.css') !!}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />

    <style>
      body{
        /*background-image: url('/img/vector.jpg'); background-size: cover;*/
        background-image: url("{{ asset('img/vector.jpg') }}");
      }
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .float-right {
        float: right;
      }
    </style>

    
    <!-- Custom styles for this template -->
    <!-- <link href="{!! url('css/app.css') !!}" rel="stylesheet"> -->

    
    <!-- Additional per-page css -->
      @yield('css')
</head>
<body>
    
    @include('layouts.partials.navbar')

    <main class="container mt-5" >
        @yield('content')
    </main>

    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
    <script src="{!! url('assets/bootstrap/js/bootstrap.bundle.min.js') !!}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js" integrity="sha512-HWlJyU4ut5HkEj0QsK/IxBCY55n5ZpskyjVlAoV9Z7XQwwkqXoYdCIC93/htL3Gu5H3R4an/S0h2NXfbZk3g7w==" crossorigin="anonymous"></script> -->
    <script type="text/javascript">
      $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        });
      var path = "{{route('autocomplete')}}";

      $( "#search" ).autocomplete({
        source: function( request, response ) {
          $.ajax({
            url: path,
            type: 'GET',
            dataType: "json",
            data: {
             search: request.term
           },
           success: function( data ) {
             
            response( data );
          }
        });
        },
        select: function (event, ui) {
          $('#search').val(ui.item.label);
          $('#submitsearch').click();
         //myFunction();
         //console.log(ui); 
         return false;
       }
     });

      function myFunction() {
        alert('k');
        $('#searchform').submit(function(){
      alert('ff');});
        /*var url = "{{url('/searchform')}}";
        $.ajax({
          type: "POST",
          url: url,
          data: searchValue,
          success: function(data) {

          },
          error: function(){console.log(data);}
        });*/
        /*$.get(listingPath,{searchvalue:searchValue},function(data,status,xhr){
                
                $('tbody').empty().html(data);
            },"html");*/
    }

      

   </script>
    
    @section("scripts")
    <!-- Include per-page JS -->
      @yield('scripts')

      
    @show
  </body>
</html>