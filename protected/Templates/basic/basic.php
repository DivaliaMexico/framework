<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->  
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->  
<!--[if !IE]><!--> <html> <!--<![endif]-->  
    <head>
        <title>Divalia Framework</title>
        
        <meta charset="utf-8">

      <meta name="keyword" content="" />
  		<meta name="description" content="" />
  		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		
		@css
	</head>
	<body>
		<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Divalia Framework</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="<?php echo ($this->route->is() == '/')? 'active':''?>"><a href="{{ $this->url->to('') }}">Home</a></li>
            <li class=""><a target="_blank" href="{{ echo $this->url->baseUrl() }}corlate.php">Corlate</a></li>
            <li class=""><a target="_blank" href="{{ echo $this->url->baseUrl() }}margo.php">Margo</a></li>
            <li class=""><a target="_blank" href="{{ echo $this->url->baseUrl() }}sbadmin.php">SB Admin 2</a></li>
            <li class=""><a target="_blank" href="{{ echo $this->url->baseUrl() }}adminlte.php">AdminLTE</a></li>
            <!-- Add new Menu -->
            <!--
            <li class="<?php echo ($this->route->is() == 'user')? 'active':''?>"><a href="{{ $this->url->to('user') }}">User</a></li>
            -->
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">

        @response

    </div><!-- /.container -->
		

		@js
	</body>
</html>