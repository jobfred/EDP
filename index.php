
 <!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Export Booking Excel to Coprar Converter</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  
  </head>
  <body>          
        <script>

        
        
        var oFileIn;

        $(function() {
            oFileIn = document.getElementById('my_file_input');
            if(oFileIn.addEventListener) {
                oFileIn.addEventListener('change', filePicked, false);
            }
        });


        function filePicked(oEvent) {
            // Get The File From The Input
            var oFile = oEvent.target.files[0];
            var form_data = new FormData();                  
            form_data.append('file', oFile);
            var other_data = $('form').serialize();
            $.ajax({
                url: 'upload.php?'+other_data, 
                dataType: 'text',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function(data){

                    $('#my_file_output').val(data);
                }
             });
            
        }
        
       
</script>
<div class="container">
    <div class="card" style="">
        <form enctype="multipart/form-data" method="post">
          <div class="card-body">
            <h5 class="card-title">Export Booking Excel to Coprar Converter</h5>
            <div class="form-group">
                <label for="recv_code">Receiver Code:</label><input class="form-control" type="text" id="recv_code" name="recv_code" value="RECEIVER" />
                <p><small>Please change before file select.</small></p>
            </div>
            <div class="form-group">
                <label for="recv_code">Callsign Code:</label><input class="form-control" type="text" id="callsign_code" name="Callsign" value="XXXXX" />
                <p><small>Please change before file select.</small></p>
            </div>
            <div class="form-group">
                <label for="my_file_input">Export booking excel file:</label><input class="form-control" type="file" id="my_file_input" />
                
            </div>
            <div class="form-group"><textarea class="form-control" rows="20" cols="40" id='my_file_output'></textarea></div>
          </div>
        </form>
    </div>
</div>

</body>
</html>
