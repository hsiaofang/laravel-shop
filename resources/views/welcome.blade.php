<!DOCTYPE html>
<html>

<head>
  <title>登入</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>

  <form method="post" class="login-container" id="login">
    @csrf 

    <div>
      <label for="userName">帳號：
        <input type="text" id="userName" name="userName" required>
      </label>
    </div>
    <div>
      <label for="email">信箱：
        <input type="text" id="email" name="email" required>
      </label>
    </div>
    <div>
      <label for="password">密碼：
        <input type="password" id="password" name="password" required>
      </label>
    </div>
    <button type="button" id="registerButton">註冊</button>
    <button type="button" id="loginButton">登入</button><br>
  </form>

  <script>
    function registerUser(userData) {
        fetch('/register', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(userData)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log(data.message);
        })
        .catch(error => {
            console.error('There has been a problem with your fetch operation:', error);
        });
    }

    document.getElementById('registerButton').addEventListener('click', function() {
    const username = document.getElementById('userName').value;
    const email = document.getElementById('email').value; 
    const password = document.getElementById('password').value;

    const userData = {
      username: username,
      email: email,
      password: password
    };

    registerUser(userData);
  });

  function loginUser(userData) {
      fetch('/login', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(userData)
      })
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.json();
      })
      .then(data => {
        console.log(data.message);
        localStorage.setItem('userId', data.user.id);
        window.location.href = 'http://127.0.0.1:8000/products'; 

      })
      .catch(error => {
        console.error('There has been a problem with your fetch operation:', error);
      });
    }

    document.getElementById('loginButton').addEventListener('click', function() {
      const username = document.getElementById('userName').value;
      const email = document.getElementById('email').value; 
      const password = document.getElementById('password').value;

      const userData = {
        username: username,
        email: email,
        password: password
      };

      loginUser(userData);
    });
  </script>
</body>

</html>
