<!DOCTYPE html>
<html>
  <head>
    <title>Products Analytics Report</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="/css/bootstrap.min.css" rel="stylesheet" media="screen">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="../../assets/js/html5shiv.js"></script>
      <script src="../../assets/js/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
     <header style="height:100px">
        </header>
    <div class="container">
            @yield('contents')
        </div>
        <footer style="height:100px">
        </footer>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="//code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/js/bootstrap.min.js"></script>
    <script src="js/jquery.tablesorter.min.js"></script>
  <link rel="stylesheet" type="text/css" href="css/jquery.tablesorter.css">
  <script>
    $(document).ready(function() 
        { 
            $(".table-sort").tablesorter(); 
        } 
    ); 
</script>
  </body>
</html>