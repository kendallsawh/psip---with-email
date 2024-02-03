@extends('layouts.app-master')

@section('content')
@auth
    <div class="bg-light p-5 rounded">
        
        <h1>Dashboard</h1>
        <p class="lead">Only authenticated users can access this section.</p>
        <p class="lead">Packages installed in this default project are</p>
        
        <ul>
            <li><a href="https://spatie.be/docs/laravel-permission/v5/introduction">spatie/laravel-permission</a></li>
            <li><a href="https://laravelcollective.com/docs/6.x/html">laravelcollective/html</a></li>
            <li><a href="https://codeanddeploy.com/blog/laravel/laravel-8-authentication-login-and-registration-with-username-or-email">This project was built from this tutorial</a></li>
            <li><a href="https://codeanddeploy.com/blog/laravel/laravel-8-user-roles-and-permissions-step-by-step-tutorial">And then this tutorial for roles and permissions</a></li>
            <li></li>
        </ul>
       

        
    </div>
    <div class="bg-light p-5 rounded">       
        <p class="lead">Other packages that may interest you</p>
        
        <ul>
            <li><a href="https://spatie.be/docs/laravel-activitylog/v4/introduction">spatie/laravel-activitylog</a></li>
            <li><a href="https://spatie.be/docs/laravel-query-builder/v5/introduction">spatie/laravel-query-builder</a></li>
            <li><a href="https://codeanddeploy.com/item/laracrud-multipurpose-laravel-admin-crud-generator?utm_source=codeanddeploy&utm_medium=laravel-auth-blog&utm_id=bottom-link">Laracrud - Multipurpose Laravel Admin CRUD Generator</a></li>
            <li><a href="https://codeanddeploy.com/blog/laravel/laravel-supervisor-setup-with-example">Laravel 9 Supervisor Setup with Example</a></li>
            <li></li>
        </ul>
       

        
    </div>

    <div class="bg-light p-5 rounded">       
        <p class="lead">Tutorials that may interest you</p>
        
        <ul>
            <li><a href="https://codeanddeploy.com/blog/jquery/ajax-loading-in-jquery-using-php">Ajax Loading in jQuery using PHP</a></li>
            <li><a href="https://codeanddeploy.com/blog/jquery/how-to-prevent-double-click-in-jquery-when-submitting-ajax">How To Prevent Double Click in jQuery when Submitting Ajax</a></li>
            <li><a href="https://codeanddeploy.com/blog/laravel/laravel-8-authentication-login-and-registration-with-username-or-email">Laravel 9 Auth Login and Registration with Username or Email</a></li>
            <li><a href="https://codeanddeploy.com/blog/jquery/how-to-check-empty-null-and-undefined-variables-in-javascript-jquery">How To Check Empty, Null, and Undefined Variables in Javascript / jQuery?</a></li>
            <li><a href="https://codeanddeploy.com/blog/laravel/laravel-8-ajax-example-step-by-step-tutorial">Laravel 9 Ajax Example Step by Step Tutorial</a></li>
            <li><a href="https://codeanddeploy.com/blog/laravel/laravel-8-pagination-example-using-bootstrap-5">Laravel 9 Pagination Example using Bootstrap 5</a></li>
            <li><a href="https://codeanddeploy.com/blog/jquery/how-to-check-radio-button-based-on-selected-value-in-javascriptjquery">How To Check Radio Button Based On Selected Value in Javascript/jQuery?</a></li>
            <li><a href="https://codeanddeploy.com/blog/jquery/how-to-loop-checkbox-checked-value-in-jquery">How To Loop Checkbox Checked Value in jQuery</a></li>
            <li><a href="https://codeanddeploy.com/blog/laravel/laravel-collection-to-array-tutorial-and-example">Laravel Collection to Array Tutorial and Example</a></li>
            <li><a href="https://codeanddeploy.com/blog/laravel/laravel-google-translate">Laravel Google Translate</a></li>
            <li><a href="https://codeanddeploy.com/blog/laravel/get-model-table-name-in-laravel">Get Model Table Name in Laravel</a></li>
            <li><a href="https://codeanddeploy.com/blog/laravel/laravel-8-logout-other-devices-after-login">Laravel 9 Logout Other Devices after Login</a></li>
            <li><a href="https://codeanddeploy.com/blog/laravel/laravel-8-simple-custom-validation-rules-example">Laravel 9 - Simple Custom Validation Rules Example</a></li>
            <li><a href="https://codeanddeploy.com/blog/laravel/how-to-protect-env-file-in-laravel-using-shared-hosting">How To Protect .env file in Laravel using Shared Hosting</a></li>
            <li><a href="https://codeanddeploy.com/blog/laravel/lists-of-laravel-projects-open-source-code">Lists of Laravel Projects Open Source Code</a></li>
            <li><a href="https://codeanddeploy.com/category/laravel">Laravel Category</a></li>
            <li><a href="https://techvblogs.com/blog/laravel-import-export-excel-csv-file">Laravel 8 Import Export Excel & CSV File Example</a></li>
            <li><a href="https://techvblogs.com/blog/deploy-laravel-project-apache-ubuntu">How to Deploy Laravel Project with Apache on Ubuntu</a></li>
            <li><a href="https://techvblogs.com/blog/conditional-class-blade-directive-laravel">Conditional Classes Blade Directives in Laravel</a></li>
            <li><a href="https://techvblogs.com/blog/social-login-laravel-socialite">Add Social Login in Laravel With Socialite</a></li>
            <li><a href="https://techvblogs.com/blog/laravel-8-cursor-based-pagination-example">Laravel 8.x Cursor Based Pagination Example</a></li>
            <li><a href="https://techvblogs.com/blog/understanding-and-working-with-files-in-laravel">Understanding and Working with Files in Laravel</a></li>
            <li><a href="https://techvblogs.com/blog/how-to-send-email-laravel">How to Send an Email in Laravel</a></li>
            <li><a href="https://techvblogs.com/blog/api-authentication-laravel-sanctum">API Authentication using Laravel Sanctum</a></li>
            <li><a href="https://techvblogs.com/blog/toast-notification-livewire-laravel">Toast Notification in Laravel Livewire Tutorial</a></li>
            <li><a href="https://techvblogs.com/blog/firebase-push-notification-laravel">Firebase Push Notification Laravel Tutorial</a></li>
            <li><a href="https://techvblogs.com/blog/laravel-passport-authentication">Implement Passport In Laravel</a></li>
            <li><a href="https://www.codewall.co.uk/laravel-ldap-authentication-tutorial-using-adldap2-laravel/">ldap laravel</a></li>
        </ul>
       

        
    </div>
    <div class="bg-light p-5 rounded">        
        <h3>Download this custom project compiled by Kendall using this <a href="#">Github link</a></h4> 
        <p>dont forget to run <strong>compser update</strong> and <strong>php artisan generate:key</strong> or was it <strong>key:generate?</p>     
    </div>

    <div class="bg-light p-5 rounded">        
        <!-- <a href="ftp://apps:1234@10.13.1.66/proofdocs/Current Land Tax Receipt_29225_30494_c41d783c82fbb9bc08d4f5f38ed61d04.pdf" target="_blank" type='button' id="confirm" class='btn btn-success btn-round btn-xs btn-block'>doc</a>  -->
        <!-- <a href="{{ url('/dl') }}" target="_blank" type='button' id="confirm" class='btn btn-success btn-round btn-xs btn-block'>doc</a> --> 
        <button type="button" class="btn btn-primary" id="getdoc">Transfer to local folder</button>

        <a href="" target="_blank" type='button' id="doc" class='btn btn-success btn-round btn-xs btn-block hide'>Your document</a>
        <button type="button" class="btn btn-primary hide" id="deletedoc">Clean up the folder  </button>
        <!-- <button type="button" class="btn btn-primary" id="dl2">Download from server</button> -->
        <a href="{{url('/dl2')}}" target="_blank" type='button' id="dl2" class='btn btn-success btn-round btn-xs btn-block'>Download from server</a>
    </div>
