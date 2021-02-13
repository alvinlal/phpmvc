<section class="container grey-text">
    <a href="signup">
        <h4 class="center">Signup</h4>
    </a>
    <?php if ($success): ?>
    <div style="margin:auto;text-align:center">
        <p class="green-text" style="font-size: 24px;">Signup was successfull!</p>
    </div>
    <?php endif?>
    <form class="white" action="signup" method="POST">
        <label>Name</label>
        <input type="text" name="name" value="<?=htmlspecialchars($data['name'] ?? '')?>">
        <div class="red-text">
            <?=$errors['name'] ?? ''?>
        </div>
        <label>Username</label>
        <input type="text" name="username" value="<?=htmlspecialchars($data['username'] ?? '')?>">
        <div class="red-text" style="margin:5px 0px">
            <?=$errors['username'] ?? ''?>
        </div>
        <label>Email</label>
        <input type="text" name="email" value="<?=htmlspecialchars($data['email'] ?? '')?>">
        <div class="red-text">
            <?=$errors['email'] ?? ''?>
        </div>
        <label>Password</label>
        <input type="password" name="password" value="<?=htmlspecialchars($data['password'] ?? '')?>">
        <div class="red-text" style="margin:5px 0px">
            <?php if (isset($errors) && $errors['password'] != ''): foreach ($errors['password'] as $error): ?>
            <?php echo sizeof($errors['password']) === 1 ? $error : "<li>$error</li>" ?>
            <?php endforeach?>
            <?php endif?>
        </div>
        <label>Confirm Password</label>
        <input type="password" name="confirmPassword" value="<?=htmlspecialchars($data['confirmPassword'] ?? '')?>">
        <div class="red-text">
            <?=$errors['confirmPassword'] ?? ''?>
        </div>
        <div class="center">
            <input type="submit" value="submit" class="btn brand z-depth-0">
        </div>
    </form>
</section>