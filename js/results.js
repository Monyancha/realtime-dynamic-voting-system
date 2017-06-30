(function(){

    var results = function(){
        return {
            initialize: function(){
                this.connect();
                this.results_container = $('#realtime_results');
                this.btn_print = $('#btn_print');
            },

            checkifcounted: function(index){
                if(index <= 0){
                    return 'grey';
                }else{
                    return 'red';
                }
            },

            load_data: function(data){
                var positions_data = {};
                $this = this;

                var results = JSON.parse(data);
                var result_fragments = ``;
                var percentage = 0;
                var total_per_position = [];
                
                results.forEach(function(c){
                    if(!total_per_position[c.position_name]){
                        total_per_position[c.position_name] = +c.total_votes;
                    }else{
                        total_per_position[c.position_name] += +c.total_votes; 
                    }
                });


                for(i=0; i < results.length; i++){
                    c= results[i];
                    percentage = (+c.total_votes / +total_per_position[c.position_name]) * 100;
                    if(isNaN(percentage)){
                        percentage = 0;
                    }

                    if(!positions_data.hasOwnProperty(c.position_name)){
                        positions_data[c.position_name] = +c.max_vote;
                    }

                    result_fragments += `
                    <div class="card">
                        <div class="${$this.checkifcounted(positions_data[c.position_name])} avatar card-content white-text">
                            <div class="row">
                                <div class="col m2 s4">
                                    <img src="${c.student_image || 'resources/profile.jpg'}" alt="" class="" style="width: 100%">    
                                </div>
                                <div class="col m10 s8">
                                    <span class="bold">${c.student_name}</span>
                                    <br>
                                    <small>Position: ${c.position_name}</small>
                                    <br>
                                    <small>Total Votes: ${c.total_votes} vote(s)</small>

                                    <div class="progress" style="height: 22px;">
                                        <div class="determinate blue darken-2" style="width: ${percentage}%;">
                                            <span class="right"><small>${percentage.toFixed(2)}%&nbsp;</small></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                    `;

                    positions_data[c.position_name] = positions_data[c.position_name] - 1;
                }


                $this.results_container.html(result_fragments);

                $this.btn_print.click(function(){
                    document.body.style.backgroundImage='none';
                    $('nav').hide();
                    $('#btn_print').hide();
                    if(window.print() || !window.print()){
                        location.reload();
                    }
                });
            },

            connect: function(){
                $this = this;

                var conn = new WebSocket('ws://127.0.0.1:8080');
                conn.onopen = function(){
                    conn.onmessage = function(e){
                        $this.load_data(e.data);                    
                    }
                    conn.send("Fetch Initial Data");
                }

                conn.onerror = function(err){
                    console.log('Error: ' + err)
                }

            }
        }
    }

    $(document).ready(function(){
        results().initialize();

    });

})();