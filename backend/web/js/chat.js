let webSocketPort = 8080;
if(typeof wsPort !== 'undefined'){
    webSocketPort = wsPort;
}
console.log(webSocketPort);
//let webSocketPort = wsPort ? wsPort : 8080;
let conn = new WebSocket('ws://localhost:' + webSocketPort);
conn.onopen = function(e) {
    console.log("Connection established!");
    console.log(user);
};
console.log(photo);

$('#messageForm').on('submit', (e) => {
    e.preventDefault();
    let newMessage = $('#messageWindow').val();
    $('#messageWindow').val('');
    let message = {
        username: user,
        text: newMessage
    };
    message = JSON.stringify(message);
    conn.send(message);


});

conn.onmessage = function(e) {
    let message = JSON.parse(e.data);
    let history = $('#chatWindow').val();
    $('#chatWindow').val(`${message.username}: ${message.text} \n ${history}`);

    if( user != message.username) {
        let src = photo + "/img/user2-160x160.jpg";
        let $el = $('<li><a href="#"><div class="pull-left">' +
            '<img id="ava" src="" class="user-image" alt="User Image"/></div>' +
            '<h4>Support Team <small><i class="fa fa-clock-o"></i> 5 mins</small></h4>' +
            '<p>Why not buy a new awesome theme?</p></a></li>');
        $el.find('p').text(message.text);
        $el.find('h4').text(message.username);
        $el.prependTo('li.messages-menu ul.menu');
        $("#ava").attr("src",src);

        let cnt = $('li.messages-menu ul.menu li').length;
        $('li.messages-menu span.label-success').text(cnt);
        $('li.messages-menu li.header').text('You have ' + cnt + ' messages');
    }
};

$('#chatWindow').on('input', (e) => {
    let string = $(e.target).val();
    $(e.target).val(string.substring(0, string.length - 1));
});

$('.clear-messages').on('click', (e) => {
    e.preventDefault();
    $('li.messages-menu ul.menu').empty();
    $('li.messages-menu span.label-success').text(0);
    $('li.messages-menu li.header').text('You have ' + 0 + ' messages');
});



