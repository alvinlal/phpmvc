<section class="container grey-text">
    <a href="add.php">
        <h4 class="center">Add a Pizza</h4>
    </a>
    <form class="white" action="add" method="POST">
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
        <div class="center">
            <input type="submit" value="submit" class="btn brand z-depth-0">
        </div>
    </form>
</section>