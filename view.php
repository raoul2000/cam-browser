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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
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
                    <hr/>
                </div>
            </div>

            <div id="fullscreen" class="row" style="display:none;">
              <div class="col-md-12">
                <button id="btn-back" type="button" class="btn btn-primary btn-block">Close</button>
                <hr/>
                <img id="img-fullscreen" src="" class="img-responsive">
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <div class="clearfix">

                <div class="btn-toolbar pull-right" role="toolbar" aria-label="...">
                  <div class="btn-group " role="group" aria-label="...">
                    <button  id="btn-back-to-index" type="button" class="btn btn-default">
                      <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Back To Hall
                    </button>
                    <button id="btn-delete-all" type="button" class="btn btn-danger" data-date="<?= $date ?>">
                      <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete All
                    </button>
                  </div>
                </div>
              </div>
              <hr/>
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
                    $encodedFilePath = urlencode(basename($filename));

                    $dateTime = new DateTime('@'.$filemtime);
                    if($config['timezone'] != null){
          						$dateTime->setTimezone(new DateTimeZone($config['timezone']));
          					}
                    $dateFmt = $dateTime->format("D j Y - H:i:s");
                    ?>

                      <div class="col-md-4">
                        <div class="thumbnail">
                          <img src="<?= $fileRelativePath ?>" class="img-responsive clickable">
                          <button  type="button" class="btn btn-default btn-lg btn-delete" data-path="<?= $encodedFilePath ?>"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                          <h4><?= $dateFmt ?></h4>
                        </div>
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

        /**
         * Deletes a single file
         */
        $('.btn-delete').on('click',function(ev){
          var btn = $(ev.target);
          console.log(btn.data('path'));
          if(confirm("Delete this file ? ")) {
            $.getJSON('delete-single-file.php' , { path: btn.data('path')},function(data){
              if(data.error) {
                alert('Error : '+data.message);
              } else {
                btn.closest('.col-md-4').hide('slow');
              }
            });
          }
        });

        /**
         * Delete all files having last modified date equal to the current date being displayed
         */
        $('#btn-delete-all').on('click',function(ev){
          var date = $(ev.target).data('date');
          if( confirm("WARNING : you are about to delete all files for the date '"+date+"'.\nAre you sure ?")){
            $.getJSON('delete-all-files.php' , { "date": date },function(data){
              if(data.error) {
                alert('Error : '+data.message);
              } else {
                btn.closest('.col-md-4').hide('slow');
              }
            });
          }
        });

        /**
         * Navigates to the previous index page
         */
        $('#btn-back-to-index').on('click',function(ev){
          // TODO : implement me !
        });
      })
    </script>
</body>
</html>
