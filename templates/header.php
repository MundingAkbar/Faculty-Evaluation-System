<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Evaluation System</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" media="all" href="../css/header.css">
    <script src="https://kit.fontawesome.com/faf20bb39b.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/loader.css">
    
    <script>
        $(document).ready(function(){
            setInterval(function(){
                $('#time').load('../templates/time.php')
            },1000);
        })
    </script>

</head>
<body>
    <div class="loader_bg">
            <div class="loader"></div>
    </div>
    <div class="container-fluid bg-dark">
        <div class="page-header row p-2">
            <img src="../images/wmsu.png" alt="wmsu-logo">
            <div class="col text-light">
                <h3>WMSU</h3>
                <p>Faculty Evaluation System</p>
            </div>
            <div class ="col-0 date-time p-2">
                <div id="date" class="text-light">
                    <h4><?php echo date("F d,Y"); ?></h4>
                </div>
                <div id="time" class="text-light">
                    00 : 00 : 00 AM
                </div>
            </div>
           
        </div>
    </div>
