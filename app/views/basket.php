<?
$this->setTitle('Корзина');
?>
<div class="container-fluid">
	<div class="container col-lg-8 col-md-7 col-sm-6">
		<?foreach($result['BASKET'] as $basketItem):?>
            <div class="list-group" id="<?=$basketItem['id']?>">
                <a href="<?=$basketItem['detail_page']?>" class="list-group-item">
                    <h4 class="list-group-item-heading"><?=$basketItem['name']?></h4>
                    <p class="list-group-item-text">Цена: <?=$basketItem['price']?> ₽</p>
                    <div class="container row">
                        <p class="list-group-item-text" id="count_<?=$basketItem['id']?>">Количество: <?=$basketItem['count']?> шт.</p>
                        <button class="btn btn-danger count-minus" role="button" id="<?=$basketItem['id']?>">-</button>
                        <button class="btn btn-success count-plus" role="button" id="<?=$basketItem['id']?>">+</button>
                    </div>
                    <p class="list-group-item-text" id="price_<?=$basketItem['id']?>">Стоимость: <?=$basketItem['full_price']?> ₽</p>
                </a>
            </div>
        <?endforeach;?>
	</div>
	<div class="container col-lg-4 col-md-5 col-sm-6">
		<h4>Оформление заказа</h4>
		<p id="order_price">К оплате: <?=$result['ORDER_PRICE']?> ₽</p>
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
<script>
$('.count-plus').on('click', function (element) {
    element.preventDefault();
    let productId = element.currentTarget.id;
    $.ajax({
        url: '/megasport/basket/plus/',
        method: 'post',
        dataType: 'json',
        data: {
            productId: productId
        },
        success: function(data){
            if(data.STATUS)
            {
                $('p[id=count_' + productId + ']').html('Количество: ' + data.COUNT + ' шт.');
                $('p[id=price_' + productId + ']').html('Стоимость: ' + data.PRICE + ' ₽');
                $('p[id=order_price]').html('К оплате: ' + data.ORDER_PRICE + ' ₽');
            }
        }
    });
});
$('.count-minus').on('click', function (element) {
    element.preventDefault();
    let productId = element.currentTarget.id;
    $.ajax({
        url: '/megasport/basket/minus/',
        method: 'post',
        dataType: 'json',
        data: {
            productId: productId
        },
        success: function(data){
            if(data.STATUS)
            {
                if(data.COUNT === 0)
                {
                    $('div[id=' + productId + ']').remove();
                }

                $('p[id=count_' + productId + ']').html('Количество: ' + data.COUNT + ' шт.');
                $('p[id=price_' + productId + ']').html('Стоимость: ' + data.PRICE + ' ₽');
                $('p[id=order_price]').html('К оплате: ' + data.ORDER_PRICE + ' ₽');
            }
        }
    });
});
</script>
