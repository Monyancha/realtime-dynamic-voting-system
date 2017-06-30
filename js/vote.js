(function(){
    var my_votes = {};
    var user = JSON.parse(atob(sessionStorage.DVSV2));
    
    var conn = new WebSocket('ws://127.0.0.1:8080');
    conn.onopen = function(){
        console.log("Connected to Websocket.");
    }

    conn.onerror = function(err){
        console.log('Error: ' + err)
    }

    var vote = function(){
        return {
            initialize: function(){
                var candidates = {
                    fetch: function(){
                        $.ajax({
                            url: `${app.domain}candidates.php`,
                            type: 'GET',
                            success: function(res){
                                var form = $('#candidates');
                                var form_fragment = '';

                                if(res.status){
                                    var position_handler = null;
                                    var index = 0;
                                    res.message.forEach(function(candidate, i) {
                                        if(position_handler != candidate.position_id){
                                            index++; //New Position
                                            my_votes[candidate.position_id] = [];
                                            form_fragment += `<h1 class="bold">${index}. For the ${candidate.pos_name.toUpperCase()} position choose at maximum of ${candidate.pos_max_vote} candidate(s)?</h1>
                                                <div class="row">`;
                                       }

                                       form_fragment += `<div class="col s12 m4">
                                            <img src="${candidate.candidate_image || 'resources/profile.jpg'}" style="width: 100%" alt="">
                                            <div class="divider"></div>
                                            <input type="checkbox">
                                            <p class="center">
                                                <input id="${candidate.student_id}"  type="checkbox" data-position_id="${candidate.position_id}" data-candidate_id="${candidate.candidate_id}" data-max_vote="${candidate.pos_max_vote}" class="candidate filled-in position_${candidate.position_id}" data-position="${candidate.pos_name}" name=""/>
                                                <label for="${candidate.student_id}">${candidate.fld_name}</label>
                                            </p>
                                            <div class="divider"></div>
                                        </div>`;
                                        
                                        position_handler = candidate.position_id;
                                        future_handler = ++i;
                                        if(future_handler == res.message.length){
                                            form_fragment += `</div>`;
                                        }else{
                                            if(position_handler != res.message[future_handler].position_id){
                                                form_fragment += `</div>`;
                                            }
                                        }
                                    });
                                }else{
                                    form_fragment = `<h1 class="center grey-text">Sorry, ${res.message}</h1>`;
                                    $('#btn_submit').remove();
                                }

                                form.html(form_fragment);
                                $('input.candidate').change(candidates.vote);

                            },
                            error: function(err){
                                console.log(err);
                                Materialize.toast("Sorry something wen wrong while fetching the list of candidates.", 5000);
                            },
                            dataType: 'json'
                        })
                    },

                    vote: function(e){
                        var position_id = this.dataset.position_id;
                        var candidate_id = this.dataset.candidate_id;
                        var max_vote = +this.dataset.max_vote;
                        var input = this;

                        if(!user.fld_voted){
                            if(this.checked){
                                if(my_votes[position_id].length){
                                    if(my_votes[position_id].length == max_vote){
                                        Materialize.toast("You've reached the maximum count of vote(s).", 4000);
                                        input.checked = false;
                                        return;
                                    }
                                }

                                my_votes[position_id].push({
                                    candidate_id: candidate_id
                                });
                            }else{
                                my_votes[position_id].forEach(function(candidate, i){
                                    if(candidate.candidate_id == candidate_id){
                                        my_votes[position_id].splice(i, 1);
                                    }
                                });
                            }
                        }else{
                            Materialize.toast("Sorry, you've already submitted your votes.", 4000);
                            if(input.checked){
                                input.checked = false;
                            }else{
                                input.checked = true;
                            }
                            
                        }

                    }
                }

                $('button#btn_submit').click(function(){
                    if(!user.fld_voted){
                        if(confirm_vote = confirm("Are you sure? This can't be undone.")){
                            if(confirm_vote){
                                Materialize.toast("Your vote has been submitted.", 4000);
                                user.fld_voted = true;
                                sessionStorage.DVSV2 = btoa(JSON.stringify(user));
                               
                                $.ajax({
                                    url: `${app.domain}vote.php`,
                                    type: 'POST',
                                    data: my_votes,
                                    success: function(res){
                                        conn.send("Voted");
                                        console.log(res);
                                    },
                                    error: function(err){
                                        Materialize.toast('Sorry, something went wrong while submitting your votes. Contact your administrator.', 4000);
                                        console.log(err);
                                    }
                                })
                            }else{
                                Materialize.toast("Key word did not matched.", 4000);
                            }
                        }else{
                            Materialize.toast("Votes submission canceled.", 4000);
                        }
                    }else{
                        Materialize.toast("Sorry, you've already submitted your votes.", 4000);
                    }
                });
                
                candidates.fetch();
            }
        }
    }

    $(document).ready(function(){
        vote().initialize();
    });
})();

{/*<h1 class="bold">1. For the PRESIDENT position?</h1>

<div class="row">


    <div class="col s12 m4">
        <img src="resources/201310730.jpg" style="width: 100%" alt="">
        <div class="divider"></div>
        <input type="checkbox">
        <p class="center">
            <input type="checkbox" class="filled-in" id="student_id" checked="checked" />
            <label for="student_id">Sammuel Lagat Apa</label>
        </p>
        <div class="divider"></div>
    </div>


</div>*/}