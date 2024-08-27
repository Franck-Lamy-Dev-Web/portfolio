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

