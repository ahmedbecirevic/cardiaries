class Accounts {
   static init(){
      $("#add-account-form").validate({
        submitHandler: function(form, event) {
          event.preventDefault();
          var data = Utility.jsonizeForm($(form));
          if (data.id){
            Accounts.update(data);
          }else{
            Accounts.add(data);
          }
        }
      });
      Accounts.get_all_accounts();
    }


   static get_all_accounts(){
      $("#cars-table").DataTable({
         processing: true,
         serverSide: true,
         bDestroy: true,
         pagingType: "simple",
         preDrawCallback: function( settings ) {
            if (settings.aoData.length < settings._iDisplayLength){
            //disable pagination
            settings._iRecordsTotal=0;
            settings._iRecordsDisplay=0;
            }else{
            //enable pagination
            settings._iRecordsTotal=100000000;
            settings._iRecordsDisplay=1000000000;
            }
         },
         responsive: true,
         language: {
               "zeroRecords": "Nothing found - sorry",
               "info": "Showing page _PAGE_",
               "infoEmpty": "No records available",
               "infoFiltered": ""
         },
         ajax: {
            url: "api/accounts",
            type: "GET",
            beforeSend: function(xhr){
               xhr.setRequestHeader('Authentication', localStorage.getItem("token"));
            },
            dataSrc: function(resp){
               return resp;
            },
            data: function ( d ) {
               d.offset = d.start;
               d.limit = d.length;
               d.search = d.search.value;
               d.order = encodeURIComponent((d.order[0].dir == 'asc' ? "-" : "+") + d.columns[d.order[0].column].data);
               console.log(d);
            }
         },
         columns: [
               { "data": "id",
                  "render": function ( data, type, row, meta ) {
                     return `<div style="min-width: 60px;"> <span class="badge">${data}</span><a class="float-right" style="font-size: 15px; cursor: pointer;" onclick="Accounts.pre_edit(${data})"><i class="fa fa-edit"></i></a> </div>`;
                  }
               },
               { "data": "name"},
               { "data": "status"},
               { "data": "created_at"}
            ]
      });
   }

   static pre_edit(id){
      RestClient.get("api/accounts/" + id, function(data){
         Utility.json2form("#add-account-form", data);
         $("#add-account-modal").modal("show");
      });
   }


   static add(account){
      RestClient.post("api/accounts", account, function(data){
        toastr.success("New account has been created");
        Accounts.get_all_accounts();
        $("#add-account-form").trigger("reset");
        $('#add-account-modal').modal("hide");
      });
    }
  
   static update(account){
      RestClient.put("api/accounts/"+account.id, account, function(data){
        toastr.success("Email Template has been updated");
        Accounts.get_all_accounts();
        $("#add-account-form").trigger("reset");
        $("#add-account-form *[name='id']").val("");
        $('#add-account-modal').modal("hide");
      });
   }

   static showModal () {
      $('#add-account-modal').modal({show : true});
   }
}