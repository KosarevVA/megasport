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
	                    <?if(isset($product['ADDITIONAL_FIELDS']) && !empty($product['ADDITIONAL_FIELDS'])):?>
		                    <?foreach($product['ADDITIONAL_FIELDS'] as $field):?>
                                <h4><?=$field['name']?>: <?=$field['value']?></h4>
		                    <?endforeach;?>
	                    <?endif;?>
                        <h4>Цена: <?=$product['price']?> ₽</h4>
                        <?if(isset($product['BASKET'])):?>
	                        <?if($product['BASKET']['COUNT']):?>
                                <p>В корзине <?=$product['BASKET']['COUNT']?> шт.</p>
	                        <?endif;?>
                        <?endif;?>
                        <a href="/megasport/basket/add/<?=$product['id']?>" class="btn btn-success" role="button">В корзину</a>
                    </div>
                </div>
            </a>
        </div>
    <?endforeach;?>
</div>