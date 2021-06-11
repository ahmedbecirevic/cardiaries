function jsonizeForm (selector) {
   const data = $(selector).serializeArray();
   const formData = {};

   for (let i = 0; i < data.length; i++) {
      formData[data[i].name] = data[i].value;
   }
   return formData;
}