<h2><?php echo $title; ?></h2>

<?php foreach ($store as $store_item): ?>

        <h3><?php echo $store_item['name']; ?></h3>
        <div class="main">
                <?php echo $store_item['address']; ?>
        </div>
        <p><a href="<?php echo site_url('form/'.$store_item['slug']); ?>">View store</a></p>

<?php endforeach; ?>
