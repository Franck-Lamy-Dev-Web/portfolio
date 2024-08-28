let darkMode = false;

function changeDarkMode() {
  if (darkMode) {
    darkMode = false;
    document.documentElement.style.setProperty("--text-color", "#1E1E2F");
    document.documentElement.style.setProperty("--background-color", "#efe7e5");
    document.getElementById("dark-light-mode").innerHTML = "Dark mode";
  } else {
    darkMode = true;
    document.documentElement.style.setProperty("--text-color", "white");
    document.documentElement.style.setProperty("--background-color", "#1E1E2F");
    document.getElementById("dark-light-mode").innerHTML = "Light mode";
  }
}


document.getElementById('contactForm').addEventListener('submit', function(e) {
  e.preventDefault(); // Empêche l'envoi normal du formulaire

  const formData = new FormData(this);

  fetch('http://localhost/Portefolio/submit_form.php', {
      method: 'POST',
      body: formData,
  })
  .then(response => response.json())
  .then(data => {
      if (data.message) {
          // Remplace le formulaire par un message de succès
          document.querySelector('.formulaire').innerHTML = '<p class="success-message">Demande envoyée avec succès!</p>';
      } else if (data.error) {
          // Affiche le message d'erreur
          document.querySelector('.formulaire').innerHTML = `<p class="error-message">${data.error}</p>`;
      }
  })
  .catch(error => {
      console.error('Erreur:', error);
      document.querySelector('.formulaire').innerHTML = '<p class="error-message">Une erreur est survenue lors de l\'envoi de votre demande.</p>';
  });
});

