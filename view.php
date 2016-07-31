<?php

require_once('config.php');

$folder = __DIR__ . '/' . $config['folder'] . '/' . $config['filePattern'];
$timezone = isset($config['timezone']) && ! empty($config['timezone'])
  ? $config['timezone']
  : null;

  if ( isset($_GET['date']) ) {
    $date = $_GET['date'];
  } else if( isset($argv[1]) ){
    $date = $argv[1];
  } else {
    echo "mising date argument";
    exit(1);
  }
  require_once('lib/select-by-day.php');

  $files = getFilesByDay($date , $folder , $timezone);

?><!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <link href="design/style.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div class="section">

        <div class="container">
            <div id="header" class="row">
                <div class="col-md-12">
                    <ul class="breadcrumb lead">
                        <li>
                            <a href="#">Home</a>
                        </li>
                        <li>
                            <a href="index.php">Hall</a>
                        </li>
                        <li class="active"><?= $date ?> <small class="text-muted"><?= count($files) ?> image(s)</small></li>
                    </ul>
                    <hr>
                </div>
            </div>

            <div id="fullscreen" class="row" style="display:none;">
              <div class="col-md-12">
                <button id="btn-back" type="button" class="btn btn-primary btn-block">Close</button>
                <hr/>
                <img id="img-fullscreen" src="" class="img-responsive">
              </div>
            </div>

            <div id="grid" class="row">
              <?php
                if( count($files) === 0) {
                  echo "no image to display";
                } else {
                  foreach ($files as $filename => $filemtime)
                  {
                    $fileRelativePath = $config['folder'] .'/' . basename($filename);
                    $dateTime = new DateTime('@'.$filemtime);
                    if($config['timezone'] != null){
          						$dateTime->setTimezone(new DateTimeZone($config['timezone']));
          					}
                    $dateFmt = $dateTime->format("D j Y - H:i:s");
                    ?>

                      <div class="col-md-4">
                        <img src="<?= $fileRelativePath ?>" class="img-responsive clickable">
                        <h4 class="text-center"><?= $dateFmt ?></h4>
                      </div>

                    <?php
                  }
                }
               ?>
            </div>
        </div>
    </div>
    <script type="text/javascript">
      $(function() {
        $('img.clickable').on('click',function(ev){
          var $img = $(ev.target);
          console.log($img.attr('src'));
          $('#img-fullscreen').attr('src', $img.attr('src'));
          $('#grid').hide();
          $('#fullscreen').show();
        });

        $('#btn-back').on('click',function(ev){
          $('#fullscreen').hide();
          $('#grid').show();
        });
      })
    </script>
</body>
</html>
