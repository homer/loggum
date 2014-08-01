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