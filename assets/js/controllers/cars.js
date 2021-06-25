class Cars {
   static init () {
      Cars.getCars();
   }


   static getCars () {
      RestClient.get('api/user/cars', function(data) {
         let html = "";
         if (jQuery.isEmptyObject(data)) {
               html += '<h4 class="card-title">You don\'t have any cars</h4>'
         } else {
               for (let i = 0; i < data.length; i++) {
               html += 
                     '<div class="card-body">' + 
                           '<h4 class="card-title">' + data[i].model_name + '</h4>' +
                           '<p class="card-text">' + data[i].year_of_production + '</p>' +
                           '<p class="card-text">' + data[i].mileage + '</p>' +
                     '</div>'
               }
         }
         $("#cars-insert .card-body").html(html)
      })
   }
}