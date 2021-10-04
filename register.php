<?php if (isset($_POST["firstname"]) && isset($_POST["lastname"]) && isset($_POST["email"]) && isset($_POST["password"])) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tp";
    $port = "3306";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname, $port);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $salt = md5(random_bytes(8));
    $hash = md5($_POST["password"] . $salt);

    $stmt = $conn->prepare("INSERT INTO users (firstname,lastname,email,password,salt) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $firstname, $lastname, $email, $hash, $salt);

    // set parameters and execute
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];

    if ($stmt->execute() === TRUE) {
        echo "New record created successfully";
        $msg = "Welcome to our site, please confirm you subscription here";
    } else {
        echo "Error: " . "<br>" . $conn->error;
    }
    $stmt->close();
    $conn->close();
} else { ?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Register</title>
        <link rel="stylesheet" href="./assets/css/style.css">
    </head>

    <body>
        <div class="form">
            <h1>Register</h1>
            <form action="./register.php" method="POST" id="register-form">
                <label id="empty-error" class="error hide">Required Values needs to filled in</label>

                <div class="form-input">
                    <label>First name * :</label>
                    <input type="text" name="firstname" required>
                </div>

                <div class="form-input">
                    <label>Last name * :</label>
                    <input type="text" name="lastname" required>
                </div>

                <div class="form-input">
                    <label>Email * :</label>
                    <input type="email" name="email" required>
                </div>

                <div class="form-input">
                    <label>Password * : </label>
                    <input id="password" type="password" name="password" pattern="[1-9a-zA-Z@€£$%\^&\*\(\)]{8,}" required>

                </div>
                <label>You passwor should contain at least 8 characters from letters, numbers and any of the characters:@ £ $ % ^ & * ( )</label>
                <div class="form-input">
                    <label>Confirm password* :</label>
                    <input id="password-confirmation" type="password" required>
                </div>
                <label id="incorrect-password" class="error hide">The passwords don't match</label>


                <button id="register-btn" class="register-btn">Register</button>
            </form>
        </div>
        <script>
            let registerBtn = document.querySelector('#register-btn')
            registerBtn.addEventListener('click', (e) => {
                e.preventDefault()
                let valid = checkEmptyValue()
                console.log('ee',valid)

                if(!valid) return
                let password = document.querySelector('#password')
                let passwordConfirmation = document.querySelector('#password-confirmation')
                if (password.value !== passwordConfirmation.value) {
                    let error = document.querySelector('#incorrect-password')
                    error.classList.remove('hide')
                    password.classList.add('input-error')
                    passwordConfirmation.classList.add('input-error')
                } else {
                    let form = document.querySelector('#register-form')
                    form.submit()
                }
            })

            function checkEmptyValue() {
                let inputs = document.querySelectorAll('input')
                let valid = true;
                inputs.forEach(input => {
                    if (input.value === null || input.value === ''){
                        input.classList.add('input-error')
                        document.querySelector('#empty-error').classList.remove('hide')
                        valid = false
                    }else{
                        input.classList.remove('input-error')
                    }
                })
                console.log(valid)
                return valid
            }
        </script>
    </body>

    </html>

<?php } ?>