<style>
	.header,#sidebar,#footer,.buttons{
		display:none !important;
	}
	#maincontent{
		width:100%;
	}
</style>

<form class="seoform" method="POST">
	<input name="question" class="question" placeholder="<?php echo  i18n_r('seoGPT/LANG_Example') ;?>" 
	style="width:100%;padding:0.5rem;box-sizing: border-box;border-radius: 1rem;border:solid 1px #333;"
	<?php 
		if(isset($_GET['question'])){
			echo 'value="'.$_GET['question'].'"';
		}
	;?>
	type="text">

	<input type="submit" value="<?php echo  i18n_r('seoGPT/LANG_Send_Query') ;?>" 
	style="padding: 0.6rem 1.5rem; border-radius:1.2rem; color:#fff; background:#DF2E38; border:none; margin-top:10px;"
	name="SeoGPT">

	<button class="pasteCKE" style="padding: 0.6rem 1.5rem; border-radius:1.2rem; color:#fff; background:#000; border:none; margin-top:10px;"><?php echo  i18n_r('seoGPT/LANG_Paste') ;?></button>
</form>

<script>
	const question = document.querySelector('.question');
	question.addEventListener('keyup',()=>{
		document.querySelector('.seoform').setAttribute('action','<?php echo $SITEURL.$GSADMIN.'/load.php?id=seoGPT&formwindow&question=';?>'+question.value);
	});

	document.querySelector('.pasteCKE').addEventListener('click',(e)=>{
		e.preventDefault();
		window.opener.CKEDITOR.instances['post-content'].insertHtml(document.querySelector('.returnbot').innerText);
		window.close();
	})
</script>