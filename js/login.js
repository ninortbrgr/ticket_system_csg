document.getElementById("loginForm").addEventListener("submit", async function (e) {
  e.preventDefault();
  const username = document.getElementById("username").value;
  const password = document.getElementById("password").value;

  const formData = new FormData();
  formData.append("username", username);
  formData.append("password", password);

  const response = await fetch("../php/login.php", {
    method: "POST",
    body: formData,
    redirect: "follow"
  });

  // If the server redirected (PHP currently redirects on success/failure), handle accordingly
  if (response.redirected) {
    // if redirected back to login with error flag, show message instead of navigating
    if (response.url && response.url.includes("error=1")) {
      document.getElementById("errorMsg").innerText = "Login fehlgeschlagen!";
      return;
    }
    window.location.href = response.url;
    return;
  }

  const contentType = response.headers.get("content-type") || "";
  if (contentType.includes("application/json")) {
    const result = await response.json();
    if (result.success) {
      window.location.href = "../php/admin.php";
    } else {
      document.getElementById("errorMsg").innerText = "Login fehlgeschlagen!";
    }
  } else {
    const text = await response.text();
    if (text.includes("Benutzerdaten fehlen") || text.includes("error=1")) {
      document.getElementById("errorMsg").innerText = "Login fehlgeschlagen!";
    } else if (response.url && response.url.includes("admin.php")) {
      window.location.href = response.url;
    } else {
      document.getElementById("errorMsg").innerText = "Server-Antwort unklar.";
    }
  }
});
