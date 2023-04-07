<a href="#" class="SeoGPT">SeoGPT</a>

<script type="text/javascript">
	const seoBTN = document.querySelector('.SeoGPT');

	seoBTN.addEventListener('click',(e)=>{
		e.preventDefault();
		window.open('<?php global $SITEURL; echo $SITEURL;global $GSADMIN; echo $GSADMIN?>/load.php?id=seoGPT&formwindow',"","left=10,top=10,width=960,height=500");
	});

	document.querySelector('.edit-nav').prepend(document.querySelector('.SeoGPT'));
</script>