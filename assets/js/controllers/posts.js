class Posts {
   static init () {
      Posts.getPosts();
      Posts.modalEnable();
   }
    
   static getPosts () {
      // $.ajax({
      //    url: 'api/user/posts',
      //    type: 'GET',
      //    beforeSend: function(xhr){xhr.setRequestHeader('Authentication', localStorage.getItem('token'))},
      //    success: function(data) {
      //       console.log(data);
      //       let html = "";
      //       // if (jQuery.isEmptyObject(data)) {
      //       //     html += '<h4 class="card-title">You don\'t have any posts</h4>';
      //       // } else {
      //       for (let i = 0; i < data.length; i++) {
      //          const carId = data[i].car_id;
      //          let postHtml = "";
      //          if (document.getElementById("car" + carId)) { //retrns true if there is elements with such ID
      //             let insertPostSelector = "#post-insert" + carId;
      //             console.log(insertPostSelector);
      //             postHtml += `<p class="card-text"> ${data[i].body} </p><p class="card-text"><small class="text-muted">Post created at:  ${data[i].created_at} </small></p><img id="image" class="card-img-bottom" src="./assets/img/e92m3.jpg" alt="Card image cap">`
      //             $(insertPostSelector).append(postHtml);
      //          } else {
      //             let elementCarId = "car" + carId;
      //             let postId = "post-insert" + carId;
      //             html += `<div class="card mb-4"><div class="card-header"><i class="fas fa-car mr-1"></i><p id="${elementCarId}">${carId}</p> posts!</div><div class="card"><div class="card-body" id="${postId}"><p class="card-text"> ${data[i].body} </p><p class="card-text"><small class="text-muted">Post created at:  ${data[i].created_at} </small></p><img id="image" class="card-img-bottom" src="./assets/img/e92m3.jpg" alt="Card image cap"></div></div></div>`;
      //             $("#posts-group-by-car").append(html);
      //          }
      //       }
      //    }
      // }) 
      RestClient.get('api/user/posts', function(data) {
         console.log(data);
         let html = "";
         // if (jQuery.isEmptyObject(data)) {
         //     html += '<h4 class="card-title">You don\'t have any posts</h4>';
         // } else {
         for (let i = 0; i < data.length; i++) {
            const carId = data[i].car_id;
            let postHtml = "";
            if (document.getElementById("car" + carId)) { //retrns true if there is elements with such ID
               let insertPostSelector = "#post-insert" + carId;
               console.log(insertPostSelector);
               postHtml += `<p class="card-text"> ${data[i].body} </p><p class="card-text"><small class="text-muted">Post created at:  ${data[i].created_at} </small></p><img id="image" class="card-img-bottom" src="./assets/img/e92m3.jpg" alt="Card image cap">`
               $(insertPostSelector).append(postHtml);
            } else {
               let elementCarId = "car" + carId;
               let postId = "post-insert" + carId;
               html += `<div class="card mb-4"><div class="card-header"><i class="fas fa-car mr-1"></i><p id="${elementCarId}">${carId}</p> posts!</div><div class="card"><div class="card-body" id="${postId}"><p class="card-text"> ${data[i].body} </p><p class="card-text"><small class="text-muted">Post created at:  ${data[i].created_at} </small></p><img id="image" class="card-img-bottom" src="./assets/img/e92m3.jpg" alt="Card image cap"></div></div></div>`;
               $("#posts-group-by-car").append(html);
            }
         }
      })
   }

   static file2Base64 (event) {
      console.log(event.files)
      $("#add-post-button").prop('disabled', true);

      const file = event.files[0];
      const reader = new FileReader();
      // Closure to capture the file information.
      reader.onload = (function(theFile) {
         return function(e) {
            // Render thumbnail.
            // $('#upload-img').attr('src',e.target.result); //e.target.result is th base64 encoded picture

            const upload = {
               name: file.name,
               content: e.target.result.split(',')[1]
            };

            RestClient.post('api/upload', upload, function(data) {
               console.log(data);
               $('#upload-img').attr('src',data.url);
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
   }
}