<?php 
/******************************************************
 * @package Pav Product Tabs module for Opencart 1.5.x
 * @version 1.0
 * @author http://www.pavothemes.com
 * @copyright	Copyright (C) Feb 2012 PavoThemes.com <@emai:pavothemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/

	$span = 12/$cols; 
	$active = 'latest';
	$id = rand(1,9)+rand();	
	$categoryConfig = array( 
		'category_pzoom'				     => 1,
		'show_swap_image'					 => 1,
		'quickview' => 1,
	); 
	$themeConfig = $this->config->get('themecontrol');
	$categoryConfig  = array_merge($categoryConfig, $themeConfig );
	$categoryPzoom 	    = $categoryConfig['category_pzoom']; 
	$quickview = $categoryConfig['quickview'];
	$this->language->load( 'module/themecontrol' ); 
?>
<div class="box producttabs">
<?php if( !empty($module_description) ) { ?>
 <div class="module-desc">
	<?php echo $module_description;?>
 </div>
 <?php } ?>
  <div class="tab-nav">
	<ul class="nav nav-tabs" id="producttabs<?php echo $id;?>">
		<?php foreach( $tabs as $tab => $products ) { if( empty($products) ){ continue;}  ?>
			 <li><a href="#tab-<?php echo $tab.$id;?>" data-toggle="tab"><?php echo $this->language->get('text_'.$tab)?></a></li>
		<?php } ?>
	</ul>
  </div>
	

	<div class="tab-content">
		<?php foreach( $tabs as $tab => $products ) { 
				if( empty($products) ){ continue;}
			?>
			<div class="tab-pane box-products  tabcarousel<?php echo $id; ?> slide" id="tab-<?php echo $tab.$id;?>">
				
				<?php if( count($products) > $itemsperpage ) { ?>
				<div class="carousel-controls">
				<a class="carousel-control left" href="#tab-<?php echo $tab.$id;?>"   data-slide="prev"> prev</a>
				<a class="carousel-control right" href="#tab-<?php echo $tab.$id;?>"  data-slide="next"> next</a>
				</div>
				<?php } ?>
				<div class="carousel-inner ">		
				 <?php 
					$pages = array_chunk( $products, $itemsperpage);
				//	echo '<pre>'.print_r( $pages, 1 ); die;
				 ?>	
				  <?php foreach ($pages as  $k => $tproducts ) {   ?>
						<div class="item <?php if($k==0) {?>active<?php } ?>">
							<?php foreach( $tproducts as $i => $product ) {  $i=$i+1;?>
								<?php if( $i%$cols == 1 ) { ?>
								  <div class="row box-product">
								<?php } ?>
									  <div class="col-lg-<?php echo $span;?> col-md-<?php echo $span;?> col-sm-6 col-xs-12">
										<div class="product-block">			
									  	<div class="product-inner">
										<?php if ($product['thumb']) { ?>


										<div class="image"><?php if( $product['special'] ) {   ?>
	    	<span class="product-label-special label"><span class="special"><?php echo $this->language->get( 'text_sale' ); ?></span></span>
	    	<?php } ?>
	    	<a class="img" href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" title="<?php echo $product['name']; ?>" alt="<?php echo $product['name']; ?>" /></a>
	      	<?php if( $categoryPzoom ) { $zimage = str_replace( "cache/","", preg_replace("#-\d+x\d+#", "",  $product['thumb'] ));  ?>
									      	<a href="<?php echo $zimage;?>" class="colorbox product-zoom hidden" title="<?php echo $product['name']; ?>"><span class="fa fa-search-plus"></span></a>
	      	<?php } ?>
									    	<?php 
      			if( $categoryConfig['show_swap_image'] ){
            $product_images = $this->model_catalog_product->getProductImages( $product['product_id'] );
        if(isset($product_images) && !empty($product_images)) {
          $thumb2 = $this->model_tool_image->resize($product_images[0]['image'],  $this->config->get('config_image_product_width'),  $this->config->get('config_image_product_height') );
        ?>  
									    	<span class="hover-image">
					<a class="img-back" href="<?php echo $product['href']; ?>"><img src="<?php echo $thumb2; ?>" alt="<?php echo $product['name']; ?>"></a>
											</span>
        <?php } } ?>
									    </div>
										<?php } ?>
										<div class="product-meta">
											<div class="warp-info">
												<h3 class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h3>
												<div class="description">
													<?php echo utf8_substr( strip_tags($product['description']),0,58);?>...
												</div>
												<?php if ($product['price']) { ?>
												<div class="price">
												  <?php if (!$product['special']) { ?>
												  <?php echo $product['price']; ?>
												  <?php } else { ?>
												  <span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
												  <?php } ?>
												</div>
												<?php } ?>
											</div>

											<div class="product-action"> 				     
											   	<div class="cart">
										      	<i class=" fa fa-shopping-cart"></i>
										        <input type="button" value="<?php echo $button_cart; ?>" onclick="addToCart('<?php echo $product['product_id']; ?>');" class="button" />
											    </div>
											    <div class="wishlist-compare">
												  <a class="wishlist fa fa-heart" onclick="addToWishList('<?php echo $product['product_id']; ?>');" title="<?php echo $this->language->get("button_wishlist"); ?>" ><span><?php echo $this->language->get("button_wishlist"); ?></span></a>
												  <a class="compare fa fa-retweet"  onclick="addToCompare('<?php echo $product['product_id']; ?>');" title="<?php echo $this->language->get("button_compare"); ?>" ><span><?php echo $this->language->get("button_compare"); ?></span></a>
												</div>
											</div>
											<?php if ($quickview) { ?>
											<a class="pav-colorbox" href="<?php echo $this->url->link("themecontrol/product",'product_id='.$product['product_id'] );?>"><span class='fa fa-plus'></span><?php echo $this->language->get('quick_view'); ?></a>
											<?php } ?>
										</div>




									  </div></div></div>
							  
							  <?php if( $i%$cols == 0 || $i==count($tproducts) ) { ?>
								 </div>
								<?php } ?>
							<?php } //endforeach; ?>
						</div>
				  <?php } ?>
				</div>  
			</div>
		<?php } // endforeach of tabs ?>	
	</div>
</div>


<script>
$(function () {
$('#producttabs<?php echo $id;?> a:first').tab('show');
})
$('.tabcarousel<?php echo $id;?>').carousel({interval:false,auto:false,pause:'hover'});
</script>
