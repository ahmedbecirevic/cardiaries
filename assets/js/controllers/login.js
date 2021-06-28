class Login {
   static init(){
      if ( window.localStorage.getItem("token") ) {
         window.location = "index.html"
      } else {
         $('body').show()
      }

      const urlParams = new URLSearchParams(window.location.search)
     
      if (urlParams.has('token')) {
         $("#change-password-token").val(urlParams.get('token'));
         Login.showChangePasswordForm();
      }

      if (urlParams.has('/api/confirm/')) {
         const url = $(location).attr('href');
         const data = url.split('/');
         window.localStorage.setItem("token", data.pop());
         window.location = "index.html";
      }

      $("#login-form").validate({
         rules: {
           email: "required",
           password: "required",        
         },
         submitHandler: function(form, event) {
            event.preventDefault();
            Login.doLogin();
         }
      });

      $("#register-form").validate({
         rules: {
            first_name: "required",
            last_name: "required",  
            email: "required",        
            username: {
               required: true,
               minlength: 5
            },        
            password: {
               required: true,
               minlength: 4
            }      
         },
         submitHandler: function(form, event) {
            event.preventDefault();
            Login.doRegister();
         }
      });

      $("#forgot-form").validate({
         rules: {
           email: "required"
         },
         submitHandler: function(form, event) {
            event.preventDefault();
            Login.doForgotPassword();
         }
      });

      $("#change-form").validate({
         rules: {
            password: "required"
         },
         submitHandler: function(form, event) {
            event.preventDefault();
            Login.doChangePassword();
         }
      });
   }

   static doLogin () {
      $("#login-link").prop('disabled', true);
      RestClient.post("api/login", Utility.jsonizeForm("#login-form"), function (data) {
         window.localStorage.setItem("token", data.token);
         window.location = "index.html";
      }, function(jqXHR, textStatus, errorThrown){
         $("#login-link").prop('disabled', false);
         toastr.error(jqXHR.responseJSON.message);
      })
   };

   static doRegister () { 
      $("#register-link").prop('disabled', true)
      RestClient.post("api/register", Utility.jsonizeForm("#register-form"), function(data){
         $("#register-form-container").hide();
         $("#form-alert").show().html(data.message);
      }, function(jqXHR, textStatus, errorThrown){
         $("#register-link").prop('disabled',false);
         toastr.error(jqXHR.responseJSON.message);
      });
   }

   static doForgotPassword() { 
      $("#forgot-link").prop('disabled', true);
      RestClient.post("api/forgot", Utility.jsonizeForm("#forgot-form"), function(data) {
         $("#forgot-form-container").hide();
         $("#form-alert").show().html(data.message);
      }, function(jqXHR, textStatus, errorThrown){
         $("#forgot-link").prop('disabled',false);
         $("#forgot-form-container").addClass("hidden");
         toastr.error(jqXHR.responseJSON.message);
      });
   }

   static doChangePassword() { 
      $("#change-link").prop('disabled', true);
      RestClient.post("api/reset", Utility.jsonizeForm("#change-form"), function(data) {
         window.localStorage.setItem("token", data.token);
         window.location = "index.html";
      }, function(jqXHR, textStatus, errorThrown){
         $("#change-link").prop('disabled',false);
         toastr.error(jqXHR.responseJSON.message);
      });
   }   

   static showChangePasswordForm () {
      $("#change-form-container").show();
      $("#forgot-form-container").hide();
      $("#login-form-container").hide();
      $("#register-form-container").hide();
   }

   static showRegisterForm () {
      $("#forgot-form-container").hide();
      $("#login-form-container").hide();
      $("#register-form-container").show();
      $(".search-vin-box").hide();
   }

   static showLoginForm () {
      $("#forgot-form-container").hide();
      $("#register-form-container").hide();
      $("#login-form-container").show();
      $(".search-vin-box").show();
   }

   static showForgotForm () {
      $("#login-form-container").hide();
      $("#forgot-form-container").show();
      $(".search-vin-box").hide();
   }

   static displayCar () {
      $("#cars-insert").empty();
      const carData = Utility.jsonizeForm("#search-vin-form");
      RestClient.get('api/car/' + carData.vin, function(data) {
         if ( !jQuery.isEmptyObject(data) ) {
            $("#get-car-from-vin-modal").modal("show");
            let html = "";
            html += `<div class="card text-center">
                        <div class="card-body">
                           <h5 class="card-title">${data.model_name}</h5>
                           <p class="card-text">Procution year: ${data.year_of_production} <br> Mileage: ${data.mileage} <br> Doors: ${data.num_of_doors} <br> Fuel: ${data.fuel} <br> Engine power (kw): ${data.engine_power_kw} <br> Manufacturer: ${data.manufacturer}</p>
                        </div>
                        <div class="card-footer text-muted">
                           VIN: ${data.vin}
                        </div>
                     </div>`;
            $("#cars-insert").append(html);
         } else {
            toastr.error("No car with this VIN has been found!");
         }}
      )
   }
}