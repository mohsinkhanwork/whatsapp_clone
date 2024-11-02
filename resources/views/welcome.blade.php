<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real-Time Chat Test</title>
</head>
<body>
    <h1>Real-Time Chatroom Updates</h1>
    <ul id="messages"></ul>

    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.11.0/echo.iife.js"></script>
    <script>
        const pusher = new Pusher('7171ce2067c3bb00905b', {
            cluster: 'ap2',
            encrypted: true
        });

        const echo = new Echo({
            broadcaster: 'pusher',
            key: '7171ce2067c3bb00905b',
            cluster: 'ap2',
            forceTLS: true
        });

        echo.channel('chatroom.1')
            .listen('MessageSent', (e) => {
                const messageList = document.getElementById('messages');
                const newMessage = document.createElement('li');
                newMessage.textContent = `${e.message.user_id}: ${e.message.message_text || 'Attachment sent'}`;
                messageList.appendChild(newMessage);
            });
    </script>
</body>
</html>
