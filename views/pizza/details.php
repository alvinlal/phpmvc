<div class="container center">
    <?php if ($pizza): ?>
    <h4><?php echo $pizza['title']; ?></h4>
    <p>Created by <?php echo $pizza['username']; ?></p>
    <p><?php echo date($pizza['created_at']); ?></p>
    <h5>Ingredients:</h5>
    <p><?php echo $pizza['ingredients']; ?></p>
    <!-- DELETE FORM -->
    <form action="/delete" method="POST">
        <input type="hidden" name="id_to_delete" value="<?php echo $pizza['id']; ?>">
        <input type="submit" name="delete" value="Delete" class="btn brand z-depth-0">
    </form>
    <?php else: ?>
    <h5>No such pizza exists.</h5>
    <?php endif?>
</div>