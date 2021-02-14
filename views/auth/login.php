<section class="container grey-text">
    <a href="signup">
        <h4 class="center">Login</h4>
    </a>
    <form class="white" action="login" method="POST">
        <label>Username or Email</label>
        <input type="text" name="authKey" value="<?=htmlspecialchars($data['authKey'] ?? '')?>">
        <div class="red-text">
            <?=$errors['authKey'] ?? ''?>
        </div>
        <label>Password</label>
        <input type="password" name="password" value="<?=htmlspecialchars($data['password'] ?? '')?>">
        <div class="red-text">
            <?php if (isset($errors['password']) && $errors['password']): ?>
            <?=$errors['password']?>
            <?php elseif (isset($errors['invalidCredentials'])): ?>
            <?=$errors['invalidCredentials']?>
            <?php endif?>
        </div>
        <div class="center">
            <input type="submit" value="submit" class="btn brand z-depth-0">
        </div>
    </form>
</section>