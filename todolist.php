<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List App</title>
    <link rel="stylesheet" href="styles.css"
    <!-- Include Email.js library -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js"></script>
    <script type="text/javascript">
        // Initialize Email.js
        (function () {
            emailjs.init("tC6ao1PIBXwcg0jMu");
        })();
    </script>
</head>
<body>
    <form>
    <div class="container">
        <div class="todo-app">
            <h2>To-Do List <img src="images/icon.png"></h2>
            <div class="row">
                <input type="text" id="input-box" placeholder="Type Here">
                <button class="button" onclick="addTask()">Add</button>
            </div>
            <ul id="list-container" onclick="toggleTask(event)">
                <!-- Your to-do list items will be added here dynamically -->
            </ul>
        </div>
        <div class="newcontainer">
            <div class="sendemails">
                <h2>Choose when to send the List</h2>
                <div class="row">
                    <form id="emailForm">
                        <input type="time" id="userTime">
                        <button type="button" class="buto" onclick="setTime()">Set Time</button>
                    </form>
                </div>
                <div class ="row">
                    <input type="date" id="userdate">
                        <button type="button" class="buto1" onclick="setDate()">Set Date</button>
                </div>
                <h2>Enter Your Email</h2>
                <div class="row">
                    <input type="email" id="email" name="email" required placeholder="Type Here">
                    <button type="button" class="newbut" onclick="saveEmail()">Save Email</button>
                </div>
                
            
            </div>
        </div>
    </div>
</form>
    <script>
        // Define a global variable for the to-do list array
        var todoItems = [];
        var selectedHours;
        var selectedMinutes;
        function addTask() {
            event.preventDefault();
            var inputbox = document.getElementById("input-box");
            var listcontainer = document.getElementById("list-container");
            if (inputbox.value === '') {
                alert("FIND SOMETHING TO DO");
                
            } else {
                let li = document.createElement("li");
                li.innerHTML = inputbox.value;
                listcontainer.appendChild(li);
                // Add a delete button (cross) to each new list item
                var span = document.createElement("span");
                span.innerHTML = "\u00d7";
                span.className = "delete-button";
                li.appendChild(span);
                todoItems.push({ task: inputbox.value, crossed: false });
                saveData();
            }
            inputbox.value = '';
        }
        function toggleTask(event) {
    if (event.target.tagName === "LI") {
        event.target.classList.toggle("checked");
        // Find the corresponding task in the todoItems array and update its crossed status
        var taskIndex = todoItems.findIndex(item => item.task === event.target.textContent);
        if (taskIndex !== -1) {
            todoItems[taskIndex].crossed = !todoItems[taskIndex].crossed;
            saveData();
        }
    } else if (event.target.classList.contains("delete-button")) {
        // Delete the item from localStorage
        var listItem = event.target.parentElement;
        var taskIndex = todoItems.findIndex(item => item.task === listItem.textContent);
        if (taskIndex !== -1) {
            todoItems.splice(taskIndex, 1);
            saveData();
            localStorage.setItem("data", JSON.stringify(todoItems)); // Update localStorage
        }
        // Remove the list item from the UI
        listItem.remove();
    }
}

        function sendEmail(emailInput) {
            // Filter out crossed-out items from the to-do list
            var filteredTodoItems = todoItems.filter(item => !item.crossed);
            // Join the filtered to-do list array into a string with line breaks
            var todoListString = filteredTodoItems.map(item => item.task).join("\n");
            // Set up parameters for Email.js
            var params = {
                sendername: "Your Name",
                to: emailInput,
                subject: "To-Do List",
                replyto: "", // You can add a reply-to email if needed
                message: "Here is your to-do list:\n\n" + todoListString,
            };
            // Set up service and template IDs from your Email.js account
            var serviceID = "service_v5cc2fs";
            var templateID = "template_90nxjul";
            // Send the email
            emailjs.send(serviceID, templateID, params)
                .then(res => {
                    alert("To-Do List Sent");
                
                })
                .catch(error => {
                    console.error("Error sending to-do list:", error);
                });
        }
        function saveEmail(){
            var emailInput = document.getElementById('email').value;
            alert("Email saved successfully!");
            localStorage.setItem('savedInput2', emailInput);
        }
        function showCurrentTime() {
            var now = new Date();
            var hours = now.getHours();
            var minutes = now.getMinutes();
            var seconds = now.getSeconds();
            var timeString = hours.toString().padStart(2, '0') + ':' +
                minutes.toString().padStart(2, '0') + ':' +
                seconds.toString().padStart(2, '0');
            document.getElementById('date-time').innerHTML = timeString;
        }
        document.addEventListener('DOMContentLoaded', function () {
            showCurrentTime();
            setInterval(showCurrentTime, 1000);
        });
        function setTime() {
            var selectedTime = document.getElementById('userTime').value;
            selectedHours = parseInt(selectedTime.split(':')[0], 10);
            selectedMinutes = parseInt(selectedTime.split(':')[1], 10);
            alert("Time set successfully!");
            
            localStorage.setItem('savedInput', selectedTime);
        }
        function setDate() {
    var selectedDate = document.getElementById('userdate').value;
    var parts = selectedDate.split('/');
    selectedMonth = parseInt(parts[0], 10); // Month (1-12)
    selectedDay = parseInt(parts[1], 10);   // Day (1-31)
    alert("Date set successfully!");

    

}
function checkDateTimeAndSendEmail() {
    var current = new Date();
    var currentHours = current.getHours();
    var currentMinutes = current.getMinutes();
    var currentMonth = current.getMonth() + 1; // Adding 1 because getMonth() returns zero-based month index
    var currentDay = current.getDate(); // Getting the day of the month
    // Check if the current date and time match the scheduled date and time
    if (
        currentHours === selectedHours && 
        currentMinutes === selectedMinutes
      //  currentMonth === selectedMonth && 
      //  currentDay === selectedDay
     ) {
        var email = document.getElementById('email').value;
        sendEmail(email);
    }
}
  setInterval(checkDateTimeAndSendEmail, 60000);
        function saveData() {
            localStorage.setItem("data", JSON.stringify(todoItems));
        }
        function showTask() {
            var listcontainer = document.getElementById("list-container");
            var storedData = localStorage.getItem("data");
            if (storedData) {
                todoItems = JSON.parse(storedData);
                todoItems.forEach(function (item) {
                    var li = document.createElement("li");
                    li.innerHTML = item.task;
                    // Add a delete button (cross) to each saved list item
                    var span = document.createElement("span");
                    span.innerHTML = "\u00d7";
                    span.className = "delete-button";
                    li.appendChild(span);
                    // Check if the task was crossed and apply the style
                    if (item.crossed) {
                        li.classList.add("checked");
                    }
                    listcontainer.appendChild(li);
                });
            }
        }

        window.onload = function(){
            var savedInput = localStorage.getItem('savedInput');
            if(savedInput !== null) {
                document.getElementById('userTime').value = savedInput;
        }
        var savedInputE = localStorage.getItem('savedInput2');
            if(savedInputE !== null) {
                document.getElementById('email').value = savedInputE;
        }
        setTime2();
    }



        function setTime2(){
            var selectedTime = document.getElementById('userTime').value;
            selectedHours = parseInt(selectedTime.split(':')[0], 10);
            selectedMinutes = parseInt(selectedTime.split(':')[1], 10);
            localStorage.setItem('savedInput', selectedTime);

        }
        showTask();

    </script>
</body>
</html>