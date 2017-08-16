const WebSocket = require('ws');
const wss = new WebSocket.Server({
    port: 8080
});

function conn(){
    var mysql = require('mysql');
    var con = mysql.createConnection({
        host: 'localhost',
        user: 'root',
        password: '',
        database: 'db_dvsv2'
    });

    con.connect(function(err){
        if(err){
            client.send({
                status: false,
                data: "Unable to connect to mysql database."
            });
        }
    });

    return con;
}


wss.on('connection', function(ws){
    ws.on('message', function incoming(message){
        console.log('received: %s', message);
        var status = false;
        var data = [];

        //Broadcast data
        wss.clients.forEach(function(client){
            if(client.readyState === WebSocket.OPEN){
                //fetch votes result
                conn().query("SELECT tbl_candidates.student_id, tbl_positions.pos_max_vote, tbl_accounts.fld_name, tbl_positions.pos_name, candidate_image, COUNT(tbl_votes.student_id) AS total_votes FROM tbl_candidates LEFT JOIN tbl_votes ON tbl_candidates.candidate_id = tbl_votes.candidate_id LEFT JOIN tbl_accounts ON tbl_candidates.student_id = tbl_accounts.fld_id LEFT JOIN tbl_positions ON tbl_positions.pos_id = tbl_candidates.position_id GROUP BY tbl_candidates.candidate_id ORDER BY tbl_candidates.position_id, total_votes DESC", function(err, rows, fields){
                    var obj = [];
                    for(var i=0; i < rows.length; i++){
                        obj.push({
                            max_vote: rows[i].pos_max_vote,
                            student_id: rows[i].student_id,
                            student_name: rows[i].fld_name,
                            position_name: rows[i].pos_name,
                            student_image: rows[i].candidate_image,
                            total_votes: rows[i].total_votes
                        });
                    }

                    client.send(JSON.stringify(obj));
                    conn().end();
                });
                
            }
        });
    }) 
});