@endauth
@guest
    <div class="bg-light p-5 rounded">
        
        <h1>Homepage</h1>
        <p class="lead">Your viewing the home page. Please login to view the restricted data.</p>
        
    </div>
@endguest
@endsection
@section("scripts")
<script type="text/javascript">
    $('.hide').hide();
    $('#getdoc').click(function() {
        //alert( "Handler for .click() called." );
        $.ajax({
            type: "GET",
            url: "{{url('/dl')}}",
            
            dataType: "html",
            success: function(res) {
                
                    
                      $("#doc").attr("href", res);
                      $("#doc").show();
                      $("#deletedoc").show();
                        
            },
            error: function (data) {
                var errors = data.responseJSON;
                console.log(data.responseText);
            }
        });
    });
    $('#deletedoc').click(function() {
        //alert( "Handler for .click() called." );
        $.ajax({
            type: "GET",
            url: "{{url('/del')}}",
            
            dataType: "html",
            success: function(res) {               
                    
                      $("#doc").attr("href", '');
                      $("#doc").hide();
                      $("#deletedoc").hide();
                      alert(res);
                        
            },
            error: function (data) {
                var errors = data.responseJSON;
                console.log(data.responseText);
            }
        });
    });
    

    /*$('#dl2').click(function() {
        //alert( "Handler for .click() called." );
        $.ajax({
            type: "GET",
            url: "{{url('/dl2')}}",
            
            dataType: "html",
            success: function(res) {
                
            },
            error: function (data) {
                var errors = data.responseJSON;
                console.log(data.responseText);
            }
        });
    });*/
    //You have to add the selector parameter, otherwise the event is directly bound instead of delegated, which only works if the element already exists (so it doesn't work for dynamically loaded content).
/*        $(document.body).on('click', '.appointment_date' ,function(){        
        var choice = $( "input[type=radio][name=appointment_date]:checked" ).val()
        var districtid = $('#town_village').val();
        $.ajax({
            type: "POST",
            url: '{{url('get_appointment_time')}}',
            data: {
                date:choice,
                districtid:districtid,
                _token: "{{ csrf_token() }}",
            },
            dataType: "html",
            success: function(res) {
                
                    //alert(res);
                    var obj = jQuery.parseJSON(res);
                    $.each(obj, function(key,value) {
                      //alert(value.appointment_time);
                      $("div.time-group").find("[class*='app_time']").each(function(){
                        var currentElement = $(this); //jquery object
                        //var currentElementNotJquery = this; //html element
                        if (currentElement.val() == value.appointment_time) {
                            //alert('pass ' + currentElement.val()+ " " + value.appointment_time)
                            currentElement.addClass('hide')
                        }                       
                        })
                  });
            },
            error: function (data) {
                var errors = data.responseJSON;
                console.log(data.responseText);
            }
        });
    })*/
</script>

    @endsection