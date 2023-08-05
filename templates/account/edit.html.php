<div class="center">
    <h4 class="blue-text">Update Account</h4>
    <form action="<?= site_url('/account/edit') ?>" method="post">
        <p>
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="<?= $view->escape($user->fullname) ?>" required="required">
        </p>
        <p>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?= $view->escape($user->email) ?>" required="required">
        </p>

        <button type="submit" name="edit_submit" class="bold btn-large waves-effect" value="1">
            Save
        </button>
    </p>
</form></div>

