class Posts {
   static init () {
      Posts.getPosts();
      Posts.modalEnable();

      $("#add-post-form").validate({
         submitHandler: function(form, event) {
            event.preventDefault();
            const data = Utility.jsonizeForm($(form));
            console.log(data);
            if (data.id){
               Posts.updatePost(data);
            }else{
               Posts.addPost(data);
            }
         },
         ignore: "",
         rules: {
            body: "required",
            image_url: "required"
         }
      });
   }
    
   static getPosts () {
      RestClient.get('api/user/posts', function(data) {
         console.log(data);
         $("#posts-group-by-car").empty();
         for (let i = 0; i < data.length; i++) {
            const carId = data[i].car_id;
            let html = "";
            let postHtml = "";
            if (document.getElementById("car" + carId)) { //retrns true if there is elements with such ID which means that we already have inserted other posts for this car
               let insertPostSelector = "#post-insert" + carId;
               postHtml += `<button id="edit-post-button" onclick="Posts.pre_edit(${data[i].id})" class="btn btn-light float-right my-3"><span>Edit Post</span></button> <p class="card-text mt-4"> ${data[i].body} </p><p class="card-text"><small class="text-muted">Post created at:  ${data[i].created_at} </small></p><img id="image" class="card-img-bottom mb-2" src="${data[i].image_url}" alt="Card image cap"><hr>`
               $(insertPostSelector).append(postHtml);
            } else {
               // this case handles inserting the post which is the first for the car that it belongs to
               let elementCarId = "car" + carId;
               let postId = "post-insert" + carId;
               html += `<div class="card mb-4">
                           <div class="card-header">
                              <p id="${elementCarId}"><i class="fas fa-car mr-1"></i>${carId} posts!</p>
                           </div>
                           <div class="card">
                              <div class="card-body" id="${postId}">
                                 <button id="add-post-modal-launch" onclick="Posts.preEditCarIdToPost(${data[i].car_id})" class="btn btn-info my-3" aria-hidden="true" data-bs-toggle="modal" data-bs-target="#addPostModal">Add Post</button>
                                 <hr>
                                 <button id="edit-post-button" onclick="Posts.pre_edit(${data[i].id})" class="btn btn-light float-right my-3"><span>Edit Post</span></button>
                                 <p class="card-text mt-4"> ${data[i].body} </p>
                                 <p class="card-text">
                                 <small class="text-muted">Post created at:  ${data[i].created_at} </small>
                                 </p>
                                 <img id="image" class="card-img-bottom mb-2" src="${data[i].image_url}" alt="Card image cap">
                                 <hr>
                              </div>
                           </div>
                        </div>`;
               $("#posts-group-by-car").append(html);
            }
         }
      })
   }

   static updatePost (post) {
      const postId = post['id'];
      delete post['car_id'];
      delete post['id'];
      RestClient.put('api/posts/' + postId, post, function (data) {
         toastr.success("Post successfully updated!");
         $("#add-post-form").trigger("reset");
         $('#addPostModal').modal("hide");
         Posts.getPosts();
      })
   }

   static pre_edit (id) {
      $('#overlay-loading').fadeIn();
      $("#edit-post-button").prop('disabled', true);
      RestClient.get("api/posts/" + id, function (data) {
         $("#edit-post-button").prop('disabled', false);
         $('#overlay-loading').fadeOut();
         console.log(data);
         Utility.json2form("#add-post-form", data);
         $("#addPostModal").modal("show");
         $("#add-post-form *[name='id']").val(id);
         $('#upload-img').attr('src', data.image_url);
      })
   }

   static addPost (post) {
      $("#add-post-button").prop('disabled', true);
      const carId = post['car_id'];
      delete post['car_id'];
      delete post['id'];
      $('#overlay').fadeIn();
      RestClient.post("api/user/car/posts/" + carId, post, function (data) {
         $("#add-post-button").prop('disabled', false);
         $('#overlay').fadeOut();
         toastr.success("New post has been added!");
         $("#add-post-form").trigger("reset");
         $('#addPostModal').modal("hide");
         Posts.getPosts();
      })
   }

   static preEditCarIdToPost (carId) {
      $("#add-post-button").prop('disabled', true);
      $("#add-post-form *[name='car_id']").val(carId);
      $("#addPostModal").modal("show");
      $("#upload-img").hide();
   }

   static file2Base64 (event) {
      console.log(event.files)
      $("#add-post-button").prop('disabled', true);
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
               $('#upload-img').attr('src',data.url);
               $("#upload-img").show();
               $("#add-post-form *[name='image_url']").val(data.url);
               toastr.success("Image uploaded!");
               $("#add-post-button").prop('disabled', false);
            })                     
         }
      })(file);
      // Read in the image file as a data URL.
      reader.readAsDataURL(file);
   }

   static validatePost () {
      'use strict'
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.querySelectorAll('.needs-validation')

      // Loop over them and prevent submission
      Array.prototype.slice.call(forms)
         .forEach(function (form) {
         form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
            }

            form.classList.add('was-validated')
         }, false)
         })
   }

   // modal does not work without this onclick function
   static modalEnable () {
      $('#add-post-modal-launch').click(function () {
         $('#addPostModal').modal({show : true});
      });

      $("#reset-form-modal").click(Posts.clearModalForm);
      $("#x-reset-form-modal").click(Posts.clearModalForm);
   }

   static clearModalForm () {
      $("#upload-img").show();
      $("#add-post-form").trigger("reset");
      $('#upload-img').attr('src', '');
   }
}