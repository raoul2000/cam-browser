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
            <!-- HEADER -->
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

            <!-- FULLSCREEN IMAGE VIEW -->
            <div id="fullscreen" class="row" style="display:none;">
              <div class="col-md-12">
                <button id="btn-back" type="button" class="btn btn-primary btn-block">Close</button>
                <hr/>
                <img id="img-fullscreen" src="" class="img-responsive">
              </div>
            </div>

            <!-- TOOLBAR -->
            <div id="toolbar" class="row">
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
              <div id="wrap-progress-delete-bar" class="col-lg-12" style="display:none">
                <div class="progress">
                  <div id="progress-delete-bar" class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                    <span id="progress-delete-msg"></span>
                  </div>
                </div>
              </div>
            </div>

            <!-- IMAGE GRID -->
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
                          <button
                            type="button"
                            class="btn btn-default btn-lg btn-delete"
                            data-path="<?= $encodedFilePath ?>">
                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                          </button>
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
          // TODO : when showing fillscreen image, hide the toolbar
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
        var progressBarDeleteWrapper = $('#wrap-progress-delete-bar');
        var progressBarDeleteMsg = $('#progress-delete-msg');
        var progressBar = $('#progress-delete-bar');
        var errorDeleteCount = 0;
        var btnDeleteAll = $('#btn-delete-all');

         function callDeleteSingleFile(path, success, error, finish){
           return function(){

             var defer = $.Deferred();
             $.getJSON('delete-single-file.php' , { "path": path}, function(data){
               if(data.error) {
                 error();
               } else {
                 success();
               }
             })
             .done(function(){
               finish();
               defer.resolve();
             });
             return defer.promise();
           };
         }

        btnDeleteAll.prop('disabled', false);
        btnDeleteAll.on('click',function(ev){
          var date = $(ev.target).data('date');
          if( confirm("WARNING : you are about to delete all files for the date '"+date+"'.\nAre you sure ?")){
            errorDeleteCount = 0;
            progressBarDeleteWrapper.show();
            btnDeleteAll.prop('disabled', true);

            var btnList = $('.btn-delete');
            var base = $.when({});
            btnList.each(function(index, button){
              var thisButton = $(button);
              var path = thisButton.data("path");
              base = base.then(callDeleteSingleFile(
                path,
                function(){
                  thisButton.closest('.col-md-4').hide();
                  var percent = Math.floor(100 * (index+1) / btnList.length);
                  progressBarDeleteMsg.text( ""+percent+"%");
                  progressBar.css("width", percent + "%");
                },
                function(){
                  errorDeleteCount++;
                },
                function(){
                  if(index == btnList.length - 1) {
                    if(errorDeleteCount == 0){
                      $('#grid').hide();
                      progressBarDeleteWrapper.hide();
                      alert('All image have been deleted for this day.');
                      document.location="index.php";
                    } else {
                      btnDeleteAll.prop('disabled', false);
                      setTimeout(function(){
                        progressBarDeleteWrapper.hide();
                        progressBar.css("width", "0px");
                      },500);
                    }
                  }
                }
              ));
            });
          }
        });

        /**
         * Navigates to the previous index page
         */
        $('#btn-back-to-index').on('click',function(ev){
          document.location = "index.php";
        });
      })
    </script>
</body>
</html>
