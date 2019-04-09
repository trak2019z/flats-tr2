var $ = require('jquery');
window.jQuery = $;

require('bootstrap');
require('../scss/app.scss');
require('leaflet');
require('select2/dist/js/select2.min');
require('select2/dist/js/i18n/pl');



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