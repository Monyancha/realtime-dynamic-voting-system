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
                    <div class="left">
                        <b><span class="material-icons">dashboard</span> Real Time Voting Results</b>
                    </div>
                    <div class="right">
                        <button id="btn_print" class="btn-flat waves-effect white-text blue-grey">
                            <i class="material-icons">print</i>
                        </button>
                    </div>                   
                        <!--<div class="right">
                            <a href="results-public.php" class="orange-text"><i class="material-icons">visibility_off</i> Hide Names</a>
                        </div>-->
                    <div class="row"></div>
                    <div class="divider"></div>

                    <!--<div id="realtime_results"></div>-->
                    <table class="table <bordered></bordered>">
                        <thead>
                            <tr>
                                <th>Level</th>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Total Votes</th>
                            </tr>
                        </thead>
                        <tbody id="realtime_results"></tbody>
                    </table>

                </div>
            </div>
        </div>

        <?php require 'api/script.php' ?>
        <script src="js/results.js"></script>
    </body>
</html>