
<a class="info-btn" href="<?=$this->config->base_url()?>form/create" target="_parent">新規作成</a>

<h2><?php echo $title; ?></h2>

<?php foreach ($store as $store_item): ?>

        <h3><?php echo $store_item['name']; ?></h3>
        <div class="main">
                <?php echo $store_item['address']; ?>
        </div>
        <p><a href="<?=$this->config->base_url('form/'.$store_item['id']); ?>">View store</a></p>

<?php endforeach; ?>
