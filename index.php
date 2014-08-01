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

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
    table{
      margin-top: 20px;
    }
    </style>
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
    <script>
    $(document).ready(function(){
      var pTimer = null;
      var taskDesc,taskStart,taskEnd,taskDuration,percent,taskDurationDay;

      var breakDesc       = "Mola zamani";
      var barBreak        = "progress-bar-info";
      var barWork         = "progress-bar-danger";

      // initial configs
      var mode            = "break";
      taskCat             = "Mola";
      taskDesc            = breakDesc;
      var startHr         = 8;
      var endHr           = 19;
      var barType         = barBreak;


      var today           = new Date();
      var startDay        = new Date(today.getFullYear(),today.getMonth(),today.getDate(),startHr,0);
      var startDaySeconds = startDay.getTime();
      var endDay          = new Date(today.getFullYear(),today.getMonth(),today.getDate(),endHr,0);
      var endDaySeconds   = endDay.getTime();
      var dayDuration     = endDaySeconds - startDaySeconds;

      $titleTag    = $("title");
      $progressBar = $("#progressBar");
      $timeStamp   = $("#timeStamp");
      $formInputs  = $("#taskDescForm");
      $taskCat     = $("#taskCategory");
      $taskDesc    = $("#taskDescription");
      $modeHeading = $("#modeHeading");

      taskStart = startDay;

      function findPercentage(duration) {
        return parseFloat(( duration * 100 ) / dayDuration).toFixed(2);
      }
      function prettyPrintDuration(mSeconds){
        var durMinutes = Math.floor( mSeconds/(60*1000) );
        var durSeconds = Math.round( mSeconds/1000 ) - (durMinutes*60);
        return pad(durMinutes,2) + ":" + pad(durSeconds,2);
      }
      function pad(n, width, z) {
        z = z || '0';
        n = n + '';
        return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n;
      }

      function addPercentElem(percent,type,rowType){
        var progressElem = "<div class='progress-bar " + type + "' data-toggle='tooltip' title='Some tooltip text!' style='width: " + percent + "%'>" + percent + "%</div>";
        $progressBar.append(progressElem);

        var tableRow = "<tr class='" + rowType + "'>";
        tableRow += "<td>"+ taskCat +"</td>";
        tableRow += "<td>"+ taskDesc +"</td>";
        tableRow += "<td>"+ pad(taskStart.getHours(),2) + ":" + pad(taskStart.getMinutes(),2) + ":" + pad(taskStart.getSeconds(),2) + "</td>";
        tableRow += "<td>"+ pad(taskEnd.getHours(),2) + ":" + pad(taskEnd.getMinutes(),2)+ ":" + pad(taskEnd.getSeconds(),2) +"</td>";
        tableRow += "<td>"+ pad(taskDurationDay.getUTCHours(),2) + ":" + pad(taskDurationDay.getUTCMinutes(),2) + ":" +  pad(taskDurationDay.getUTCSeconds(),2) + "</td>";
        tableRow += "<td>%"+ percent +"</td>";
        tableRow += "</tr>";

        $("#logTable").append(tableRow);
      }

      function startTimer(){
        if(pTimer) { killTimer(pTimer) };
        $titleTag.html(mode + " - 00:00");

        var startMark = new Date();
        startMark = startMark.getTime();
        var endMark = startMark;

        pTimer = setInterval(function(){
          endMark = new Date();
          endMark = endMark.getTime();
          var durationText = prettyPrintDuration(endMark - startMark);
          $titleTag.html(mode + " - " + durationText);
        },1000);
      }
      function killTimer(intervalVariable){
        clearInterval(intervalVariable);
      }

      $timeStamp.on("click",function(){
        // set time
        taskEnd      = new Date();
        taskDuration = taskEnd - taskStart;
        taskDurationDay = new Date(taskDuration);

        percent = findPercentage(taskDuration);

        // draw elements
        if (mode == "break") {
          taskCat  = "Mola";
          taskDesc = breakDesc;
          addPercentElem(percent,barBreak,"info");

          mode = "work";
          $modeHeading.html("Calisma");

          // textinputu goster
          $taskDesc.val("");
          $taskDesc.focus();
          $formInputs.attr("class","show");
        } else {
          taskCat = $taskCat.val();
          taskDesc = $taskDesc.val();
          addPercentElem(percent,barWork,"danger");

          mode = "break";
          $modeHeading.html("Mola");

          // textinputu kaldir
          taskDesc = breakDesc;
          $formInputs.attr("class","hidden");
        }
        taskStart = taskEnd;
        startTimer();
      });


    }());
    </script>
  </body>
</html>