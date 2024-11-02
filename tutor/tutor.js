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
    const input = userInput.toLowerCase().trim();

    // Use regular expressions for more flexible matching
    if (/linked\s*lists?/.test(input)) {
        return "A linked list is a data structure used in computer science to store a sequence of elements, where each element (called a node) contains data and a reference (or link) to the next node in the sequence. Linked lists are particularly useful for applications where you need dynamic memory allocation, as they allow you to easily insert or delete elements without rearranging the entire structure.";
    } else if (/hello/.test(input)) {
        return "Hello there, I am your school personal assistant";
    } else if (/what\s*can\s*you\s*do\??/.test(input)) {
        return "Hello there, I am your school personal assistant. I can assist you in creating study guides, provided teacher information, and other school resources";
    } else if (/csc\s*215.*tutoring\s*hour/.test(input)) {
        return "Tutoring for CSC 215 occurs both Tuesdays and Thursdays at 12:15 PM - 1:30 PM in room F1008-o";
    } else if (/integral\s*problems/.test(input)) {
        return "Here's a challenge: What's the indefinite integral of 3x^3 + 6?";
    } else if (/proficient\s*in\s*math/.test(input)) {
        return "Conceptual Understanding Over Memorization: Memorizing formulas and steps can be helpful for exams, but without understanding the reasoning behind them, they’re easy to forget and hard to apply creatively. When you focus on why a rule works, you’re better prepared to adapt it to different scenarios.";
    } else if (/linear\s*in\s*big-o/.test(input)) {
        return "Proportional Growth: If the input size doubles, the running time approximately doubles as well.";
    } else {
        // Default response if no keywords match
        return "Give me an academic query.";
    }
}