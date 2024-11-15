$('.complete-task').click(function(e) {
    e.preventDefault();  // Prevent the default action of the button
    var taskId = $(this).data('id');  // Get the task ID

    // Show the completion modal
    $('#complete-modal').show();

    // Handle the confirmation action
    $('#complete-confirm').off('click').on('click', function() {
        completeTask(taskId);  // Call function to complete the task
        $('#complete-modal').hide();  // Hide the modal after confirmation
    });

    // Handle the cancel action
    $('#complete-cancel').off('click').on('click', function() {
        $('#complete-modal').hide();  // Hide the modal if the user cancels
    });
});

// Function to complete the task (AJAX call or other logic)
function completeTask(taskId) {
    $.ajax({
        type: 'POST',
        url: 'actions/complete_task.php',
        data: { id: taskId },
        success: function(response) {
            // On success, update the task UI
            $('#task_' + taskId).addClass('completed');
            $('#task_' + taskId).find('.complete-task').attr('disabled', 'disabled');
        },
        error: function() {
            alert('Error completing task.');
        }
    });
}

document.querySelectorAll('.complete-task').forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault();
        var taskId = this.getAttribute('data-id');
        
        // Show the completion modal
        document.getElementById('complete-modal').style.display = 'flex';

        // Confirm task completion
        document.getElementById('complete-confirm').addEventListener('click', function() {
            // Execute task completion logic (AJAX or form submission)
            completeTask(taskId);
            document.getElementById('complete-modal').style.display = 'none';
        });

        // Cancel task completion
        document.getElementById('complete-cancel').addEventListener('click', function() {
            document.getElementById('complete-modal').style.display = 'none';
        });
    });
});

// Handle task deletion
document.querySelectorAll('.btn-delete').forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault();
        var form = this.closest('form');
        
        // Show the deletion modal
        document.getElementById('delete-modal').style.display = 'flex';

        // Confirm task deletion
        document.getElementById('delete-confirm').addEventListener('click', function() {
            form.submit();  // Submit the form to delete the task
            document.getElementById('delete-modal').style.display = 'none';
        });

        // Cancel task deletion
        document.getElementById('delete-cancel').addEventListener('click', function() {
            document.getElementById('delete-modal').style.display = 'none';
        });
    });
});

document.getElementById('task-form').addEventListener('submit', function(event) {
    var taskName = document.getElementById('task-name').value;
    var priority = document.getElementById('priority').value;
    var errorMessage = '';

    // Validate task name length (max 100 characters)
    if (taskName.length > 100) {
        errorMessage += 'Task name should not exceed 100 characters.\n';
    }

    // Validate priority (must be selected)
    if (priority < 1 || priority > 3) {
        errorMessage += 'Please select a valid priority.\n';
    }

    // If there are validation errors, show them and prevent form submission
    if (errorMessage) {
        console.log(errorMessage);
        alert(errorMessage);
        event.preventDefault(); // Prevent form submission
    }
});