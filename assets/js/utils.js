function jsonizeForm (selector) {
   const data = $(selector).serializeArray();
   const formData = {};

   for (let i = 0; i < data.length; i++) {
      formData[data[i].name] = data[i].value;
   }
   return formData;
}

function json2form(selector, data){
   for (const attr in data){
     $(selector+" *[name='"+attr+"']").val(data[attr]);
   }
 }

 function parse_jwt(token) {
     var base64Url = token.split('.')[1];
     var base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
     var jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
         return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
     }).join(''));
     return JSON.parse(jsonPayload);
 }

 function role_based_elements(){
   var user_info = parse_jwt(window.localStorage.getItem("token"));
   if (user_info.r == "USER_READ_ONLY"){
     $(".user-stuff").remove();
   }
   if (user_info.r != "ADMIN"){
     $(".admin-stuff").remove();
   }
 }