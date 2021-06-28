class Profile {
   static init () {
      Profile.getUser();
   }

   static getUser () {
      RestClient.get('api/user/info', function(data) {
         let html = "";
         html += `<div class="card text-center mt-2">
                     <div class="card-body">
                     <h5 class="card-title"><b>${data.username}</b></h5>
                     <hr>
                     <p class="card-text"> First Name:&nbsp;&nbsp; <b>${data.first_name}</b> <br>Last Name:&nbsp;&nbsp; <b> ${data.last_name} </b> <br> Email:&nbsp;&nbsp; <b> ${data.email} </b><br> Account creation time:&nbsp;&nbsp; <b> ${data.created_at} </b></p>
                     </div>
                     <div class="card-footer text-muted">
                        ID:  ${data.id}
                     </div>
                  </div>`;
         $("#user-info-insert").append(html);
      });
   }
}