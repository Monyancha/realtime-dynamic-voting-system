var login = {
  initialize: function(){
    this.form = $("#login-form");
    this.username = $("#username-input");
    this.password = $("#password-input");
    this.passwordContainer = $("#password-container");
    this.accountType = $("input[name=accountType]");


    //Initial Values
    this.selectedAccountType = "student";
    this.passwordContainer.hide();

    this.bindEvents();
  },

  bindEvents: function(){
    //form submit
    this.form.submit(function(e){
      e.preventDefault();
      var data = {
        username: login.username.val(),
        password: login.password.val(),
        accountType: login.selectedAccountType
      };

      $.ajax({
        url: app.domain + "login.php",
        type: "POST",
        data: data,
        success: function(data){
          if(data){
            sessionStorage.DVSV2 = btoa(JSON.stringify(data));
            alert("Welcome " + data.fld_name + "!");
            window.location.reload();
          }else{
            alert("Username and/or password is incorrect.");
          }
        },
        error: function(err){
          alert("Oopps! Something went wrong. Please try again later or contact your administrator.");
        },
        dataType: "json"
      });

    });

    //account type change
    this.accountType.change(function(){
      if(this.id == "student"){
        login.passwordContainer.slideUp();
      }else{
        login.passwordContainer.slideDown("slow");
      }
      login.selectedAccountType = this.id;
    });
  }

}

login.initialize();
