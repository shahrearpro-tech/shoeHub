@php
    $chatbotColor = \App\Models\Setting::getValue('chatbot_color', '#4318FF');
    $chatbotDarkColor = '#1B2559'; // Keeping header dark for contrast, or could derive
@endphp

<script>
// ATOMIC CHAT LOGIC - NO WRAPPERS
var shoehubChatOpen = false;
var CHATBOT_THEME_COLOR = '{{ $chatbotColor }}';

function toggleShoeHubChat(e) {
    if (e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    var win = document.getElementById('shoehub-chat-window');
    var btn = document.getElementById('shoehub-chat-toggle');
    
    if (!win) {
        console.error('CRITICAL: Chat Window Element Not Found!');
        return;
    }
    
    shoehubChatOpen = !shoehubChatOpen;
    
    if (shoehubChatOpen) {
        win.style.setProperty('display', 'flex', 'important');
        btn.style.background = '#1B2559';
        setTimeout(function() {
            var input = document.getElementById('shoehub-chat-input');
            if (input) input.focus();
        }, 200);
        if (typeof fetchShoeHubMessages === 'function') fetchShoeHubMessages();
    } else {
        win.style.setProperty('display', 'none', 'important');
        btn.style.background = CHATBOT_THEME_COLOR;
    }
}
</script>

<!-- Trigger Button -->
<button id="shoehub-chat-toggle" 
        onclick="toggleShoeHubChat(event)"
        style="position: fixed; bottom: 32px; right: 32px; width: 64px; height: 64px; background: {{ $chatbotColor }}; color: white; border-radius: 20px; border: none; cursor: pointer; z-index: 2147483647; display: flex; align-items: center; justify-content: center; box-shadow: 0 20px 40px rgba(67, 24, 255, 0.4); transition: 0.3s;">
    <i class="fas fa-comment-dots" style="font-size: 24px;"></i>
</button>

<!-- Independent Window -->
<div id="shoehub-chat-window" 
     style="position: fixed; bottom: 104px; right: 32px; width: 380px; height: 550px; background: white; border-radius: 30px; box-shadow: 0 40px 100px rgba(0,0,0,0.2); border: 1px solid rgba(0,0,0,0.1); display: none; flex-direction: column; z-index: 2147483646; overflow: hidden; transition: 0.3s; font-family: 'Inter', sans-serif;">
    
    <!-- Window Header -->
    <div style="padding: 24px; background: #1B2559; color: white; display: flex; align-items: center; justify-content: space-between; flex-shrink: 0;">
        <div style="display: flex; align-items: center; gap: 12px;">
            <div style="width: 40px; height: 40px; border-radius: 12px; background: rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-headset" style="color: {{ $chatbotColor }};"></i>
            </div>
            <div>
                <h3 style="margin: 0; font-size: 14px; text-transform: uppercase; font-weight: 800;">Support Hub</h3>
                <p style="margin: 0; font-size: 9px; color: #A3AED0; text-transform: uppercase;">Direct Line</p>
            </div>
        </div>
        <button onclick="toggleShoeHubChat(event)" style="background: none; border: none; color: white; cursor: pointer; padding: 5px;">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <!-- Messages Container -->
    <div id="shoehub-chat-messages" style="flex: 1; overflow-y: auto; padding: 24px; background: #F4F7FE; display: flex; flex-direction: column; gap: 16px;">
        <div style="background: white; padding: 16px; border-radius: 20px; border: 1px solid #E0E5F2; max-width: 85%;">
            <p style="margin: 0; font-size: 12px; font-weight: 700;">Connection Secured. How can we help?</p>
        </div>
    </div>

    <!-- Form Section -->
    <div style="padding: 20px; background: white; border-top: 1px solid #E0E5F2;">
        <form onsubmit="handleShoeHubChatSubmit(event)" style="display: flex; gap: 10px;">
            <input type="text" id="shoehub-chat-input" placeholder="Message..." required 
                   style="flex: 1; padding: 12px 15px; background: #F4F7FE; border: 1px solid #E0E5F2; border-radius: 12px; outline: none; font-size: 13px;">
            <button type="submit" style="width: 45px; height: 45px; background: {{ $chatbotColor }}; border: none; border-radius: 10px; color: white; cursor: pointer;">
                <i class="fas fa-paper-plane"></i>
            </button>
        </form>
    </div>
</div>

<script>
(function() {
    window.handleShoeHubChatSubmit = function(e) {
        e.preventDefault();
        var input = document.getElementById('shoehub-chat-input');
        var msg = input.value.trim();
        if (!msg) return;

        input.value = '';
        
        fetch(BASE_URL + '/chat/send', { 
            method: 'POST', 
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN
            },
            body: JSON.stringify({ message: msg }) 
        })
        .then(function() { window.fetchShoeHubMessages(); });
    };

    window.fetchShoeHubMessages = function() {
        fetch(BASE_URL + '/chat/fetch')
        .then(function(r) { return r.json(); })
        .then(function(d) {
            if (d.success) {
                var area = document.getElementById('shoehub-chat-messages');
                var first = area.firstElementChild;
                area.innerHTML = '';
                area.appendChild(first);
                d.messages.forEach(function(m) {
                    var div = document.createElement('div');
                    var isAdmin = m.is_admin_reply == 1;
                    div.style.cssText = 'padding: 10px 14px; border-radius: 15px; font-size: 12px; font-weight: 700; max-width: 85%; ' + 
                        (isAdmin ? 'background: white; color: #1B2559; border: 1px solid #E0E5F2; align-self: flex-start;' : 'background: ' + CHATBOT_THEME_COLOR + '; color: white; align-self: flex-end;');
                    div.textContent = m.message;
                    area.appendChild(div);
                });
                area.scrollTop = area.scrollHeight;
            }
        });
    };

    setInterval(function() { if (shoehubChatOpen) window.fetchShoeHubMessages(); }, 5000);
})();
</script>
