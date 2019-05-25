require('../scss/app.scss');

function deleteRoomAction(){
    $('.delete-room').unbind('click').click(function () {
        $(this).closest('div').remove();
    });
}

deleteRoomAction();
$('.add-another-room').click(function () {
    var list = $($(this).data('roomList'));
    var counter = list.data('counter');
    var prototype = $($(this).data('prototype')).html();

    prototype = prototype.replace(/__name__/g, counter);
    list.append($(prototype));

    list.data('counter',counter+1);
    deleteRoomAction();
});

var map = null;
var marker = null;
if($('#flat_map').length)
{
    map = L.map('flat_map').setView([52.0647864,19.3925546], 5);
    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 18,
        id: 'mapbox.streets',
        accessToken: 'pk.eyJ1IjoidmljdXJlbCIsImEiOiJjams5c3Z6ZjUxenF4M3FxbG5reTVsOHF1In0.9YrR4IU3rxQSNuWGwQz_HQ'
    }).addTo(map);

    var lat = parseFloat($('#flat_map').data('lat'));
    var lon = parseFloat($('#flat_map').data('lon'));

    if(!isNaN(lat) && !isNaN(lon))
    {
        map.setView([lat, lon], 12);
        marker = L.marker([lat, lon]).addTo(map);
    }

    if($('#flat_city').length)
    {
        map.on('click',function (e) {
            marker = L.marker([e.latlng.lat, e.latlng.lng]).addTo(map);
        });
    }
}

function waitForSelect2Entity() {
    if($().select2entity)
    {
        $('#flat_city').on('select2:select', function (e) {
            $('#flat_latitude').val(e.params.data.lat);
            $('#flat_longitude').val(e.params.data.lon);
            if(map)
            {
                map.setView([e.params.data.lat, e.params.data.lon], 12);
            }
        });
    }
    else
    {
        setTimeout(waitForSelect2Entity, 500);
    }
}
waitForSelect2Entity();