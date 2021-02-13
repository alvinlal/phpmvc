<section class="container grey-text">
    <a href="signup">
        <h4 class="center">Login</h4>
    </a>
    <form class="white" action="add" method="POST">
        <label>Username or Email</label>
        <input type="text" name="authKey" value="<?=htmlspecialchars($data['email'] ?? '')?>">
        <div class="red-text">
            <?=$errors['email'] ?? ''?>
        </div>
        <label>Password</label>
        <input type="password" name="password" value="<?=htmlspecialchars($data['password'] ?? '')?>">
        <div class="red-text">
            <?=$errors['password'] ?? ''?>
        </div>
        <div class="center">
            <input type="submit" value="submit" class="btn brand z-depth-0">
        </div>
    </form>
</section>