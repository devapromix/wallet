<?php

session_start();

$index = $_GET['index'];
$add_product_id = $_GET['add'];

if ($add_product_id > 0) {
	$_SESSION['cart'][$add_product_id] = 1;
}

include('header.php');

?>
        <!-- Section-->
        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                
				<table><tr><td>
                    <?php
					$filename = 'products/'.$index.'.json';
					$json = json_decode(file_get_contents($filename), true);
					echo '<p><a href="index.php">Домівка</a> / '.$json['title'].'</p>';
					echo '<img width="400" height="300" src="./products/images/'.$json['image'].'" />';
					?>
					</td><td valign="top">
					<div>
					<h1><?php echo $json['title'];?></h1>
					<h1><?php echo $json['price'];?> ₴</h1>

					<?php
								if ($_SESSION['cart'][pathinfo($filename, PATHINFO_FILENAME)] > 0) {
									$p .= '<a class="btn btn-outline-dark mt-auto" href="cart.php">Переглянути кошик</a>';									
								} else {
									$p .= '<a class="btn btn-outline-dark mt-auto" href="product.php?index='.pathinfo($filename, PATHINFO_FILENAME).'&add='.pathinfo($filename, PATHINFO_FILENAME).'">Додати в кошик</a>';
								}
						echo $p;
					?>
					</div>
				</td></tr></table>
					
					

					
               
            </div>
        </section>
		<?php include('footer.php'); ?>

