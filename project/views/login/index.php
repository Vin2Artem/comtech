<form action="" method="post" id="mainForm">
  <div>
    <img src="\project\webroot\images\logo.svg" alt="Avatar" class="logo-login">
  </div>

  <div>
    <label for="uname"><b>Имя пользователя</b></label>
    <input type="email" placeholder="my_email@mail.ru" name="login" autocomplete="email" required>

    <label for="psw"><b>Пароль</b></label>
    <input type="password" placeholder="•••••••••" name="pass" required>

    <label class="remember">
      <input type="checkbox" checked="checked" name="remember" class="remember-chkbox">Запомнить меня
    </label>

    <button type="submit" class="btn-green">Войти</button>
  </div>

  <div class="forgot">
    <span class="psw"><a href="#">Забыли пароль?</a></span>
  </div>

  <div id="errBlock">
  </div>
</form>

<style>
  .logo-login {
    margin: auto;
    filter: hue-rotate(90deg);
    display: block;
    margin: -10vh auto 50px;
  }

  body {
    height: 100vh;
    display: flex;
  }

  .container {
    padding: 0 10px;
    margin: auto;
  }

  form {
    max-width: 500px;
  }

  input[type=email],
  input[type=password] {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
    color: #333;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }

  .remember-chkbox {
    margin-right: 10px;
  }

  .btn-green {
    width: 100%;
  }

  .remember {
    margin: 10px 0 18px;
    display: inline-block;
  }

  .psw {
    margin: 15px 0;
    display: inline-block;
    font-size: 17px;
  }

  .errMsg {
    color: red;
    font-size: 20px;
  }

  .forgot {
    text-align: center;
  }
</style>

<script>
  function validateForm(form) {
    const emailInput = form.querySelector('input[type="email"]');
    const passwordInput = form.querySelector('input[type="password"]');
    let errors = [];
    if (emailInput.value.trim() === '') {
      errors.push('Email не может быть пустым');
    }
    if (passwordInput.value.trim() === '') {
      errors.push('Пароль не может быть пустым');
    }
    if (errors.length > 0) {
      return `<ul>${errors.map(error => `<li>${error}</li>`).join('')}</ul>`;
    } else {
      return true;
    }
  }
</script>

<script src="/project/webroot/scripts/main.js"></script>