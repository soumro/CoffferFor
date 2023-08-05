<div class="center">
    <h3 class="capitalize underline blue-text">Sign Up for Free Today.</h3>
    <form action="<?= site_url('/signup') ?>" method="post">
        <p>
            <label for="name">Name</label>
            <input type="text" name="fullname" id="name" required="required">
        </p>
        <p>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required="required">
        </p>
        <p>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required="required">
        </p>
        <p>
            <button type="submit" name="signup_submit" value="1" class="bold btn-large waves-effect">
                Sign Up
            </button>
        </p>
    </form>
</div>