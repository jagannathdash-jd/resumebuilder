document.addEventListener("DOMContentLoaded", function () {
    // Delete Button Confirmation
    const deleteButtons = document.querySelectorAll("button.delete");

    deleteButtons.forEach(button => {
        button.addEventListener("click", function (event) {
            // Show a confirmation dialog before deleting
            if (!confirm("Are you sure you want to delete this?")) {
                event.preventDefault();  // Prevent the default action (e.g., form submission)
            }
        });
    });

    // Dark Mode Toggle
    const darkModeToggle = document.createElement("button");
    darkModeToggle.innerText = "🌙 Dark Mode";
    darkModeToggle.classList.add("dark-mode-toggle");
    document.body.appendChild(darkModeToggle);

    // Check for saved theme preference in localStorage
    if (localStorage.getItem("theme") === "dark") {
        document.body.classList.add("dark-mode");
        darkModeToggle.innerText = "☀️ Light Mode";
    }

    // Add event listener for dark mode toggle
    darkModeToggle.addEventListener("click", function () {
        document.body.classList.toggle("dark-mode");
        
        // Save theme preference in localStorage
        if (document.body.classList.contains("dark-mode")) {
            localStorage.setItem("theme", "dark");
            darkModeToggle.innerText = "☀️ Light Mode";
        } else {
            localStorage.setItem("theme", "light");
            darkModeToggle.innerText = "🌙 Dark Mode";
        }
    });
});
