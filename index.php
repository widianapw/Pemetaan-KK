<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Geographic Information</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<style>
    #map{
        position: absolute; height: 100%; width: 100%; padding: 0; border-width: 0px; margin: 0; left: 0;
    }
    #nav{
        position: relative; 
        top: 0; 
        width: 100%;
        display: block;
        margin: 0;
        padding: 10px;
        background-color:#2b5797;  
    }
    body{
        overflow-y:hidden;
    }
</style>
<body>
    <nav id="nav" class="navbar navbar-expand-sm navbar-dark">
    <ul class="navbar-nav">
        <li class="nav-item active">
            <a class="nav-link" href="#"><img height="30" widht="30" src="logogeografis1.png" alt="..."> Geographic Information</a>
        </li>
    </ul>
    </nav>
    
        <div id="map"></div>
    
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Street Map</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div id="pano" style="height:300px; width:100%;"></div>
                </div>

            </div>
        </div>
    </div>
</body>

<script>
    function initMap() {
        var marker;
        var sv = new google.maps.StreetViewService();
        var infoWindow = new google.maps.InfoWindow;
        var map = new google.maps.Map(document.getElementById('map'), {
             
            center: {lat:-8.412526, lng:115.189599},
            zoom: 10,
        });
        var bounds = new google.maps.LatLngBounds();
        var markers = [];
        $.ajax({
            url: "./loadFromDatabase.php",
            type: "get",
            dataType: 'json',
            success: function (response, status, jqXHR){     
                //buat marker pada posisi yang tersimpan di database
                $.each(response, function(i,obj){
                    marker = new google.maps.Marker({
                        map: map,
                        position:  {lat: parseFloat(response[i].latitude), lng: parseFloat(response[i].longitude)},
                    });
                    var pos = {lat: parseFloat(response[i].latitude), lng: parseFloat(response[i].longitude)};
                    markers.push(marker);        
                    
                    marker.addListener('click', function(e){
                        infoWindow.setPosition(pos)
                        infoWindow.setContent("<div style='text-align:center'><img height='100px' alt='...' width = 'auto' src='/"+response[i].photo+"'></div>"+
                        "<b>Nama : </b>"+ response[i].name
                        +"<br><b>Jumlah KK : </b>"+ response[i].jumlah_kk
                        +"<br><b>NIM : </b>"+ response[i].nim
                        +"<br><b>Tanggal : </b>"+ response[i].date
                        +"<br><hr><button class='btn-success btn-block' id='streetView' data-toggle='modal' data-target='#myModal'>360 View</button>");
                        infoWindow.open(map);
                        $('#streetView').on('click',function(e){
                            var panorama = new google.maps.StreetViewPanorama(
                                document.getElementById('pano'), {
                                position: pos,
                                pov: {
                                    heading: 240,
                                    pitch: 0
                                },
                                visible: true
                            });
                            
                        });
                    });
                    
            
                });
            
            var markerCluster = new MarkerClusterer(map, markers,
                {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});

            }
        });
    }
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDC4Kci4iYfmBJ0_DOJDE-UOEOyHVi6pv4&callback=initMap" async
    defer></script>
<script src="https://unpkg.com/@google/markerclustererplus@4.0.1/dist/markerclustererplus.min.js"></script>
</html>