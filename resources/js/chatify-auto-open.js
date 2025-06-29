/**
 * Chatify Auto-Open Script (v1.6.3)
 * Automatically opens chat when URL has ?id=USER_ID
 */
document.addEventListener('DOMContentLoaded', function() {
    // Get user ID from URL or localStorage
    const urlParams = new URLSearchParams(window.location.search);
    const userId = urlParams.get('id') || localStorage.getItem('chatify_auto_open');

    if (!userId) return;

    // Cleanup stored ID
    localStorage.removeItem('chatify_auto_open');

    const openChat = () => {
        // Method 1: Use Chatify's function if available
        if (typeof Chatify?.openChat === 'function') {
            Chatify.openChat(userId);
            return true;
        }

        // Method 2: Simulate click on chat item
        const chatItem = document.querySelector(`.messenger-list-item[data-contact="${userId}"]`);
        if (chatItem) {
            chatItem.click();
            return true;
        }

        return false;
    };

    // Try immediately
    if (openChat()) return;

    // Retry every 200ms for 3 seconds if needed
    let attempts = 0;
    const maxAttempts = 15;
    const interval = setInterval(() => {
        attempts++;
        if (openChat() || attempts >= maxAttempts) {
            clearInterval(interval);
        }
    }, 200);
});
