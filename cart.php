<?php

session_start();

$del_product_id = $_GET['del'];

if ($del_product_id > 0) {
	unset($_SESSION['cart'][$del_product_id]);
	
}
$sum = 0;
$count = 0;
if (count($_SESSION['cart']) > 0) {
	$count = count($_SESSION['cart']);
	foreach($_SESSION['cart'] as $key => $value) {
		$filename = 'products/'.$key.'.json';
		$json = json_decode(file_get_contents($filename), true);
		$sum = $sum + $json['price'];
	}
}					

include('header.php');

?>
        <!-- Section-->
        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
				<p><a href="index.php">Домівка</a> / Кошик замовлень</p>
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    <div class="col mb-5">
					<div class="card h-100">
					<form action="my-handling-form-page" method="post">
					<b>Оформлення замовлення:</b></br>
                    <div class="card-body p-4">
						<label for="name">Ім'я та Прізвище:</label>
						<input type="text" id="name" name="user_name">
						<label for="mail">E-mail:</label>
						<input type="email" id="mail" name="user_mail">
						<label for="phone">Телефон:</label>
						<input type="text" id="phone" name="user_phone">
						<label for="adr">Адреса доставки:</label>
						<textarea id="adr" name="user_address"></textarea>
						<label for="msg">Коментрій до заказу:</label>
						<textarea id="msg" name="user_message"></textarea>


					<b>Товарів: <?php echo $count;?> шт</b></br>
					<b>До сплати без доставки: <h2><?php echo $sum;?></h2> грн.</b>
					</div>
					
					<div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
					<div class="text-center">
					<button class="btn btn-outline-dark" type="submit">Підтвердити замовлення</button>
					</div>
					</div>
					
					</form>
					</div>
					</div>
					
					<?php
					$p = '';
					if (count($_SESSION['cart']) > 0) {
					foreach($_SESSION['cart'] as $key => $value) {
						$filename = 'products/'.$key.'.json';
						$json = json_decode(file_get_contents($filename), true);
						$p = '';
						$p .= '<div class="col mb-5">';
                        $p .= '<div class="card h-100">';
						if ($json['old_price'] > 0){
                            $p .= '<div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Ціна знижена</div>';
						}
						if ($json['image'] == '') {
							$p .= '<img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="..." />';
						} else {
							$p .= '<img class="card-img-top" src="./products/images/'.$json['image'].'" alt="..." />';
						}
                        $p .= '<div class="card-body p-4">';
                                $p .= '<div class="text-center">';
                                    $p .= '<h5 class="fw-bolder"><a href="product.php?index='.pathinfo($filename, PATHINFO_FILENAME).'">'.$json['title'].'</a></h5>';
									if ($json['old_price'] > 0){
										$p .= '<span class="text-muted text-decoration-line-through">'.$json['old_price'].' ₴</span> ';
									}
									$p .= $json['price'].' ₴';
                                    if ($json['rating'] > 0){
										$p .= '<div class="d-flex justify-content-center small text-warning mb-2">';
										for($i = 0; $i < $json['rating']; $i++){
											$p .= '<div class="bi-star-fill"></div>';
										}
										$p .= '</div>';
									}
                                $p .= '</div>';
                            $p .= '</div>';
                            $p .= '<div class="card-footer p-4 pt-0 border-top-0 bg-transparent">';
                                $p .= '<div class="text-center">';
								if ($_SESSION['cart'][pathinfo($filename, PATHINFO_FILENAME)] > 0) {
									$p .= '<a class="btn btn-outline-dark mt-auto" href="cart.php?del='.$key.'">Видалити з кошика</a>';									
								}
								$p .= '</div>';
                            $p .= '</div>';
                        $p .= '</div>';
                    $p .= '</div>';
							echo $p;
						}
					} else {
						echo '<h2>Ваш кошик порожній!</h2>';
					}
				?>

                </div>
            </div>
        </section>
		<?php include('footer.php'); ?>

