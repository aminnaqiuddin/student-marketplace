@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Chat with {{ $seller->name }} about "<strong>{{ $product->title }}</strong>"</h3>

    <div id="chat-box"
         style="border:1px solid #ccc; height:300px; overflow-y:scroll; margin-bottom:10px; padding: 10px; background: #f9f9f9;">
    </div>

    <div class="input-group">
        <input type="text" id="message" placeholder="Type your message..." class="form-control" />
        <button onclick="sendMessage()" class="btn btn-primary">Send</button>
    </div>
</div>

<!-- Firebase SDKs -->
<script src="https://www.gstatic.com/firebasejs/10.12.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/10.12.0/firebase-database.js"></script>

<script>
    // Firebase Config
    const firebaseConfig = {
        apiKey: "AIzaSyAlUa4wRpdae6-zg8coAtvz_F42RkzuocI",
        authDomain: "unimarketplacechat.firebaseapp.com",
        databaseURL: "https://unimarketplacechat.firebaseio.com",
        projectId: "unimarketplacechat",
        storageBucket: "unimarketplacechat.appspot.com",
        messagingSenderId: "YOUR_SENDER_ID",
        appId: "YOUR_APP_ID"
    };
    firebase.initializeApp(firebaseConfig);
    const db = firebase.database();

    // User & Room Info
    const currentUser = @json(Auth::user()->id);
    const sellerId = @json($seller->id);
    const productId = @json($product->id);

    const [lowId, highId] = [currentUser, sellerId].sort((a, b) => a - b);
    const roomId = `product_${productId}_user_${lowId}_user_${highId}`;
    const chatRef = db.ref("chats/" + roomId);

    // Message sending
    function sendMessage() {
        const msgInput = document.getElementById("message");
        const msg = msgInput.value.trim();
        if (!msg) return;

        chatRef.push({
            sender_id: currentUser,
            message: msg,
            timestamp: Date.now()
        });

        msgInput.value = "";
    }

    // Helper to sanitize text (very basic)
    function escapeHTML(str) {
        return str.replace(/[&<>"']/g, function(tag) {
            return ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            })[tag];
        });
    }

    // Auto scroll to bottom
    function scrollToBottom() {
        const chatBox = document.getElementById("chat-box");
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    // Listen for new messages
    chatRef.on("child_added", function(snapshot) {
        const data = snapshot.val();
        const user = data.sender_id == currentUser ? "You" : "{{ $seller->name }}";
        const msgEl = `<p><strong>${user}:</strong> ${escapeHTML(data.message)}</p>`;
        document.getElementById("chat-box").innerHTML += msgEl;
        scrollToBottom();
    });
</script>
@endsection
