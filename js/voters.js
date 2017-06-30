(function(){
  var students = [];
  var courses = [];

  var voters = function(){
    return {
      initialize: function(){
        this.input_file = $('input#input_file');
        this.form_upload = $('form#frm_csv_upload');
        this.student_search = $("input#students_search");

        this.bindEvents();
        this.load_students();
      },

      bindEvents: function(){
        $this = this;
        var files;
        var student_course = $("select[name=selected_course]");
        var btn_reset = $('#btn_reset');

        btn_reset.click(function(){
          if(confirm("Are you sure to reset all records?")){
            window.location.replace('api/reset.php');
          }
        });

        function filterStudents(){
          var name = $this.student_search.val();
          var filter_voting = false;

          $("input[name=voted]").each(function(){
            if(this.checked){
              filter_voting = +this.value;
            }
          });

          var filtered = students.filter(function(student){
            if(student_course.val() != student.fld_course && student_course.val() != 'ALL'){
              return false;
            }

            if(filter_voting == 1){
              if(student.fld_voted){
                return false;
              }
            }else if(filter_voting == 2){
              if(!student.fld_voted){
                return false;
              }
            }

            if(!name){
              return true;
            }else{
              name = new RegExp(name, "i");
              if(student.fld_name.match(name)){
                return true;
              }
            }
          });

          voters().render_students(filtered);
        }

        student_course.change(function(){
          filterStudents();
        });

        $("input[name=voted]").change(function(){
          filterStudents();
        });

        this.student_search.keyup(function(){
          filterStudents();
        });

        this.input_file.change(function(e){
          if(!this.files.length) {
            return;
          }

          var file = this.files[0];
          if(file.name.substr(file.name.lastIndexOf('.')+1) != 'csv'){
            Materialize.toast('Selected file is invalid.', 5000);
            return;
          }

          files = e.target.files;
          $('form#frm_csv_upload').submit();

        });

        this.form_upload.submit(function(e){
          e.stopPropagation();
          e.preventDefault();

          var data = new FormData();
          $.each(files, function(key, value){
            data.append(key, value);
          });

          $.ajax({
            url: `${app.domain}upload.php`,
            type: 'POST',
            data: data,
            cache: false,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function(res){
              if(res.status){
                voters().load_students();
              }

              Materialize.toast(res.message, 5000);

            },
            error: function(err){
              Materialize.toast(err.message, 5000);
            }
          });

        });
      },

      load_students: function(){
        $.ajax({
          url: `${app.domain}fetch__students.php`,
          type: 'GET',
          success: function(res){
            students = res;
            voters().render_students(students);
            voters().load_courses();
          },
          error: function(err){
            Materialize.toast('Oops, something went wrong while fetching the list of students.');
            console.log(err);
          },
          dataType: 'json'
        })
      },

      render_students: function(students){
        if(students.length){
          var student_list = ``;
          students.forEach(function(student, i){
            student_list += `<tr>
            <td>${i + 1}</td>
            <td>${student.fld_id}</td>
            <td>${student.fld_name}</td>
            <td>${student.fld_course}</td>
            <td>${student.fld_year_level}</td>
            <td>${student.fld_voted || "N/A"}</td>
            </tr>`;
          });
        }else{
          student_list += `<tr><td class="red-text"><h1>No results found in the database.</h1></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          </tr>`;
        }
        $("#table_content").html(student_list);
      },

      load_courses: function(){
        $("select[name=selected_course]>option").each(function(){
          if(this.value != 'ALL'){
            this.remove();
          }
        });

        var course_fragments =``;
        students.forEach(function(student){
          if(courses.indexOf(student.fld_course) < 0){
            courses.push(student.fld_course);
          }
        });

        courses.forEach(function(course){
          course_fragments += `<option value="${course.toUpperCase()}">${course.toUpperCase()}</option>`;
        });

        $("#select_courses").append(course_fragments);
      }

    }
  }

  $(document).ready(function(){
    voters().initialize();
  })

})();


