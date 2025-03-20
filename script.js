document.addEventListener("DOMContentLoaded", function () {
    let taskInput = document.getElementById("task_name");
    let submitBtn = document.getElementById("submitBtn");

    taskInput.addEventListener("input", function () {
        if (taskInput.value.trim() === "") {
            submitBtn.disabled = true; 
        } else {
            submitBtn.disabled = false; 
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const boxes = document.querySelectorAll(".tasklist");

    boxes.forEach((box) => {
        let lightness = Math.floor(Math.random() * 10) + 20; 
        box.style.backgroundColor = `hsl(183, 100%, ${lightness}%)`;
    });
});

function confirm1(id) {
    const c = confirm("Are you sure?");
    if (c) {
        window.location = "delete_task.php?id=" + id;
    }
}

function editTask(id) {
    let nameSpan = document.getElementById("name-" + id);
    let inputField = document.getElementById("input-" + id);
    let originalValue = nameSpan.textContent.trim();

    function saveTask() {
        let newTaskName = inputField.value.trim();

        if (newTaskName === "") {
            inputField.value = originalValue; 
        } else {
            fetch("edit_task.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "id=" + id + "&task_name=" + encodeURIComponent(newTaskName)
            })
            .then(response => response.text())
            .then(data => {
                if (data === "success") {
                    nameSpan.textContent = newTaskName;
                } else {
                    alert("Failed to update task.");
                }
            });
        }

        nameSpan.style.display = "inline";
        inputField.style.display = "none";

        inputField.removeEventListener("blur", saveTask);
        inputField.removeEventListener("keydown", handleKeyDown);
    }

    function handleKeyDown(event) {
        if (event.key === "Enter") {
            event.preventDefault(); 
            saveTask();
        }
    }

    if (nameSpan.style.display === "none") {
        saveTask();
    } else {
        nameSpan.style.display = "none";
        inputField.style.display = "inline";
        inputField.focus();
        inputField.value = originalValue; 

        inputField.addEventListener("blur", saveTask);
        inputField.addEventListener("keydown", handleKeyDown);
    }
}

document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener("click", function (e) {
        e.preventDefault();
        const targetId = this.getAttribute("href").substring(1);
        document.getElementById(targetId)?.scrollIntoView({
            behavior: "smooth",
            block: "start", // Aligns the target element to the top with proper spacing
            inline: "nearest"
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const sections = document.querySelectorAll(".category");
    const shortcuts = document.querySelectorAll(".shortcut");

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                const index = Array.from(sections).indexOf(entry.target);
                if (entry.isIntersecting) {
                    shortcuts.forEach((shortcut) => shortcut.classList.remove("active"));
                    shortcuts[index].classList.add("active");
                }
            });
        },
        { rootMargin: "0px 0px -70% 0px", threshold: 0 }   
    );

    sections.forEach((section) => observer.observe(section));
});