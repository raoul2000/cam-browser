<?php

require_once('config.php');
$configSms = $config['service-sms'];

if( !isset($_GET['file'])){
  exit(0);
}
$file = strtr($_GET['file'],'..','');
$fileUrl =  $config['baseUrl'] . '/' . $config['folderImg'] . '/' . $file;

//var_dump($fileUrl);

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
             <div class="col-md-12" style="padding-top:10px">
               <a href="<?= $configSms['explorerUrl'] ?>" class="btn btn-primary btn-block">Go To Explorer</a>
               <hr/>
               <img id="img-fullscreen" src="<?= $fileUrl ?>" class="img-responsive">
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
