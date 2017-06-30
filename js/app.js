var app = {
  initialize: function(){
    this.sideNav.initialize();
  },

  domain: `http://${window.location.host}/api/`,
  sideNav: {
    initialize: function(){
      $('.button-collapse').sideNav({
        menuWidth: 300,
        edge: 'left',
        closeOnClick: true
      });
    }
  },

  logout: function(){
    if(confirm("Are you sure to logout?")){
      delete sessionStorage.DVSV2;
      window.location = "logout.php";
    }
  }
}

app.initialize();
