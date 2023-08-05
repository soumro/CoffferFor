<div class="center">
    <h4 class="blue-text">Update Password</h4>
    <form action="<?= site_url('/account/password') ?>" method="post">
        <p>
            <label for="current_password">Current Password:</label>
            <input type="password" name="current_password" id="current_password" required="required">
        </p>
        <p>
            <label for="new_password">New Password:</label>
            <input type="password" name="new_password" id="new_password" required="required">
        </p>
        <p>
            <label for="confirm_password">Password:</label>
            <input type="password" name="confirm_password" id="confirm_password" required="required">
        </p>
        <button type="input" name="password_submit" class="bold btn-large waves-effect" value="1">
            Update
        </button>
    </form>
</div>