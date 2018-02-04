<?php
$json = file_get_contents('./ping/ping.db');
?><!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
    <style type="text/css">
       html {
        background: url(http://91ef69bade70f992a001-b6054e05bb416c4c4b6f3b0ef3e0f71d.r93.cf3.rackcdn.com/blue-abstract-background-100256300.jpg) no-repeat center center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
      }
      .nanobar {
        width: 100%;
        height: 2px;
        z-index: 9999;
        top:0
      }
      .bar {
        width: 0;
        height: 100%;
        transition: height .3s;
        background:#aaa;
      }
    </style>
    <title id="title">San Luis Control</title>
  </head>

  <body style="background-color:transparent;">
    <div class="container" style="margin-top:50px">
      <div class="row" >
        <div class="col-lg-5 col-lg-offset-3">

          <div class="panel panel-primary">
            <div class="panel-heading"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> San Luis - Control</div>
            <div id="panel-body" class="panel-body">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>composant</th>
                    <th>port</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      <span class="glyphicon glyphicon-camera" aria-hidden="true"></span> Camera</td>
                    <td>8087</td>
                    <td><button id="btn-go-camera" type="button" class="btn btn-default btn-xs btn-block">Aller</button></td>
                  </tr>
                  <tr>
                    <td><span class="glyphicon glyphicon-flash" aria-hidden="true"></span> Jeedom</td>
                    <td>80</td>
                    <td><button id="btn-go-jeedom" type="button" class="btn btn-default btn-xs btn-block">Aller</button></td>
                  </tr>
                </tbody>
              </table>
              <div id="alert" class="alert" role="alert" style="display:none">
                L'adresse IP de <b>Casa San Luis</b> est <span id="ip">00.00.00.00</span>. Dernière mise à jour il y a <span id="last-update">14 minutes</span>.
                <span id="warning"><br/><b>Attention le système est peut-être en détresse !</b></span>
              </div>
              <div>
                <p>Services : <a href="https://uptime.statuscake.com/?TestID=8WJgYpi5NB" target="_blank">Etat Connexion</a>,
                <a href="https://www.noip.com" target="_blank">No-ip</a>,
				        <a href="../explorer" target="_blank">Cam-Gallery</a></p>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script src="js/nanobar.min.js"></script>
    <script>
      function timeAgo(time) {
        var units = [{
          name: "seconde",
          limit: 60,
          in_seconds: 1
        }, {
          name: "minute",
          limit: 3600,
          in_seconds: 60
        }, {
          name: "heure",
          limit: 86400,
          in_seconds: 3600
        }, {
          name: "jour",
          limit: 604800,
          in_seconds: 86400
        }, {
          name: "semaine",
          limit: 2629743,
          in_seconds: 604800
        }, {
          name: "mois",
          limit: 31556926,
          in_seconds: 2629743
        }, {
          name: "année",
          limit: null,
          in_seconds: 31556926
        }];
        var diff = (new Date() - new Date(time * 1000)) / 1000;
        if (diff < 5) return "moins de 5 secondes";

        var i = 0,
          unit;
        while (unit = units[i++]) {
          if (diff < unit.limit || !unit.limit) {
            var diff = Math.floor(diff / unit.in_seconds);
            return diff + " " + unit.name + (diff > 1 ? "s" : "");
          }
        };
      };
      ///////////////////////////////////////////////////////////////////////////////////
      $(document).ready(function() {
        var title = $('#title');
        var nanobar = new Nanobar( {
         "target" : document.getElementById('panel-body')
        });


        var current;
        var max = 100;
        var initial = 0; // need to add seconds to this value every second.

        function update() {
            current = initial; //the value on each function call
            nanobar.go(current);

            if (current >= max) {
              clearInterval(interval);
              window.location.reload(true);
            }
            initial += 1; //choose how fast to the number will grow
          title.text('San Luis Control ('+(100 - current)+' sec. before refresh)');
        };
        var interval = setInterval(update, 1000); //choose how fast to updat



        var sanLuis = JSON.parse('<?php echo $json; ?>');
        $('#ip').text(sanLuis.ip);
        $('#last-update').text(timeAgo(sanLuis.ts));

        var diff = (new Date() - new Date(sanLuis.ts * 1000)) / 1000;

        if( diff > 3600) {
          $('#alert').addClass('alert-danger');
          $('#warning').show();
        } else {
          $('#alert').addClass('alert-success');
          $('#warning').hide();
        }
        $('#alert').show('slow');

        $('#btn-go-camera').on('click', function(ev) {
          window.location.href = "http://" + sanLuis.ip + ":8087";
        });
        $('#btn-go-jeedom').on('click', function(ev) {
          window.location.href = "http://" + sanLuis.ip + ":80";
        });
      });
    </script>
  </body>

  </html>
