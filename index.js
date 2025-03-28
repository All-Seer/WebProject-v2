document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('studentForm');
  const submitButton = document.getElementById('submitButton');
  const dialog = document.getElementById('autoCloseDialog');

  submitButton.addEventListener('click', async (e) => {
    e.preventDefault();

    if (!form.checkValidity()) {
      form.reportValidity();
      return;
    }
    

    const formData = {
      firstName: form.firstName.value,
      middleName: form.middleName.value || null,
      lastName: form.lastName.value,
      studentId: form.studentID.value,
      personalEmail: form.personalEmail.value,
      phinmaedEmail: form.phinmaedEmail.value,
      concern: form.concern.value
    };

    try {
      const response = await fetch('/WebProject-v2/api/submit_concern.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(formData)
      });

      // First check if response is JSON
      const contentType = response.headers.get('content-type');
      if (!contentType || !contentType.includes('application/json')) {
        const text = await response.text();
        throw new Error(`Server returned non-JSON: ${text.substring(0, 100)}`);
      }

      const result = await response.json();

      if (!response.ok || !result.success) {
        throw new Error(result.message || `Server error: ${response.status}`);
      }

      // Show success
      dialog.show();
      setTimeout(() => {
        dialog.close();
        form.reset();
      }, 3000);

    } catch (error) {
      console.error('Submission error:', error);
      alert(`Error: ${error.message}\n\nPlease check your inputs and try again.`);
    }
  });
});