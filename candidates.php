<?php require('api/config.php'); ?>
<!DOCTYPE html>
<html>
  <head>
    <?php require('api/head.php'); ?>
  </head>
  <body>
    <?php require('api/navigation.php'); ?>
      <div class="">
        
        <div class="row">
          <div class="col s12 m4 row">
            <div class="card col s12">
              <div class="card-content">
              <form id="frm_position">
                  <input type="text" name="position_name" placeholder="Enter position name">
              </form>

                <ul class="collection" id="positions_list"></ul>
              </div>
            </div>
          </div>

          <div class="col s12 m8" id="position_config">
            <div class="card">
              <div class="card-content">

                <div class="row">
                  <div class="col s12 m5">
                    <span class="blue-grey-text text-darken-2">
                     <i class="material-icons medium left">perm_identity</i>
                      <p class="bold" style="margin-top: 8px;" id="pos_name">Position Name</p>
                      <button class="btn red waves-effect" id="pos_remove">Remove</button>
                    </span>
                  </div>
                  <div class="col s12 m5">
                    <small>Who can vote on this position?</small>
                    <select class="browser-default" name="pos_level" id="pos_level"></select>
                  </div>

                  <div class="col s12 m2">
                    <small>Votes No.</small>
                    <input type="number" placeholder="Votes No." name="pos_max_vote" id="pos_max_vote">
                  </div>
                </div>
              </div>
            </div>

            <div class="card">
              <div class="card-content">
                
                <div class="row">
                  <div class="right">
                    <button class="btn btn-large blue-grey" onclick="$('#new_candidate').openModal(); $('#student_details').hide(); $('#candidate-img').attr('src', 'resources/profile.jpg')"><i class="material-icons">add</i>New Candidate</button>

                    <!-- Modal Structure -->
                    <div id="new_candidate" class="modal search white">
                      <div class="modal-content">
                        <h4 class="bold">New Candidate</h4>
                        <input type="text" class="dropdown-button" data-beloworigin="true" placeholder="Search student" id="search_student" data-activates="search_results">
                        <ul id='search_results' class='dropdown-content'></ul>

                        <div id="student_details">
                          <div class="row">
                            <div class="col s12 m4">
                              <img id="candidate-img" src="resources/profile.jpg" class="grey lighten-3" style="width: 100%; cursor: pointer" alt="">
                              <input type="file" hidden name="upload-image">
                            </div>
                            <div class="col s12 m8">
                              <ul class="collection">
                                <li class="collection-item" id="fld_name">N/A</li>
                                <li class="collection-item" id="fld_id">N/A</li>
                                <li class="collection-item" id="fld_course">N/A</li>
                                <li class="collection-item" id="fld_year_level">N/A</li>
                              </ul>
                              <div class="right">
                                <button id="btn_cancel" class="btn right waves-effect btn-large grey">Cancel</button>
                                <button id="btn_save" class="btn right green waves-effect btn-large" style="margin-right: 10px;">Save</button>
                              </div>
                            </div>
                          </div>
                        <div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div id="candidates" class="row"></div>

          </div>
        </div>
      </div>

    <?php require('api/script.php'); ?>
    <script src="js/candidates.js"></script>
  </body>
</html>
