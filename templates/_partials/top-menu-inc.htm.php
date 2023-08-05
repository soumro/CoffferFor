<?php use coffeforme\Kernel\Http\Router ?>
<nav class="light-blue lighten-1" role="navigation">
    <div class="nav-wrapper container">
        <a id="logo-container" href="<?= site_url() ?>" class="brand-logo">
            <?= site_name() ?>
        </a>
        <ul class="right hide-on-med-and-down">

            <?php if (!empty($isLoggedIn) && $isLoggedIn === true): ?>
                <li <?= Router::doesContain('account/edit') ? 'class="active"' : '' ?>>
                    <a href="<?= site_url('/account/edit') ?>">Edit</a>
                </li>
                <li <?= Router::doesContain('account/password') ? 'class="active"' : '' ?>>
                    <a href="<?= site_url('/account/password') ?>">Password</a>
                </li>
                <li <?= Router::doesContain('payment') ? 'class="active"' : '' ?>>
                    <a href="<?= site_url('/payment') ?>">Payment</a>
                </li>
                <li <?= Router::doesContain('item') ? 'class="active"' : '' ?>>
                    <a href="<?= site_url('/item') ?>">Item</a>
                </li>
                <li>
                    <a href="<?= site_url('/account/logout') ?>">Logout</a>
                </li>

            <?php else: ?>

                <li <?= Router::doesContain('signin') ? 'class="active"' : '' ?>>
                    <a href="<?= site_url('/signin') ?>">Sign In</a>
                </li>
                <li <?= Router::doesContain('signup') ? 'class="active"' : '' ?>>
                    <a href="<?= site_url('/signup') ?>">Sign Up</a>
                </li>
            <?php endif ?>
        </ul>

        <!-- <ul id="nav-mobile" class="side-nav">
            <li><a href="#">Navbar Link</a></li>
        </ul>
        <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a> -->
    </div>
</nav>