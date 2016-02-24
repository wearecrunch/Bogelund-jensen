<?php if($status) { ?>
<?php if (isset($banners) && !empty($banners)) { ?>
<div class="box-module-pavbanners <?php echo $prefix_class ?>">

	<?php if($banner_layout == 2  ) { //show 2-rows, 3-cols?>
	<section class="col-lg-12 col-md-12 col-sm-12 col-xs-12">  
		<div class="container">
			<div class="row">	
				<?php foreach ($banners as $banner) { ?>
				<div class="col-md-4 col-lg-3 col-sm-4 col-xs-12">
					<div class="box banner-center">
						<a href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['thumb']; ?>" alt=""></a>
						<div class="description" style=" left:  50%;position: absolute;top: 50%;">
							<?php echo htmlspecialchars_decode($banner['caption'][$language]); ?>
						</div>
					</div>
				</div>
				<?php } //end foreach ?>
			</div>
		</div> 
	</section>
	<?php } //end if banner_layout?>

	<?php if($banner_layout == 1 && !empty($banners) ) { 
	 
	//show 1-rows, 3-cols, 5-cells?>
	<section id="banner-main"> 
		<div class="row">
			<div class="col-md-4 col-lg-4 col-sm-4 col-xs-12">
				<?php if( isset($banners[1]) ) { ?>
				<div class="box">
					<a href="<?php echo $banners[1]['link']; ?>"><img src="<?php echo $banners[1]['thumb']; ?>" alt=""></a>
					<div class="description" >
						<?php echo htmlspecialchars_decode($banners[1]['caption'][$language]); ?>
					</div>
				</div>
				<?php } ?>
				<?php if( isset($banners[2]) ) { ?>
				<div class="box">
					<a href="<?php echo $banners[2]['link']; ?>"><img src="<?php echo $banners[2]['thumb']; ?>" alt=""></a>
					<div class="description" >
						<?php echo htmlspecialchars_decode($banners[2]['caption'][$language]); ?>
					</div>
				</div>
				<?php } ?>
			</div>

			<div class="col-md-4 col-lg-4 col-sm-4 col-xs-12">
				<?php if( isset($banners[3]) ) { ?>
				<div class="box">
					<a href="<?php echo $banners[3]['link']; ?>"><img src="<?php echo $banners[3]['thumb']; ?>" alt=""></a>
					<div class="description" >
						<?php echo htmlspecialchars_decode($banners[3]['caption'][$language]); ?>
					</div>
				</div>
				<?php } ?>
			</div>

			<div class="col-md-4 col-lg-4 col-sm-4 col-xs-12">
				<?php if( isset($banners[4]) ) { ?>
				<div class="box">
					<a href="<?php echo $banners[4]['link']; ?>"><img src="<?php echo $banners[4]['thumb']; ?>" alt=""></a>
					<div class="description" >
						<?php echo htmlspecialchars_decode($banners[4]['caption'][$language]); ?>
					</div>
				</div>
				<?php } ?>
				<?php if( isset($banners[5]) ) { ?>
				<div class="box">
					<a href="<?php echo $banners[5]['link']; ?>"><img src="<?php echo $banners[5]['thumb']; ?>" alt=""></a>
					<div class="description" >
						<?php echo htmlspecialchars_decode($banners[5]['caption'][$language]); ?>
					</div>
				</div>
				<?php } ?>
			</div>
		</div> 
	</section>
	<?php } //end if show 1-rows, 3-cols, 5-cells?>


</div>
<?php } ?>
<?php } ?>