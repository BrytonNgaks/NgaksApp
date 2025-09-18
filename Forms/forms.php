<?php
class forms{
    private function submit_button($value){
        echo "<input type='submit' class='btn btn-primary' value='{$value}'>";
    }

    public function signup(){
        ?>
        <h2>Signup Form</h2>
        <form action='submit_signup.php' method='post'>
            <label for='username'>Username:</label>
            <input type='text' id='username' name='username' class="form-control" required><br><br>

            <label for='email'>Email:</label>
            <input type='email' id='email' name='email' class="form-control" required><br><br>

            <label for='password'>Password:</label>
            <input type='password' id='password' name='password' class="form-control" required><br><br>

            <?php $this->submit_button('Sign Up'); ?> 
            <a href="login.php" class="btn btn-primary">Already have an account? Log in</a>
        </form>
        <?php
    }

    public function login(){
        ?>
        <h2>Login Form</h2>
        <form action='submit_login.php' method='post'>
            <label for='email'>Email:</label>
            <input type='email' id='email' name='email' class="form-control" required><br><br>

            <label for='password'>Password:</label>
            <input type='password' id='password' name='password' class="form-control" required><br><br>

            <input type='submit' class="btn btn-primary" value='Log In'>
            <a href="index.php" class="btn btn-primary">Don't have an account? Sign up</a>
        </form>
        <br>
        <!-- Admin login button -->
        <a href="login_admin.php" class="btn btn-primary">Login as Admin</a>
        <?php
    }
}
?>
