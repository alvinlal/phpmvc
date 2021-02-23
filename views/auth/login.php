<section class="container grey-text">
    <a href="signup">
        <h4 class="center">Login</h4>
    </a>
    <form class="white" action="/auth/login" method="POST">
        <?php if (isset($_FLASH['notLogedIn'])): ?>
        <div style="margin:auto;text-align:center">
            <p class="red-text" style="font-size: 24px;"><?=$_FLASH['notLogedIn']?></p>
        </div>
        <?php endif?>
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
        <input type="hidden" name="_csrf" value="<?=$_csrfToken?>" />
        <div class="center">
            <input type="submit" value="submit" class="btn brand z-depth-0">
        </div>
    </form>
</section>