document.getElementById("loginForm").addEventListener("submit", async function (e) {
  e.preventDefault();
  const username = document.getElementById("username").value;
  const password = document.getElementById("password").value;

  const formData = new FormData();
  formData.append("username", username);
  formData.append("password", password);

  const response = await fetch("backend/login.php", {
    method: "POST",
    body: formData
  });

  const result = await response.json();
  if (result.success) {
    window.location.href = "admin.php";
  } else {
    document.getElementById("errorMsg").innerText = "Login fehlgeschlagen!";
  }
});