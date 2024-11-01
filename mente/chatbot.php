<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userInput = trim($_POST["userInput"]);

    // Simple response logic (can be replaced with AI model)
    if (stripos($userInput, "hello") !== false) {
        $botResponse = "Hello! How can I support you today?";
    } elseif (stripos($userInput, "stress") !== false) {
        $botResponse = "I'm here to help! Try taking a few deep breaths. What's on your mind?";
    } else {
        $botResponse = "Thank you for sharing. I'm here to listen and guide you.";
    }

    echo $botResponse;
}
?>
