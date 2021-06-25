class Cars {
   static init () {
      Cars.getCars();
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
                        <a href="#" class="btn btn-primary">View Posts</a>
                        </div>
                        <div class="card-footer text-muted">
                           VIN: ${data[i].vin}
                        </div>
                     </div>`;
            $("#cars-insert").append(html);
         }
      });
   }
}