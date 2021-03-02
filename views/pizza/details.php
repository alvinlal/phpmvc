<div class="container center">
    <?php if ($pizza): ?>
    <div class="details">
        <div class="pizza-image">
            <img src="/images/pizzas/<?=$pizza['filename']?>" />
        </div>
        <div class="pizza-details">
            <h3><?=$pizza['title']?></h3>
            <h5>Ingredients:</h5>
            <p><?php echo $pizza['ingredients']; ?></p>
            <p>Created by <?php echo $pizza['username']; ?></p>
            <form action="/delete" method="POST">
                <input type="hidden" name="id_to_delete" value="<?php echo $pizza['id']; ?>">
                <input type="hidden" name="_csrf" value="<?=$_csrfToken?>" />
                <input type="submit" name="delete" value="Delete" class="btn brand z-depth-0">
            </form>
        </div>

        <?php else: ?>
        <h5>No such pizza exists.</h5>
        <?php endif?>
    </div>