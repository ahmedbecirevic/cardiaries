class Home {
   static init () {
      Home.getAllPosts();

      $("#add-post-home-form").validate({
         submitHandler: function(form, event) {
            event.preventDefault();
            const post = Utility.jsonizeForm($(form));
            Home.addPostFromHome(post);
         },
         ignore: "",
         rules: {
            body: "required",
            image_url: "required",
            car_id: "required"
         }
      });

      document.getElementById('home-cars-insert').addEventListener('change', function(e) {
         const carId = e.target.options[e.target.selectedIndex].getAttribute('value');
         $("#add-post-home-form *[name='car_id']").val(carId);
      });

      $("#reset-modal-home").click(Home.clearModalForm());
      $("#x-reset-modal-home").click(Home.clearModalForm());
   }

   static getAllPosts () {
      RestClient.get('api/user/posts', function (data) {
         let html = "";
         if (jQuery.isEmptyObject(data)) {
            html += '<h4 class="card-title">You don\'t have any posts</h4>';
         } else {
            for (let i = 0; i < data.length; i++) {
               html += `<div class="card-body"> <label>Post description:</label> <h4 class="card-title"> ${data[i].body} </h4> <img id="image" class="card-img-bottom " src="${data[i].image_url}" alt="Card image"><p class="card-text float-right"><small class="text-muted">Post created at: ${data[i].created_at} </small></p></div><hr class="solid">`;
            }
         }
         $("#posts-insert").html(html);
      });
   }

   static addPostFromHome (post) {
      $("#add-post-button-home").prop('disabled', true);
      const carId = post['car_id'];
      delete post['car_id'];
      $('#overlay').fadeIn();
      RestClient.post("api/user/car/posts/" + carId, post, function (data) {
         $("#add-post-button-home").prop('disabled', false);
         $('#overlay').fadeOut();
         toastr.success("New post has been added!");
         $("#add-post-home-form").trigger("reset");
         Home.clearModalForm();
         $('#addPostModalHome').modal("hide");
         Home.getAllPosts();
         Posts.getPosts();
      })
   }

   static file2Base64Home (event) {
      console.log(event.files)
      $("#add-post-button-home").prop('disabled', true);
      $('#overlay').fadeIn();

      const file = event.files[0];
      const reader = new FileReader();
      // Closure to capture the file information.
      reader.onload = (function(theFile) {
         return function(e) {
            const upload = {
               name: file.name,
               content: e.target.result.split(',')[1]
            };

            RestClient.post('api/upload', upload, function(data) {
               console.log(data);
               $('#overlay').fadeOut();
               $('#upload-img-home').attr('src',data.url);
               $("#upload-img-home").show();
               $("#add-post-home-form *[name='image_url']").val(data.url);
               toastr.success("Image uploaded!");
               $("#add-post-button-home").prop('disabled', false);
            })                     
         }
      })(file);
      // Read in the image file as a data URL.
      reader.readAsDataURL(file);
   }

   static pre_edit_cars () {
      $("#home-cars-insert").empty();
      $('#upload-img-home').attr('src', '');
      $('#post-body-home').val('');
      RestClient.get('api/user/cars', function (data) {
         let html = "<option>Select car</option>";
         for (let i = 0; i < data.length; i++) {
            html += `<option value="${data[i].id}">${data[i].model_name}</option>`
         }
         $('#home-cars-insert').append(html);
         $('#addPostModalHome').modal({show : true});
      });
   }

   static clearModalForm () {
      $("#upload-img-home").show();
      $("#add-post-home-form").trigger("reset");
      $('#upload-img-home').attr('src', '');
   }
}