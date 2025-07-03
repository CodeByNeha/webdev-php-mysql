function validateRegisterForm() {
  const username = document.querySelector('input[name="username"]');
  const email = document.querySelector('input[name="email"]');
  const password = document.querySelector('input[name="password"]');
  const role = document.querySelector('select[name="role"]');

  if (
    !username.value.trim() ||
    !email.value.trim() ||
    !password.value ||
    !role.value
  ) {
    alert("All fields are required.");
    return false;
  }

  if (!email.value.includes("@") || !email.value.includes(".")) {
    alert("Enter a valid email.");
    return false;
  }

  if (password.value.length < 6) {
    alert("Password must be at least 6 characters.");
    return false;
  }

  return true;
}

function validateLoginForm() {
  const email = document.querySelector('input[name="email"]');
  const password = document.querySelector('input[name="password"]');

  if (!email.value.trim() || !password.value.trim()) {
    alert("Email and password are required.");
    return false;
  }

  return true;
}

function validatePostForm() {
  const title = document.querySelector('input[name="title"]');
  const content = document.querySelector('textarea[name="content"]');

  if (!title.value.trim() || !content.value.trim()) {
    alert("Both title and content are required.");
    return false;
  }

  return true;
}
