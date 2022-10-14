<?
$this->setTitle('Корзина');
?>
<div class="container-fluid">
	<div class="container col-lg-8 col-md-7 col-sm-6">
		<?foreach($result['BASKET'] as $basketItem):?>
            <div class="list-group">
                <a href="<?=$basketItem['detail_page']?>" class="list-group-item">
                    <h4 class="list-group-item-heading"><?=$basketItem['name']?></h4>
                    <p class="list-group-item-text">Цена: <?=$basketItem['price']?> ₽</p>
                    <div class="container row">
                        <p class="list-group-item-text">Количество: <?=$basketItem['count']?> шт.</p>
                        <button class="btn btn-danger" role="button">-</button>
                        <button class="btn btn-success" role="button">+</button>
                    </div>
                    <p class="list-group-item-text">Стоимость: <?=$basketItem['full_price']?> ₽</p>
                </a>
            </div>
        <?endforeach;?>
	</div>
	<div class="container col-lg-4 col-md-5 col-sm-6">
		<h4>Оформление заказа</h4>
		<p>К оплате: <?=$result['ORDER_PRICE']?> ₽</p>
        <form action="/megasport/orders/create/" method="post">
            <h4>Доставка</h4>
            <label for="exampleDataList" class="form-label">Транспортная компания</label>
            <input class="form-control" list="deliveryOptions" id="exampleDataList" placeholder="Выберите транспортную компанию..." name="delivery_type">
            <datalist id="deliveryOptions">
                <option value="СДЭК">
            </datalist>
            <label for="exampleDataList" class="form-label">Город</label>
            <input class="form-control" list="datalistOptions" id="exampleDataList" placeholder="Выберите город..." name="city">
            <datalist id="datalistOptions">
                <option value="Москва">
            </datalist>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Адрес</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="ул. Большая д.9 кв.78" name="address">
            </div>
            <h4>Способ оплаты</h4>
            <label for="exampleDataList" class="form-label">Способ оплаты</label>
            <input class="form-control" list="paymentsOptions" id="exampleDataList" placeholder="Выберите спопоб оплаты" name="payment_type">
            <datalist id="paymentsOptions">
                <option value="Онлайн картой">
            </datalist>
            <button class="btn btn-success" style="margin-top: 20px">Оформить</button>
        </form>
	</div>
</div>
