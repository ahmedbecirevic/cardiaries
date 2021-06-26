class Home {
   static init () {
      Home.getAllPosts();
   }

   static getAllPosts () {
      // jQuery(window).scroll(function(){

      //    var bottom_position = $(document).height() - ($(window).scrollTop() + $(window).height());
      //    var scroll_data = {
      //       action: 'user_scroll',
      //       container_id: container_id
      //    };
         
         RestClient.get('api/user/posts', function (data) {
            let html = "";
            if (jQuery.isEmptyObject(data)) {
               html += '<h4 class="card-title">You don\'t have any posts</h4>';
            } else {
               for (let i = 0; i < data.length; i++) {
                  html += `<div class="card-body"> <h3 class="card-title"> ${data[i].body} </h3> <img id="image" class="card-img-bottom " src="./assets/img/e92m3.jpg" alt="Card image"><p class="card-text float-right"><small class="text-muted">Post created at: ${data[i].created_at} </small></p></div><hr class="solid">`;
               }
            }
            $("#posts-insert").html(html);
         });

      // });

      
   }
}