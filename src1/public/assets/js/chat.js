/**
 * Handles sending messages, displaying new messages, managing date badges,
 * and updating chat previews in real-time.
 */

document.addEventListener("DOMContentLoaded", () => {
    // DOM Elements
    const messagesContainer = document.getElementById("messages-container");
    const messageForm = document.getElementById("message-form");
    const messageInput = document.getElementById("message-input");

    scrollToBottom();

    /**
     * Scroll to the bottom of the messages container
     */
    function scrollToBottom() {
        if (messagesContainer) {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }
    }

    /**
     * Format a date string to display as "Today", "Yesterday", or regular date
     * @param {string} dateStr - ISO date string
     * @returns {string} Formatted date for display
     */
    function formatDate(dateStr) {
        const date = new Date(dateStr);
        const today = new Date();
        const yesterday = new Date();
        yesterday.setDate(today.getDate() - 1);

        // Extract date-only strings for comparison
        const dateOnly = date.toISOString().split("T")[0];
        const todayOnly = today.toISOString().split("T")[0];
        const yesterdayOnly = yesterday.toISOString().split("T")[0];

        if (dateOnly === todayOnly) return "Oggi";
        if (dateOnly === yesterdayOnly) return "Ieri";
        return date.toLocaleDateString();
    }

    /**
     * Check if a date badge already exists for a given date
     * @param {string} dateStr - ISO date string
     * @returns {boolean} True if badge exists
     */
    function badgeExists(dateStr) {
        const badges = messagesContainer.querySelectorAll(".badge");
        const formatted = formatDate(dateStr);
        return Array.from(badges).some(badge => badge.textContent.trim() === formatted);
    }

    /**
     * Create a date badge element
     * @param {string} dateStr - ISO date string
     * @returns {HTMLElement} Date badge div element
     */
    function createDateBadge(dateStr) {
        const badgeDiv = document.createElement("div");
        badgeDiv.className = "text-center my-3";

        const span = document.createElement("span");
        span.className = "badge bg-body-secondary bg-opacity-25 px-3 py-1 rounded-pill";
        span.textContent = formatDate(dateStr);

        badgeDiv.appendChild(span);
        return badgeDiv;
    }

    /**
     * Escape HTML special characters to prevent XSS
     * @param {string} text - Text to escape
     * @returns {string} Safe HTML string
     */
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    /**
     * Create a complete message element
     * @param {Object} messageData - Message object
     * @param {string} messageData.text - Message content
     * @param {string} messageData.created_at - ISO timestamp
     * @param {number} messageData.conversation_id - Conversation ID
     * @param {boolean} [isMe=true] - Whether message is from current user
     * @returns {HTMLElement} Complete message element with optional date badge
     */
    function createMessageElement(messageData, isMe = true) {
        const wrapper = document.createElement("div");
        wrapper.className = "d-flex flex-column";

        // Add date badge if needed (for first message of the day)
        if (!badgeExists(messageData.created_at)) {
            wrapper.appendChild(createDateBadge(messageData.created_at));
        }

        // Format time for display
        const time = new Date(messageData.created_at).toLocaleTimeString([], { 
            hour: '2-digit', 
            minute: '2-digit' 
        });
        
        const messageDiv = document.createElement("div");
        messageDiv.className = `mb-3 ${isMe ? 'text-end' : ''}`;

        // Determine bubble styling based on sender
        const bubbleClass = isMe 
            ? "bg-primary bg-opacity-10 text-primary" 
            : "bg-body border";
        
        // Build message HTML
        messageDiv.innerHTML = `
            <div class="${bubbleClass} rounded-4 p-3 d-inline-block text-start" style="max-width:75%;">
                <div>${escapeHtml(messageData.text)}</div>
                <div class="text-end small text-body-secondary mt-1">
                    ${time} ${isMe ? '<i class="bi bi-check2"></i>' : ''}
                </div>
            </div>
        `;

        wrapper.appendChild(messageDiv);
        return wrapper;
    }

    /**
     * Update the chat preview in the conversation list
     * @param {Object} messageData - Message object containing conversation_id and text
     */
    function updateChatPreview(messageData) {
        const conversationId = messageData.conversation_id;
        // Find the active conversation link
        const chatLink = document.querySelector(`.list-group-item[href="?conversation_id=${conversationId}"]`);
        if (!chatLink) return;

        // Update preview text (truncated to 40 chars)
        const previewEl = chatLink.querySelector('.text-body-secondary.text-truncate');
        if (previewEl) {
            let previewText = messageData.text;
            if (previewText.length > 40) {
                previewText = previewText.substr(0, 37) + '...';
            }
            previewEl.textContent = previewText;
        }

        // Update last message time
        const timeEl = chatLink.querySelector('small.text-body-secondary');
        if (timeEl) {
            const msgTime = new Date(messageData.created_at);
            timeEl.textContent = msgTime.toLocaleTimeString([], { 
                hour: '2-digit', 
                minute: '2-digit' 
            });
        }
    }

    /**
     * Handle message form submission
     * @param {Event} e - Form submit event
     */
    function handleFormSubmit(e) {
        e.preventDefault();
        const messageText = messageInput.value.trim();
        if (!messageText) return;

        const formData = new FormData(messageForm);

        fetch("send-message.php", { 
            method: "POST", 
            body: formData 
        })
        .then(res => res.json())
        .then(data => {
            if (data.success && data.message) {
                // Clear input field
                messageInput.value = "";
                
                // Add message to chat
                messagesContainer.appendChild(createMessageElement(data.message));
                scrollToBottom();

                // Update chat list preview
                updateChatPreview(data.message);
            }
        })
        .catch(err => console.error("Error sending message:", err));
    }

    // Event Listeners
    if (messageForm) {
        messageForm.addEventListener("submit", handleFormSubmit);
    }

    // Ctrl+Enter shortcut for sending messages
    if (messageInput) {
        messageInput.addEventListener("keydown", e => {
            if (e.ctrlKey && e.key === "Enter") {
                messageForm.dispatchEvent(new Event("submit"));
            }
        });
    }
});