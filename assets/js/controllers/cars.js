class Cars {
   static init () {
      Cars.getCars();
      $("#view-posts-button").click(function () {
         $('#posts-from-car-modal').modal({show : true, backdrop: 'static'});
      });

      $("#collapse-trigger").click(function (e) { 
         e.preventDefault();
         $("#add-car-collapse").collapse('toggle');
      });

      $("#add-car-form").validate({
         rules: {
           model_name: "required",
           year_of_production: "required",
           vin: "required",
           mileage: "required",
           num_of_doors: "required",
           engine_power_kw: "required",
           manufacturer: "required",
           fuel: "required"          
         },
         submitHandler: function(form, event) {
            event.preventDefault();
            const car = Utility.jsonizeForm("#add-car-form");
            console.log(car)
            $('#overlay').fadeIn();
            Cars.addCar(car);
         }
      });

      $("#update-car-form").validate({
      rules: {
         model_name: "required",
         year_of_production: "required",
         vin: "required",
         mileage: "required",
         num_of_doors: "required",
         engine_power_kw: "required",
         manufacturer: "required",
         fuel: "required"          
      },
      submitHandler: function(form, event) {
         event.preventDefault();
         const car = Utility.jsonizeForm("#update-car-form");
         Cars.updateCar(car);
      }
      });
   }

   static updateCar (car) {
      const carId = car['id'];
      delete car['id'];
      RestClient.put('api/car/update/' + carId, car, function (data) {
         toastr.success("Car successfully updated!");
         $("#update-car-form").trigger("reset");
         $('#update-car-modal').modal("hide");
         $("#cars-insert").empty();
         Cars.getCars();
      })
   }

   static addCar (car) {
      RestClient.post("api/cars", car, function (data) {
         toastr.success("New car has been added!");
         $("#add-car-form").trigger("reset");
         $("#cars-insert").empty();
         $('#overlay').fadeOut();
         Cars.getCars();
      })
   }

   static getCars () {
      RestClient.get('api/user/cars', function(data) {
         for (let i = 0; i < data.length; i++) {
            let html = "";
            html += `<div class="card text-center">
                        <div class="card-body">
                        <h5 class="card-title">${data[i].model_name}</h5>
                        <p class="card-text">Procution year: ${data[i].year_of_production} <br> Mileage: ${data[i].mileage} <br> Doors: ${data[i].num_of_doors} <br> Fuel: ${data[i].fuel} <br> Engine power (kw): ${data[i].engine_power_kw} <br> Manufacturer: ${data[i].manufacturer}</p>
                        <li class="list-inline-item mt-2">
                           <button type="button" data-toggle="modal" id="view-posts-button" onclick="Cars.openModalShowPosts(${data[i].id})" class="btn btn-info btn-sm rounded-0"><i class="fa fa-arrows-alt fa-lg"></i></button>
                        </li>
                        <li class="list-inline-item mt-2">
                           <button class="btn btn-success btn-sm rounded-0" type="button" data-placement="top" title="Edit" onclick="Cars.preEditModal(${data[i].id})"><i class="fa fa-edit fa-lg"></i></button>
                        </li>
                        </div>
                        <div class="card-footer text-muted">
                           VIN: ${data[i].vin}
                        </div>
                     </div>`;
            $("#cars-insert").append(html);
         }
      });
   }

   static openModalShowPosts (carId) {
      $("#posts-from-car-modal").modal('show');
      $('#overlay').fadeIn();
      Cars.getPostsFromCar(carId);
   }

   static getPostsFromCar (carId) {
      RestClient.get('api/car/posts/' + carId, function (data) {
         console.log(data);
         $('#overlay').fadeOut();
         if (!jQuery.isEmptyObject(data)) {
            for (let i = 0; i < data.length; i++) {
               let html = "";
               html = `<div class="card">
                        <div class="card-body">
                           <p class="card-text mt-4"> ${data[i].body} </p>
                           <p class="card-text">
                              <small class="text-muted">Post created at:  ${data[i].created_at} </small>
                           </p>
                           <img id="image" class="card-img-bottom mb-2" src="${data[i].image_url}" alt="Card image cap">
                        </div>
                     </div>`;
               $("#insert-posts-from-car").append(html);
            }
         } else {
            $("#insert-posts-from-car").append(`<div class="card">
                                                   <div class="card-body">
                                                      <p class="card-text mt-2"> You don't have any added posts for this car! </p>
                                                   </div>
                                                </div>`);
         }
      });
   }

   static modalClose () {
      $("#insert-posts-from-car").html("");
   }

   static preEditModal (id) {
      $('#overlay').fadeIn();
      RestClient.get("api/car/name/" + id, function (data) {
         Utility.json2form("#update-car-form", data);
         $('#overlay').fadeOut();
         $("#update-car-modal").modal("show");
         $("#update-car-form *[name='id']").val(id);
      })
   }

   static onAddCarBtn () {
      const car = Utility.jsonizeForm("#add-car-form");
      console.log(car)
      $('#overlay').fadeIn();
      Cars.addCar(car);
   }
}