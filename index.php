<?php

require_once('lib/browse-folder.php');
require_once('config.php');

// TODO : test configuration is valid

$folder =  $config['baseFolder'] . '/' . $config['folderImg'] . '/' . $config['imageFilePattern'];
$timezone = isset($config['timezone']) && ! empty($config['timezone'])
  ? $config['timezone']
  : null;

$daysImg = getIndexByDay($folder, $timezone );

$folder = __DIR__ . '/' . $config['folderVideo'] . '/' . $config['videoFilePattern'];
$daysVideo = getIndexByDay($folder, $timezone );

// merge image and video arrays
//
$days = $daysImg;
foreach ($daysVideo as $date => $count) {
  if(isset($days[$date])) {
    $days[$date] = $days[$date] . '-' . $count;
  } else {
    $days[$date] = '0-' . $count;
  }
}
foreach ($days as $date => $value) {
  if( is_integer($value)){
    $days[$date] = $days[$date] . '-0';

  }
}
//var_dump($days);

 ?><!DOCTYPE html>
 <html>

 <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
     <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
     <link href="design/style.css" rel="stylesheet" type="text/css">
 </head>

 <body>
     <div class="section">
         <div class="container">
             <div class="row">
                 <div class="col-lg-12">
                     <ul class="breadcrumb lead">
                         <li>
                             <a href="#">Home</a>
                         </li>
                         <li class="active">Hall</li>
                     </ul>
                     <hr/>
                 </div>
             </div>
             <div class="row">
                 <div class="col-md-12">
                     <div class="list-group">
                       <?php
                         if( count($days) == 0 ) {
                           // this should never occur as an empty folder should not be
                           // listed in the image index page
                           echo "<p>no file found</p>";
                         } else {
                           foreach ($days as $date => $countFiles) {
                             list($countImg, $countVideo) = explode('-',$countFiles);

                             $year  = substr($date,0,4);
                             $month = substr($date,4,2);
                             $day   = substr($date,6,2); //day number 01-31

                             $dayHTML = "$year-$month-$day";
                             $dateTime = new DateTime("$year/$month/$day");
                             ?>

                               <a href="view-files.php?date=<?= $date ?>" class="list-group-item">
                                 <!--input class="chk-date" type="checkbox" name="name" value=""-->
                                 <span class="day"> <?= $dayHTML ?></span>
                                 <span class="badge alert-info  day">
                                   <span class="glyphicon glyphicon-picture" aria-hidden="true"></span>
                                   <?= $countImg ?>
                                 </span>
                                 <span class="badge alert-info  day">
                                   <span class="glyphicon glyphicon-film" aria-hidden="true"></span>
                                   <?= $countVideo ?>
                                 </span>
                                 <!--span class="badge alert-warning day">0</span-->
                               </a>

                             <?php
                           }
                         }
                       ?>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <script type="text/javascript">
       $(function() {
         $('.chk-date').on('click',function(ev){
           ev.stopPropagation();
           ev.stopImmediatePropagation();
           return false;
         });
       });
     </script>
 </body>
 </html>
