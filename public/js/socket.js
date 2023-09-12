// socket.js

const socket = io('http://127.0.0.1:3000');

socket.on('connect', () => {
    console.log('Bağlantı kuruldu');
    sendMessage('Merhaba, bu bir test mesajıdır.');
});

socket.on('disconnect', () => {
    console.log('Bağlantı kesildi');
});

socket.on('message', (message) => {
    // Gelen mesajı işleyin ve ekranda görüntülemek için uygun bir yol bulun
    console.log('Gelen Mesajer:', message);
});

// Mesaj göndermek için bir işlev
function sendMessage(message) {
    socket.emit('message', message);
    console.log('Gelen Mesaj:', message);
}

// Bu işlevi Laravel tarafından çağırabilmek için global bir işlev olarak tanımlayabilirsiniz
window.sendMessage = sendMessage;

function shareMessage(message) {
    socket.emit('message', message);
    console.log('Gelen Mesaj:', message);
}

// Bu işlevi Laravel tarafından çağırabilmek için global bir işlev olarak tanımlayabilirsiniz
window.shareMessage = shareMessage;
