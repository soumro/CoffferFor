<div class="center">
    <h4 class="blue-text">Sign In.</h4>
    <form action="<?= site_url('/signin') ?>" method="post">

        <p>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required="required">
        </p>
        <p>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required="required">
        </p>
        <p>
            <button type="submit" name="signin_submit" class="bold btn-large waves-effect" value="1">
                Sign In
            </button>
        </p>
    </form>
</div>