const inputBox = document.getElementById("input-box");
const listContainer = document.getElementById("list-container");

// Function to add a new task
function addTask() {
    if (inputBox.value === '') {
        alert("Please enter a task!");
        return;
    }

    let taskDescription = inputBox.value;
    let li = document.createElement("li");
    li.textContent = taskDescription;
    listContainer.appendChild(li);

    // Add delete button
    let span = document.createElement("span");
    span.innerHTML = "\u00d7";
    span.className = "delete-button";
    li.appendChild(span);

    // Save task to localStorage
    saveTask(taskDescription);

    inputBox.value = ''; // Clear input box
}

// Function to delete a task
function deleteTask(taskElement) {
    taskElement.remove();

    // Get the description of the task to delete from its text content
    let taskDescription = taskElement.textContent;

    // Remove task from localStorage
    removeTask(taskDescription);
}

// Event listener for task deletion
listContainer.addEventListener("click", function (e) {
    if (e.target.classList.contains("delete-button")) {
        deleteTask(e.target.parentElement);
    }
});

// Function to save task to localStorage
function saveTask(taskDescription) {
    let tasks = getTasksFromLocalStorage();
    tasks.push(taskDescription);
    localStorage.setItem("tasks", JSON.stringify(tasks));
}

// Function to remove task from localStorage
function removeTask(taskDescription) {
    let tasks = getTasksFromLocalStorage();
    let index = tasks.indexOf(taskDescription);
    if (index !== -1) {
        tasks.splice(index, 1);
        localStorage.setItem("tasks", JSON.stringify(tasks));
    }
}

// Function to get tasks from localStorage
function getTasksFromLocalStorage() {
    let tasks = localStorage.getItem("tasks");
    return tasks ? JSON.parse(tasks) : [];
}

// Function to load tasks from localStorage
function loadTasksFromLocalStorage() {
    let tasks = getTasksFromLocalStorage();
    tasks.forEach(function (taskDescription) {
        let li = document.createElement("li");
        li.textContent = taskDescription;
        listContainer.appendChild(li);

        // Add delete button
        let span = document.createElement("span");
        span.innerHTML = "\u00d7";
        span.className = "delete-button";
        li.appendChild(span);
    });
}

// Load tasks from localStorage when the page loads
loadTasksFromLocalStorage();
