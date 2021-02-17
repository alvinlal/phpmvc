<h4 class="center grey-text">Pizzas!</h4>

<div class="container">
    <div class="row">

        <?php foreach ($pizzas as $pizza) {?>

        <div class="col s6 md3">
            <div class="card z-depth-0">
                <div class="card-content center">
                    <h6><?php echo htmlspecialchars($pizza['title']); ?></h6>
                    <ul class="grey-text">
                        <?php foreach (explode(',', $pizza['ingredients']) as $ing) {?>
                        <li><?php echo htmlspecialchars($ing); ?></li>
                        <?php }?>
                    </ul>
                </div>
                <div class="card-action right-align">
                    <a class="brand-text" href="details/<?php echo $pizza['id'] ?>">more info</a>
                </div>
            </div>
        </div>

        <?php }?>

    </div>
</div>