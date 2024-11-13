document.addEventListener('DOMContentLoaded', () => {
    // Example: Confirm form submission
    const form = document.querySelector('form');
    if(form){
        form.addEventListener('submit', (e) => {
            const confirmSubmit = confirm('Are you sure you want to submit the application?');
            if(!confirmSubmit){
                e.preventDefault();
            }
        });
    }
});