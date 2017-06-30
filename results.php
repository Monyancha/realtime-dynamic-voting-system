<?php
    require('api/config.php');
?>

<html>
    <head>
        <?php require 'api/head.php' ?>
    </head>
    <body>
        <?php require 'api/navigation.php' ?>

        <div class="container">
            <div class="card">
                <div class="card-content">
                    <h1 class="center blue-grey-text bold"><i class="material-icons">settings_input_antenna</i> Real-time Voting Results</h1>
                    
                        <button id="btn_print" class="btn-flat waves-effect white-text blue-grey">
                            <i class="material-icons">print</i>
                        </button>
                        <div class="right">
                            <a href="results-public.php" class="orange-text"><i class="material-icons">visibility_off</i> Hide Names</a>
                        </div>
                    <div class="row"></div>
                    <div class="divider"></div>

                    <div id="realtime_results"></div>

                </div>
            </div>
        </div>

        <?php require 'api/script.php' ?>
        <script src="js/results.js"></script>
    </body>
</html>