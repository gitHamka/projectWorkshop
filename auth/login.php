<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login-php</title>
    <link rel="stylesheet" href="projectWorkshop/assets/css/style.css">
</head>
<body>
    <header>
        <div id="logo">
            <a href="../index.php"><label>GREENRIDE CAMPUS</label></a>
        </div>
    </header>

    <main>

        <section>
            <label>Go Together, Save Forever</label>
        </section>

        <section>
            <div>
                <a href="../index.php">
                    <button>close</button>
                </a>
            </div>

            <div>
                <h2>LOGIN TO YOUR ACCOUNT</h2>
            </div>

            <form class="login-form" action="process_login.php" method="POST">

                <input type="text" name="id" placeholder="Matric / Staff ID">
                <input type="text" name="password" placeholder="Password">
                <button type="submit" >Login</button>

                <label>
                    Don't have an account? <a href="signup.php">Sign Up</a>
                </label>
            </form>
        </section>
    </main>
</body>
</html>