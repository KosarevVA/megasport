<?
$this->setTitle($result['CATEGORY']['name'] . ' - каталог интернет-магазина MEGASPORT');
?>
<div class="container row">
	<h2><?=$result['CATEGORY']['name']?></h2>
</div>
<div class="row">
    <?foreach ($result['PRODUCTS'] as $product):?>
        <div class="col-sm-6 col-md-4">
            <a href="/megasport/product/<?=$product['id']?>" class="section-link">
                <div class="thumbnail">
                    <img src="../<?=$product['preview_picture']?>" alt="<?=$product['name']?>">
                    <div class="caption">
                        <h3><?=$product['name']?></h3>
                        <p><?=$product['description']?></p>
                        <h4>Цена: <?=$product['price']?> ₽</h4>
                        <p><a href="/megasport/basket/add/<?=$product['id']?>" class="btn btn-success" role="button">В корзину</a></p>
                    </div>
                </div>
            </a>
        </div>
    <?endforeach;?>
</div>