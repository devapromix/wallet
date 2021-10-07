<?php

session_start();

$add_product_id = $_GET['add'];

if ($add_product_id > 0) {
	$_SESSION['cart'][$add_product_id] = 1;
}

include('header.php');

?>
        <!-- Section-->
        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    
					
					<?php
						$arr = array("products");
						$format  = ".json";

						for($x=0;$x<count($arr);$x++){
							$mm = $arr[$x];
							
						$product = array();
						foreach (glob("$mm/*$format") as $filename) {
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
									$p .=$json['price'].' ₴';
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
									$p .= '<a class="btn btn-outline-dark mt-auto" href="cart.php">Переглянути кошик</a>';									
								} else {
									$p .= '<a class="btn btn-outline-dark mt-auto" href="index.php?add='.pathinfo($filename, PATHINFO_FILENAME).'">В кошик</a>';
								}
								$p .= '</div>';
                            $p .= '</div>';
                        $p .= '</div>';
                    $p .= '</div>';
							echo $p;
						}
					}
					?>
					

					
                </div>
            </div>
        </section>
		<?php echo file_get_contents('footer.html')?>

