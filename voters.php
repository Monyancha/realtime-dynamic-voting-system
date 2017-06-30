<?php
require('api/config.php');
?>

<!DOCTYPE html>
<html>
  <head>
    <?php
    require('api/head.php');
    ?>
  </head>
  <body>
    <?php
    require('api/navigation.php');
    ?>

    <div class="container">
      <div class="row">
        <div class="col s12 m6">
          <div class="card">
            <div class="card-content">
              <div class="row">
                <input type="text" id="students_search" placeholder="Search student name">
              </div>
              <div class="row">
                <select class="browser-default" name="selected_course" id="select_courses">
                  <option value="ALL" selected>ALL</option>
                </select>
              </div>
              <div class="row">
                <p>
                  <input id="option_all" class="with-gap" name="voted" value="0" type="radio" checked/>
                  <label for="option_all">All</label>
                  <input id="option_na" class="with-gap" name="voted" value="1" type="radio"/>
                  <label for="option_na">N/A</label>
                  <input id="option_voted" class="with-gap" name="voted" value="2" type="radio"/>
                  <label for="option_voted">Voted</label>
                </p>

              </div>
            </div>
          </div>
        </div>
        <div class="col s12 m6">
           <div class="card">
            <div class="card-content">
                <form id="frm_csv_upload">
                  <label for="input_file">Upload new list of students in csv format.</label>
                  <input id="input_file" type="file" name="csv_upload" accept=".csv">
                </form>
            </div>
          </div>
          
          <div class="card">
            <div class="card-content">

              <button id="btn_reset" class="col s12 btn btn-large waves-effect red"><i class="material-icons">warning</i> Reset all data</button>
              <div class="row"></div>
            </div>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-content">
          <div id="students_list">
            <table class="bordered highlight">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Student ID</th>
                  <th>Name</th>
                  <th>Course</th>
                  <th>Level</th>
                  <th>Vote Status</th>
                </tr>
              </thead>
              <tbody id="table_content"></tbody>
            </table>
          </div>

        </div>
      </div>
    </div>

    <?php require('api/script.php'); ?>
    <script src="js/voters.js"></script>
  </body>
</html>
