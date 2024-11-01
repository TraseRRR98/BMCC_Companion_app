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

    // Check for keywords to provide specific responses
    if (input.includes("study for advanced programming techniques")) {
        return "To study for Advanced Programming Techniques, try breaking down each concept into manageable sections. Practice coding daily, review class materials, and focus on hands-on exercises to solidify your understanding. Group study sessions can also help reinforce concepts.";
    } else if (input.includes("resources for learning algorithms")) {
        return "For learning algorithms, check out resources like 'Introduction to Algorithms' by Cormen et al., online tutorials like GeeksforGeeks and LeetCode, and YouTube channels like Computerphile. Practice solving algorithm problems daily to build confidence.";
    } else if (input.includes("explain object-oriented programming principles")) {
        return "Sure! Object-Oriented Programming (OOP) focuses on organizing code around objects and classes. The main principles are encapsulation, inheritance, polymorphism, and abstraction. Each helps manage complexity by structuring programs into reusable, modular code blocks.";
    } else if (input.includes("improve my debugging skills")) {
        return "Improving debugging skills takes practice. Start by understanding error messages, use print statements to check values, and practice with a debugger tool. Try to isolate issues and tackle them systematically, and consider reviewing your code logic with a peer or tutor.";
    } else if (input.includes("prepare for programming exams")) {
        return "To prepare for programming exams, review your notes and focus on coding exercises relevant to the course. Practice coding without looking at solutions, simulate exam conditions, and try to understand the logic behind each solution. Reviewing past exams can also be beneficial.";
    } else {
        // Default response if no keywords match
        return "I'm here to help! Can you please clarify your question about CSC 211 or programming?";
    }
}
