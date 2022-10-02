<?
$this->setTitle('Каталог интернет-магазина MEGASPORT');
?>
<div class="container row">
	<h2 class="m-t-0">Разделы</h2>
</div>
<div class="row sections">
    <?foreach($result as $category):?>
        <div class="col-sm-6 col-md-4">
            <a href="/megasport/category/<?=$category['id']?>" class="section-link">
                <div class="thumbnail">
                    <img src="../<?=$category['preview_picture']?>" alt="<?=$category['name']?>">
                    <div class="caption">
                        <h3><?=$category['name']?> <span class="badge"><?=$category['product_count']?></span></h3>
                    </div>
                </div>
            </a>
        </div>
    <?endforeach;?>
</div>