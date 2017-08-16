(function(){
  var candidates = function(){
    var $this = this;
    var positions = []; 

    return {
      initialize: function(){
        $("#position_config").slideUp();
        $this.new_position = $("#frm_position");
        $this.input_position = $("input[name=position_name]");
        $this.positions_list = $("#positions_list");
        this.bindEvents();
      },

      bindEvents: function(){
        var $$this = this;
        this.functions.load_positions();
        this.functions.fetch_course();
        onStudentSearch();

        $("#btn_save").click(function(){

          var frm_data = new FormData();
          frm_data.append('student_id', $('#fld_id').text());
          frm_data.append('position_id', selected_position.substr(3));

          if($('input[type=file]')[0].files.length){
            frm_data.append('candidate_image', $('input[type=file]')[0].files[0]);
          }
          
          $.ajax({
            url: `${app.domain}candidates.php`,
            type: 'POST',
            data: frm_data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(res){
              Materialize.toast(res.message, 5000);
              if(res.status){
                //do something here
                $('.modal').closeModal();
                $$this.functions.fetch_candidates(selected_position);
              }
            },
            error: function(err){
              Materialize.toast("Sorry, something went wrong while adding new candidate.", 5000);
            }
          })

        });

        $('#btn_cancel').click(function(){
          $('.modal').closeModal();
        });

        $('#candidate-img').click(function(){
          $('input[type=file]').click();
          $('input[name=upload-image]').change(function(){
            if(this.files.length){
              var file = this.files[0];
              var reader = new FileReader();
              reader.onload = function(){
                var dataUrl = reader.result;
                var output = $('#candidate-img');
                output.attr('src', dataUrl);
              }

              reader.readAsDataURL(file);
            }

          });
        });

        function onStudentSearch(){

          $('#search_student').keyup(function(){
            var query_string = this.value.trim();

            var delay = setTimeout(function(){
              searchStudent(query_string);
            }, 1000);

            $('#search_student').keydown(function(){
              clearTimeout(delay);
            });

            function searchStudent(query_string){
              if(query_string){
                $.ajax({
                  url: `${app.domain}students.php`,
                  type: 'GET',
                  data: {
                    student_name: query_string
                  },
                  success: function(res){
                    var result_fragments = ``;
                    if(res){
                      res.forEach(function(student){
                        result_fragments += `<li class="search_result" data-info='${JSON.stringify(student)}'><a href="#">${student.fld_name}</a></li>`;
                      });


                      $('#search_results').html(result_fragments);
                      $('#search_results').slideDown();

                      $(".search_result").click(function(){
                        var stud = JSON.parse(this.dataset.info);
                        $('#fld_id').text(stud.fld_id);
                        $('#fld_name').text(stud.fld_name);
                        $('#fld_course').text(stud.fld_course);
                        $('#fld_year_level').text(stud.fld_year_level);
                        $('#student_details').slideDown();
                        $('#search_results').empty();
                      });

                    }else{
                      $('#search_results').slideUp();
                    }
                  },
                  error: function(err){
                    console.log(err);
                    Materialize.toast("Sorry something went wrong while searching the database.", 5000);
                  },
                  dataType: 'json'
                })
              }else{
                $('#search_results').slideUp();
              }
            }

          });


        }

        $this.new_position.submit(this.events.onPositionSubmit);
        $("#pos_remove").click(this.events.onPositionRemove);

        $("select#pos_level").change(function(){
          var selector = `#${selected_position}`;
          var id = JSON.parse($(selector)[0].dataset.detail).pos_id;
          var pos_level = this.value;

          $.ajax({
            url: `${app.domain}position.php?id=${id}&pos_level=${pos_level}`,
            type: 'PUT',
            success: function(res){
              Materialize.toast(res, 5000);
            },
            error: function(err){
              Materialize.toast('Something went wrong while updating the configuration.', 5000);
            },
            dataType: 'json'
          });
        });

        $("input#pos_max_vote").keyup(function(e){
          if(e.keyCode == 13){
            var max_vote = +this.value.trim();
            if(typeof(max_vote) === "number" && max_vote > 0){
              var selector = `#${selected_position}`;
              var id = JSON.parse($(selector)[0].dataset.detail).pos_id;

              $.ajax({
                url: `${app.domain}position.php?id=${id}&max_vote=${max_vote}`,
                type: 'PUT',
                success: function(res){
                  Materialize.toast(res, 5000);
                },
                error: function(err){
                  Materialize.toast('Something went wrong while updating the configuration.', 5000);
                },
                dataType: 'json'
              })
            }else{
              var x = Materialize.toast("Please check the number of votes, must be > 0", 5000);
            }

          }

        });

        function update_config(pos_level, max_vote){

        }
      },

      events: {
        onPositionRemove: function(){

          if(confirm("Are you sure to remove this position and its candidates?")){
            var selector = "#" + selected_position;
            var id = JSON.parse($(selector)[0].dataset.detail).pos_id;

            $.ajax({
              url: `${app.domain}position.php?id=${id}`,
              type: 'DELETE',
              success: function(res){
                if(res){
                  Materialize.toast("Successfully removed.", 5000);
                  candidates().functions.fetch_course();
                  $(selector).remove();
                  $("#position_config").slideUp();

                  selector = undefined;
                  $("li.position").each(function(){
                    selector = "#" + this.id;
                  });
                  if(selector){
                    $(selector).click();
                  }else{
                    var positions_fragment = `<p class="grey-text center" style="padding: 20px;">No added candidates.</p>`;
                    $this.positions_list.html(positions_fragment);
                  }

                }else{
                  Materialize.toast("Oops, something went wrong while removing the position.", 5000);
                }
              },
              error: function(err){
                Materialize.toast("Sorry, something went wrong.", 5000);
              },
              dataType: 'json'
            })
          }
        },

        onPositionSubmit: function(e){
          e.stopPropagation();
          e.preventDefault();
          var position_name = $this.input_position.val().trim();

          if(position_name){
            $.ajax({
              url: `${app.domain}position.php`,
              type: 'POST',
              data: {
                position_name: position_name
              },
              dataType: 'json',
              success: function(res){
                $this.input_position.val('');
                candidates().functions.load_positions();
                $("#position_config").slideUp();
              },
              error: function(err){
                Materialize.toast("Sorry, something went wrong.", 5000);
              }
            })
          }
        }

      },

      functions: {
        fetch_candidates: function(selected_position){
          $.ajax({
            url: `${app.domain}candidates.php`,
            type: 'GET',
            data: {
              position_id: selected_position.substr(3)
            },
            success: function(res){
              if(res.status){
                var candidates_fragment = ``;
                res.message.forEach(function(candidate){
                  if(!candidate.candidate_image){
                    candidate.candidate_image = `resources/profile.jpg`;
                  }
                  candidates_fragment += `<div id="candidate_${candidate.candidate_id}" class="col s12 m4 candidate" data-id="${candidate.student_id}" style="cursor: pointer">
                    <div class="card">
                      <div class="card-content grey lighten-4">
                        <img src="${candidate.candidate_image}" style="width: 100%;" />
                        
                        <p class="center">  
                          <small class="blue-grey-text">${candidate.fld_name}</small>
                          <button class="btn red remove_candidate" data-id="${candidate.candidate_id}">Remove</button>
                        </p>
                      </div>
                    </div>
                  </div>`;
                });

              }else{
                candidates_fragment = `<h2 class="center grey-text bold">No candidates found in this position.</h2>`;
              }

              $('#candidates').html(candidates_fragment);
              
              $('.remove_candidate').click(function(){
                var candidate_id = this.dataset.id;
                var selector = `#candidate_${candidate_id}`;

                $.ajax({
                  url: `${app.domain}candidates.php?c_id=${candidate_id}`,
                  type: 'DELETE',
                  success: function(res){
                    Materialize.toast(res.message, 5000);
                    if(res.status){
                      $(selector).remove();
                      if(!$('.candidate').length){
                        candidates_fragment = `<h2 class="center grey-text bold">No candidates found in this position.</h2>`;
                        $('#candidates').html(candidates_fragment);
                      }
                    }
                  },
                  error: function(err){
                    Materialize.toast("Sorry, something went wrong while removing the student.", 5000);
                    console.log(err);
                  },
                  dataType: 'json'
                })
                
              });
              
            },
            error: function(err){
              console.log(err);
              Materialize.toast("Sorry, something went wrong while fetching candidates.", 5000);
            },
            dataType: 'json'
          })
        },

        load_positions: function(){

          $.ajax({
            url: `${app.domain}position.php`,
            type: 'GET',
            success: function(res){
              var positions_fragment = ``;
              var last_insert = "";
              if(res){
                res.forEach(function(pos){
                  positions_fragment += `<li id="pos${pos.pos_id}" data-detail='${JSON.stringify(pos)}' class=" collection-item blue-grey-text text-darken-2 waves-effect bold position">${pos.pos_name}</li>`;
                  last_insert = "#pos" + pos.pos_id;
                });
                positions = res;

              }else{
                positions_fragment = `<p class="grey-text center" style="padding: 20px;">No added candidates.</p>`;
              }

              $this.positions_list.html(positions_fragment);

              $(".position").click(function(){
                var $this = this;
                selected_position = this.id;
                candidates().functions.fetch_candidates(selected_position);

                $("#position_config").slideUp(function(){
                  var pos = JSON.parse($this.dataset.detail);

                  $("#pos_level").val(pos.pos_level_vote);
                  $("#pos_name").text(pos.pos_name);
                  $("input[name=pos_max_vote]").val(pos.pos_max_vote);
                  $("#position_config").slideDown();
                });
              });

              $(last_insert).click();
            },
            error: function(err){
              Materialize.toast("Sorry, something went wrong.", 5000);
              console.log(err);
            },
            dataType: 'json'
          })
        },

        fetch_course: function(){
          $.ajax({
            url: `${app.domain}fetch_courses.php`,
            type: 'GET',
            success: function(res){
              console.log(res);
              var courseFragments = `<option class="course_option" value="ALL">ALL</option>`;
              res.forEach(function(course){
                courseFragments += `<option class="course_option" value="${course.fld_course}">${course.fld_course}</option>`;
              });

              $("#pos_level").html(courseFragments);
            },
            error: function(err){
              console.log(err);
            },
            dataType: 'json'
          })
        }
      }

    }
  }

  $(document).ready(function(){
    candidates().initialize();
  })
})();
