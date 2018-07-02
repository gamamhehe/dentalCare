<!DOCTYPE html>
<html>
<head>
    <title>Live search in laravel using AJAX</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<br />
<div class="container box">

    <div class="panel panel-default">
        <div class="panel-heading">Search User</div>
        <div class="panel-body">
            <div class="form-group">
                <input type="text" name="search" id="search" class="form-control" placeholder="Search Customer Data"  />
                <div class="row" style="margin-bottom: 1em;" >
                    <div class=""  style="margin-top: 1em;">
                        <button type="button" class="col-md-3 btn btn-default btn-success" style="margin-right: 10px;float: right;"  onclick="search()" >Tìm</button>
                    </div>
                </div>

            </div>
            <div class="table-responsive">
                <h3 align="center">Total Data : <span id="total_records"></span></h3>
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Customer Name</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>Postal Code</th>
                        <th>Country</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>

<script>
    $(document).ready(function(){

    });
    function search(){
        alert("d");
        var x = 01;
        $.ajax({
            url: '/admin/live_search/'+ x, //this is your uri
            type: 'GET', //this is your method

            dataType: 'json',
            success: function(data){
            alert("DKM");
                $('tbody').html(data.table_data);
                $('#total_records').text(data.total_data);
            },error: function (data) {
                alert("SS");
            }
        });
    }

</script>