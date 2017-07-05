<html>
  <head>
    <link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>

    <style>
      body {
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
        color: #B0BEC5;
        display: table;
        font-weight: 100;
        font-family: 'Lato';
      }

      .container {
        text-align: center;
        display: table-cell;
        vertical-align: middle;
      }

      .content {
        text-align: center;
        display: inline-block;
      }

      .title {
        font-size: 36px;
        margin-bottom: 40px;
      }

      .link {
        font-size: 48px;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="content">
        <div class="title">HighSolutions\Laravel-Poster</div>
        <p class="link"><a href="#" onClick="logInWithFacebook()">Extend Facebook Access Token for another 2 months</a></p>
        <p><small>Powered by <a href="https://highsolutions.pl">HighSolutions</a></small></p>
      </div>
    </div>
    <script>
      logInWithFacebook = function() {
        FB.login(function(response) {
          if (response.authResponse) {
            window.location.href = "{{ route('laravel_poster.fb_token_obtained') }}";
          } else {
            alert('User cancelled login or did not fully authorize.');
          }
        });
        return false;
      };
      
      window.fbAsyncInit = function() {
        FB.init({
          appId: '1930445737237719',
          cookie: true,
          version: 'v2.9'
        });
      };

      (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
    </script>
  </body>
</html>