// Toggle Chat Window
function toggleChat() {
    const chatbotWindow = document.getElementById("chatbot-window");
    chatbotWindow.classList.toggle("hidden");
}

// Send Message
function sendMessage() {
    const userInput = document.getElementById("userInput").value;
    if (userInput.trim() === "") return false;

    // Display user's message in chatbox
    displayMessage(userInput, "user");

    // Process the response based on user input
    const botResponse = getBotResponse(userInput);
    displayMessage(botResponse, "bot");

    document.getElementById("userInput").value = ""; // Clear input field
    return false; // Prevent form submission
}

// Display Message in Chatbox
function displayMessage(message, sender) {
    const chatbox = document.getElementById("chatbox");
    const messageContainer = document.createElement("div");
    messageContainer.className = `message-container ${sender}`;

    // Profile Icon
    const profileIcon = document.createElement("div");
    profileIcon.className = "profile-icon";
    profileIcon.textContent = sender === "user" ? "U" : "AI"; // U for user, AI for bot

    // Message Content
    const messageContent = document.createElement("div");
    messageContent.className = "message-content";
    messageContent.textContent = message;

    // Append icon and message content to the container
    if (sender === "user") {
        messageContainer.appendChild(profileIcon);
        messageContainer.appendChild(messageContent);
    } else {
        messageContainer.appendChild(messageContent);
        messageContainer.appendChild(profileIcon);
    }

    // Add the complete message container to the chatbox
    chatbox.appendChild(messageContainer);
    chatbox.scrollTop = chatbox.scrollHeight; // Scroll to the bottom
}

// Get Bot Response based on user input
function getBotResponse(userInput) {
    // Convert input to lowercase for case-insensitive matching
    const input = userInput.toLowerCase();

    // Check for mental health-related prompts and responses
    if (input.includes("how are you feeling mentally")) {
        return "It's great that you're checking in with yourself. I'm here to support you. How are you feeling today?";
    } else if (input.includes("i feel stressed")) {
        return "I'm sorry to hear that you're feeling stressed. Taking a few deep breaths or practicing mindfulness exercises can sometimes help. Would you like some tips on relaxation techniques?";
    } else if (input.includes("i feel anxious")) {
        return "Anxiety can be challenging. Try grounding techniques like focusing on your breathing or engaging your senses. Remember, I'm here for you if you want to talk about it.";
    } else if (input.includes("i feel overwhelmed")) {
        return "It sounds like there's a lot on your mind. Breaking tasks down into smaller steps can make things feel more manageable. I'm here to help however I can.";
    } else if (input.includes("i feel sad")) {
        return "I'm sorry that you're feeling sad. Sometimes, talking to someone or even writing down your feelings can help. Let me know if there’s anything specific you'd like to discuss.";
    } else {
        // Default response if no keywords match
        return "I'm here to listen and support you. How are you feeling, and what can I help you with today?";
    }
}
