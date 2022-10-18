<?php
$this->setTitle('Мои заказы');
?>
<div class="container-fluid">
	<ul class="list-group">
		<?foreach($result as $order):?>
			<li class="list-group-item">Заказ #<?=$order['id']?>. Создан <?=$order['created_date']?>. Статус -- <?=$order['st_name']?>. Способ оплаты - <?=$order['pt_name']?>(<?=$order['paid']?'Оплачен':'Не оплачен';?>)</li>
		<?endforeach;?>
	</ul>
</div>
