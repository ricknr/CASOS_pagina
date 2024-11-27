<footer>
	<div class="container pt-4 pb-1 test11">
		<div class="row">
			<?php if(!dynamic_sidebar( 'footer' )) {
				} ?>
		</div>
		<div class="copyright row text-center">
			<div class="col-12 pt-2">
				<?php $aviso = get_permalink( get_page_by_path( 'aviso-de-privacidad' ) ); ?>
				<p>© 2018 Cáritas de Monterrey. Todos los derechos reservados. Sitio desarrollado por Espacios de México.<br>
<a href="<?php echo $aviso; ?>">Aviso de Privacidad</a></p>
			</div>
		</div>
	</div>	
</footer>
<?php wp_footer(); ?>
<script type="text/javascript" async src="https://d335luupugsy2.cloudfront.net/js/loader-scripts/290d4e6c-4cf8-410d-ab06-2f964abd39c5-loader.js" ></script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-123644774-1"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());
gtag('config', 'UA-123644774-1');
</script>
<script type="text/javascript" async src="https://d335luupugsy2.cloudfront.net/js/loader-scripts/290d4e6c-4cf8-410d-ab06-2f964abd39c5-loader.js" ></script>
</body>
</html>
