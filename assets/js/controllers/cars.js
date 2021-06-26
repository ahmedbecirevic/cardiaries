class Cars {
   static init () {
      Cars.getCars();
      $("#view-posts-button").click(function () {
         $('#posts-from-car-modal').modal({show : true, backdrop: 'static'});
      });
   }


   static getCars () {
      RestClient.get('api/user/cars', function(data) {
         console.log(data)
         for (let i = 0; i < data.length; i++) {
            let html = "";
            html += `<div class="card text-center">
                        <div class="card-body">
                        <h5 class="card-title">${data[i].model_name}</h5>
                        <p class="card-text">Procution year: ${data[i].year_of_production} <br> Mileage: ${data[i].mileage} <br> Doors: ${data[i].num_of_doors} <br> Mileage: ${data[i].mileage} <br> Engine power (kw): ${data[i].engine_power_kw} <br> Manufacturer: ${data[i].manufacturer}</p>
                        <button type="button" data-toggle="modal" id="view-posts-button" onclick="Cars.openModalShowPosts(${data[i].id})" class="btn btn-primary">View Posts</button>
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
      });
   }
}