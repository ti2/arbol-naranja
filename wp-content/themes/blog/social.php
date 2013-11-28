<div class="main-block social-sharing">
	<h4>Compartir:</h4>

	<?php $share_url = urlencode(home_url()); ?>
	<!-- google plus -->
	<a href="https://plus.google.com/share?url=<?php echo $share_url; ?>" onclick="window.open(this.href, 'googleplus-share-dialog', 'width=600,height=450'); return false;">Google +</a>
	<!-- facebook share -->
	<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $share_url; ?>" onclick="window.open(this.href, 'facebook-share-dialog', 'width=626,height=436'); return false;">Facebook</a>
	<!-- twitter -->
	<a href="https://twitter.com/share?url=<?php echo $share_url; ?>" onclick="window.open(this.href, 'twitter-share-dialog', 'width=550,height=450'); return false;">Twitter</a>
</div>
