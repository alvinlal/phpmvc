<section class="container grey-text">
    <a href="add.php">
        <h4 class="center">Add a Pizza</h4>
    </a>
    <form class="white" action="add" method="POST" enctype="multipart/form-data">
        <label>Pizza Title</label>
        <input type="text" name="title" value="<?=htmlspecialchars($data['title'] ?? '')?>">
        <div class="red-text">
            <?=$errors['title'] ?? ''?>
        </div>
        <label>Ingredients (comma separated)</label>
        <input type="text" name="ingredients" value="<?=htmlspecialchars($data['ingredients'] ?? '')?>">
        <div class="red-text">
            <?=$errors['ingredients'] ?? ''?>
        </div><br>
        <label style="margin:15px 0px">Photo</br>
            <div style="margin:15px 0px"><input type="file" name="photo" /></div>
        </label>
        <div class="red-text" style="margin:5px 0px">
            <?php if (isset($errors)): foreach ($errors['photo'] as $error): ?>
            <?php echo sizeof($errors['photo']) === 1 ? $error : "<li>$error</li>" ?>
            <?php endforeach?>
            <?php endif?>
        </div>
        <input type="hidden" name="_csrf" value="<?=$_csrfToken?>" />
        <div style="margin-top:50px" class="center">
            <input type="submit" value="submit" class="btn brand z-depth-0">
        </div>
    </form>
</section>