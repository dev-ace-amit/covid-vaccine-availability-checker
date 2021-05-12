<!DOCTYPE html>
<html>
<head>
    <title>Checker</title>
    <meta charset="utf-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.0/moment.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
    <script src="https://smtpjs.com/v3/smtp.js"></script>
</head>
<body>
    <style type="text/css">
        /******************
        Defaults
        *******************/
        html, body{
            font-family:Arial, Helvetica, sans-serif;
            background:#cecece;
        }
        body{
            font-size: 62.5%;
        }
        h1, h2, h3, h4{
            font-family:"Palatino Linotype", "Book Antiqua", Palatino, serif;
            padding:1.0rem 3rem;    
        }
        h1{
            font-size: 3.6rem;  
            color:#FC3;
        }
        h2{
            font-size: 2.4rem;
        }
        h3{
            font-size: 1.8rem;
        }
        h4{
            font-size: 1.5rem;
        }
        p, li{
            font-size: 1.5rem;  
            padding: 0.8rem 3rem;
        }

        /******************
        Layout
        *******************/

        .wrapper{
            width:1180px;
            margin:0 auto;
            border:1px solid #333;
        }
        .masthead{
            background: #666;
            color:#fff;
            padding-bottom: 20px;
            border-bottom: 6px solid #333;
        }
        .footer{
            background: #666;
            color:#fff;
            padding-top: 20px;
            border-top: 6px solid #333;
        }

        /******************
            Form
        *******************/

        form{
            max-width: 90%;
        }
        legend{
            
        }
        .formbox{
            clear: both;    
            margin: 1.0rem 0;   
        }
        label{
            width: 15rem;
            text-align:right;
            float:left;
            margin: 0 3rem 0 0 ;
            font-size: 1.2rem;
            padding:0.6rem 0;
            color: #666;
        }
        input, select, textarea{
            text-align:left;    
            font-size: 1.2rem;
            padding: 0.5rem 0.5rem;
            margin: 0;
            color: #333;
        }
        .btn{
            width: auto;
        }
        .narrow{
            width: 4rem;
        }
        .med{
            width: 20rem;
        }
        .wide{
            width: 40rem;
        }
        .x-wide{
            width: 60rem;
        }
        .buttons{
            width: 100%;
            padding:0 0 0 15rem;
        }
        ol{
            height: 400px;
            overflow: auto;
            width: 80%;
            margin-left: 10px;
            width: 40%;
            display: inline-block;
        }
        li p{
            margin: 0;
            padding: 0;
            border: 1px solid gray;
        }
        .outputBox{
            display: none;
        }
        .loader {
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #3498db;
            width: 120px;
            height: 120px;
            -webkit-animation: spin 2s linear infinite; /* Safari */
            animation: spin 2s linear infinite;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -51%);
            display: none;
        }

        /* Safari */
        @-webkit-keyframes spin {
          0% { -webkit-transform: rotate(0deg); }
          100% { -webkit-transform: rotate(360deg); }
        }

        @keyframes spin {
          0% { transform: rotate(0deg); }
          100% { transform: rotate(360deg); }
        }

        table tr, table td{
            font-size: 16px;
        }
    </style>
    <div class="wrapper">
        <header class="masthead">
            <h1>Availability Checker</h1>
        </header>
        <section class="main">
            <p>Please follow the instructions to fill out this form. If there are no instructions then please add some.</p>
            <form>
                <div class="loader"></div>
                <div class="formbox">
                    <label for="pincode">Pincode</label>
                    <input type="text" name="pincode" id="pincode" autocomplete="off" required placeholder="Your pincode" />
                </div>
                <div class="formbox">
                    <label for="date">Date</label>
                    <input type="date" name="date" id="date" autocomplete="off" required />
                </div>
                <div class="formbox">
                    <label for="onlyAvailable">Show Only Available</label>
                    <select name="onlyAvailable" id="onlyAvailable" class="med">
                        <option value="1">Yes</option>
                        <option selected value="0">No</option>
                    </select>
                </div>
                <div class="formbox">
                    <label for="frequency">Refresh Time</label>
                    <select name="frequency" id="frequency" class="med">
                        <option selected value="1">1 Min</option>
                        <option value="5">5 Mins</option>
                        <option value="10">10 Mins</option>
                        <option value="20">20 Mins</option>
                        <option value="30">30 Mins</option>
                    </select>
                </div>
                <div class="formbox">
                    <label for="ageGroup">Agr Group</label>
                    <select name="ageGroup" id="ageGroup" class="med">
                        <option selected value="18">18+</option>
                        <option value="45">45+</option>
                    </select>
                </div>
                <div class="formbox">
                    <label for="notify">Notify Email?</label>
                    <input type="email" name="notify" id="notify" autocomplete="off" placeholder="Your Email To Notify" />
                </div>
                <div class="formbox buttons">
                    <input type="button" name="btnSubmit" id="btnSubmit" value="Start Tracking" class="btn btn-success" />
                    <input type="button" name="btnStop" id="btnStop" value="Stop Tracking" class="btn btn-warning" disabled />
                    <input type="button" onclick="saveEmailToNotify()" value="Notify When Available" class="btn btn-primary" />
                </div>
                
            </form>
            <div class="outputBox">
                <h4>Tracking Details: <span class="timerTracker">00:00</span></h4>
                <div class="trackingResults">
                    <table class="table table-dark table-striped">
                        <thead>
                            <tr>
                                <th>Pincode</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Age Group</th>
                                <th>Available</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        <footer class="footer">
            <p>Credit Goes To <b>AceTechVentures</b> Team & Cowin.gov.in & Codepan && Of course You & Me(Amit Prithyani).</p>
        </footer>
    </div>
    <script type="text/javascript">
        var timerTracker = 0;
        var interval = $('#frequency').val()*60;
        var timer;
        var pincodesArray = [];
        $('.timerTracker').html(timerTracker + ' min(s)');
        $('#btnSubmit').click(function(){
            if($('#pincode').val() == '')
            {
             alert('Pincode required');
             return false;
            }
            if($('#date').val() == '')
            {
             alert('Date required');
             return false;
            }
           

            if($('#pincode').val().includes(','))
            {
                pincodesArray = $('#pincode').val().split(',');
            }
            else
            {
                pincodesArray.push($('#pincode').val())
            }
            console.log(pincodesArray);
            getStartToken();
            startTracking();
            saveEmails();
            $('#btnStop').attr('disabled',false);
        });
        $('#btnStop').click(function(){
            stopTracking();
        });

        function startTracking()
        {
            makeRequest();
            timer = setInterval(
                function(){ 
                    $('.outputBox').show();
                    timerTracker++;
                    $('.timerTracker').html(parseInt(timerTracker/60) + ' min(s)');
                    if(timerTracker%interval == 0)
                    {
                        makeRequest();
                    }
                }, 1000);
        }

        function stopTracking()
        {
            timerTracker = 0;
            clearInterval(timer);
            $('.outputBox').hide();
        }

        function makeRequest()
        {
             $('.trackingResults tbody').html('');
            for(let a in pincodesArray)
            {
                var sendEmailBool = 0;
            var date = new Date($('#date').val());
            var data = {
                pincode: pincodesArray[a],
                date: moment(date).format('D-M-Y'),
            }
          $('.loader').show();
          axios.post('/make-request',{data:data})
            .then((response) => {
                    var html = '';
                    var slots = '';
                    console.log(response.data);
                    for(let i in response.data.centers)
                    {
                        if(response.data.centers[i]['sessions'][0]['available_capacity'] != 0)
                        {
                            //sendEmailBool = 1;
                        }
                        
                        if($('#onlyAvailable').val() == 1)
                        {
                            if(response.data.centers[i]['sessions'][0]['available_capacity'] != 0)
                            {

                                if(response.data.centers[i]['sessions'])
                                {
                                    for(k in response.data.centers[i]['sessions'][0]['slots'])
                                    { 
                                        slots += response.data.centers[i]['sessions'][0]['slots'][k] + '<br>' 
                                    }
                                }
                                if($('#ageGroup').val() == 18)
                                {
                                    if(response.data.centers[i]['sessions'][0]['min_age_limit'] == 18)
                                    {
                                        html += `<tr>
                                            <td>`+pincodesArray[a]+`</td>
                                            <td><span class="centerName">`+response.data.centers[i]['name']+`</span></td>
                                            <td><span class="centerAddress">`+response.data.centers[i]['address']+`</span></td>
                                            <td><span class="ageLimit">`+response.data.centers[i]['sessions'][0]['min_age_limit']+`</span></td>
                                            <td><span class="capacity">`+response.data.centers[i]['sessions'][0]['available_capacity']+`</span></td>
                                        </tr>`;
                                    }
                                }
                                else
                                if($('#ageGroup').val() == 45)
                                {
                                    if(response.data.centers[i]['sessions'][0]['min_age_limit'] == 45)
                                    {
                                        html += `<tr>
                                            <td>`+pincodesArray[a]+`</td>
                                            <td><span class="centerName">`+response.data.centers[i]['name']+`</span></td>
                                            <td><span class="centerAddress">`+response.data.centers[i]['address']+`</span></td>
                                            <td><span class="ageLimit">`+response.data.centers[i]['sessions'][0]['min_age_limit']+`</span></td>
                                            <td> <span class="capacity">`+response.data.centers[i]['sessions'][0]['available_capacity']+`</span></td>
                                        </tr>`;
                                    }
                                }
                            }
                        }
                        else
                        {
                            if(response.data.centers[i]['sessions'])
                            {
                                for(k in response.data.centers[i]['sessions'][0]['slots'])
                                { 
                                    slots += response.data.centers[i]['sessions'][0]['slots'][k] + '<br>' 
                                }
                            }
                            if($('#ageGroup').val() == 18)
                            {
                                if(response.data.centers[i]['sessions'][0]['min_age_limit'] == 18)
                                {
                                    html += `<tr>
                                            <td>`+pincodesArray[a]+`</td>
                                            <td><span class="centerName">`+response.data.centers[i]['name']+`</span></td>
                                            <td><span class="centerAddress">`+response.data.centers[i]['address']+`</span></td>
                                            <td><span class="ageLimit">`+response.data.centers[i]['sessions'][0]['min_age_limit']+`</span></td>
                                            <td><span class="capacity">`+response.data.centers[i]['sessions'][0]['available_capacity']+`</span></td>
                                        </tr>`;
                                }
                            }
                            else
                            if($('#ageGroup').val() == 45)
                            {
                                if(response.data.centers[i]['sessions'][0]['min_age_limit'] == 45)
                                {
                                    html += `<tr>
                                            <td>`+pincodesArray[a]+`</td>
                                            <td><span class="centerName">`+response.data.centers[i]['name']+`</span></td>
                                            <td><span class="centerAddress">`+response.data.centers[i]['address']+`</span></td>
                                            <td><span class="ageLimit">`+response.data.centers[i]['sessions'][0]['min_age_limit']+`</span></td>
                                            <td><span class="capacity">`+response.data.centers[i]['sessions'][0]['available_capacity']+`</span></td>
                                        </tr>`;
                                }
                            }
                        }
                    }

                    

                    if(html != '')
                    {
                        $('.trackingResults tbody').append(html);
                    }
                    else
                    {
                        $('.trackingResults tbody').append('<tr><td colspan="5">Slots not available for '+pincodesArray[a]+'</td></tr>');
                    }

                    
                    
                    // if($('#notify').val() != '' && sendEmailBool == 1)
                    // {
                    //     sendEmail();
                    // }
                    
                    $('.loader').hide();
            }, (error) => {
                alert(error.error);
                stopTracking();
            });
            }
            
  
        }
        function sendEmail() {
            var data = {
                email: $('#notify').val(),
                pincode: $('#pincode').val(),
            }
          axios.post('/send-email',{data:data})
            .then((response) => {
                console.log(response);
                }, (error) => {
                alert(error.error);
                stopTracking();
            });
        }

        function saveEmailToNotify() {
            if($('#pincode').val() == '')
            {
             alert('Pincode required');
             return false;
            }
            if($('#notify').val() == '')
            {
             alert('Email required');
             return false;
            }
            $('.loader').show();
            var pincodes = $('#pincode').val().split(',');
            for(let k in pincodes)
            {
                var date = new Date($('#date').val());
           
                var data = {
                    email: $('#notify').val(),
                    pincode: pincodes[k],
                    date: moment(date).format('D-M-Y')
                }
              axios.post('/save-request',{data:data})
                .then((response) => {
                    if(response.data.status == 'already_exists')
                    {
                        alert('Email and Pincode already added')
                    }
                    else
                    {
                        alert('Added to list');
                    }

                    $('.loader').hide();
                    }, (error) => {
                    $('.loader').hide();
                    alert(error.error);
                    stopTracking();
                });
            }
            
        }

        function saveEmails() {
            if($('#pincode').val() == '')
            {
             return false;
            }
            if($('#notify').val() == '')
            {
             return false;
            }
            var date = new Date($('#date').val());
            var data = {
                email: $('#notify').val(),
                pincode: $('#pincode').val(),
                date: moment(date).format('D-M-Y')
            }
          axios.post('/save-request',{data:data})
            .then((response) => {
                console.log(response);
                }, (error) => {
                alert(error.error);
                stopTracking();
            });
        }
    </script>
    
</body>
</html>