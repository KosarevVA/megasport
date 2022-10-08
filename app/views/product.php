<?
$this->setTitle($result['name'] . ' - каталог интернет-магазина MEGASPORT');
?>
<div class="container row">
	<h2 class="m-t-0"><?=$result['name']?></h2>
</div>
<div class="row">
	<div class="container col-sm-12 col-md-8 col-lg-7">
		<div class="thumbnail">
            <img src="../<?=$result['preview_picture']?>" alt="<?=$result['name']?>">
		</div>
		<div>
			<p><?=$result['description']?></p>
			<h4>Характеристики</h4>
			<p>Габариты(Ш,В,Д): <?=$result['width'] . ',' . $result['height'] . ',' . $result['length']?></p>
			<p>Гаррантия, лет: <?=$result['warranty']?></p>
			<?if(isset($result['ADDITIONAL_FIELDS']) && !empty($result['ADDITIONAL_FIELDS'])):?>
                <?foreach($result['ADDITIONAL_FIELDS'] as $field):?>
                    <p><?=$field['name']?>: <?=$field['value']?></p>
                <?endforeach;?>
            <?endif;?>
		</div>
	</div>
	<div class="container col-sm-12 col-md-4 col-lg-5">
		<div class="thumbnail">
			<h2 class="m-t-0"><?=$result['name']?></h2>
			<p>Артикул: LU088523/LU073824</p>
			<?if($result['availability']):?>
                <div class="alert alert-success" role="alert">В наличии</div>
			<?else:?>
                <div class="alert alert-danger" role="alert">Нет в наличии</div>
            <?endif;?>
			<?if($result['VATincluded']):?>
                <p>НДС включен в стоимость</p>
			<?endif;?>
			<p>Доставка по Москве и МО - бесплатно</p>
			<p>Доставка по России транспортными компаниями</p>
			<h4>Цена: <?=$result['price']?> ₽</h4>
			<?if($result['availability']):?>
                <a href="/megasport/basket/add/<?=$result['id']?>" class="btn btn-success">В корзину</a>
			<?else:?>
                <a href="#" class="btn btn-danger disabled">В корзину</a>
			<?endif;?>
		</div>
	</div>
</div>