<!DOCTYPE html>
<head>
    <title>Pusher Test</title>
    <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
    <script>

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('e3c057cd172dfd888756', {
            cluster: 'ap1',
            encrypted: true
        });

        var channel = pusher.subscribe('receivePatient');
        channel.bind('ReceivePatient', function(data) {
            alert(data.id)
            if(data.id == 19) {
                alert(JSON.stringify(data));
            }
        });
    </script>
</head>
<body>
<h1>Pusher Test</h1>
<p>
    Try publishing an event to channel <code>my-channel</code>
    with event name <code>my-event</code>.
</p>
</body>