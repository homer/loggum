<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
      <link rel="stylesheet" href="styles/main.css"/>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container">
      <h1>Logger</h1>
      <h2>Mode: <span id="modeHeading">Mola</span></h2>

      <div id="progressBar" class="progress"></div>

      <form role="form" id="taskDescForm" class="hidden">
        <div class="form-group">
          <label for="taskCategory">Kategori</label>
          <select id="taskCategory" class="form-control">
            <option value="Software Development">Software Development</option>
            <option value="Toplantı">Toplantı</option>
            <option value="Video Education">Video Education</option>
            <option value="Diğer">Diğer</option>
          </select>
        </div>
        <div class="form-group">
          <label for="taskDescription">Tanım</label>
          <input type="text" id="taskDescription" class="form-control" placeholder="Konu Tanımı">
        </div>
      </form>
      
      <button id="timeStamp" class="btn btn-primary">Make Timestamp</button>  

      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>Kategori</th>
            <th>Açıklama</th>
            <th>Başlangıç</th>
            <th>Bitiş</th>
            <th>Süre</th>
            <th>Yüzde %</th>
          </tr>
        </thead>
        <tbody id="logTable" class="table-hover">
        </tbody>
      </table>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="scripts/logScript.js"></script>
  </body>
</html>