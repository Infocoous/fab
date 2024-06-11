document.addEventListener("DOMContentLoaded", function() {
    // Check if the user is logged in (you might need to adjust this based on your login system)
    var isLoggedIn = false; // Set this to true if the user is logged in

    // Get the "Account" button element
    var accountButton = document.getElementById("accountButton");

    // If the user is logged in, change the text of the "Account" button to "Coins - 0"
    if (isLoggedIn) {
        accountButton.innerHTML = '<b class="account">Coins - 0</b>';
    }
});

console.log(isLoggedIn);