<?php /*********************************************************************
 index.php

 Helpdesk landing page. Please customize it to fit your needs.

 Peter Rotich <peter@osticket.com>
 Copyright (c)  2006-2013 osTicket
 http://www.osticket.com

 Released under the GNU General Public License WITHOUT ANY WARRANTY.
 See LICENSE.TXT for details.

 vim: expandtab sw=4 ts=4 sts=4:
 **********************************************************************/
require_once 'client.inc.php';
require_once INCLUDE_DIR.'class.page.php';
require_once CLIENTINC_DIR.'header.inc.php';
$section = 'home';

//faq's
if($cfg){
	$isFaqs = $cfg->isKnowledgebaseEnabled();
	$landingPage   = $cfg->getLandingPage();
	
	//categorias 
	if($isFaqs){
		$cats = Category::getFeatured();
	}
		
}
?>
<div class="row">
	
	<!-- conteudo de welcome -->
	<div class="col-md-12">
		<?php if($landingPage) : ?>
			<?php echo $landingPage->getBodyWithImages(); ?>
		<?php else : ?>
			<h1>
				<?php echo __('Welcome to the Support Center'); ?>
			</h1>
		<?php endif; ?>
	</div>
	<!-- // -->

	<!-- list the best faqs -->
	<?php if($isFaqs) : ?>
		<div class="col-md-12">
			<?php if ($cats->all()) : ?>
				<h1>
					<?php echo __('Featured Knowledge Base Articles'); ?>
				</h1>
			<?php endif; ?>
			<ul class="list-group">
				<?php foreach ($cats as $cat) : ?>
					<li class="list-group-item">
						<?php echo $cat->getName(); ?>
						<ul>
							<?php foreach ($cat->getTopArticles() as $art) : ?>
							<li>
								<a href="<?php echo ROOT_PATH; ?>kb/faq.php?id=<?php echo $art->getId(); ?>">
									<?php echo $art->getQuestion(); ?>
								</a>
								<p>
									<?php echo $art->getTeaser(); ?>
								</p>
							</li>
							<?php endforeach; ?>	
						</ul>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	<?php endif; ?>
	<!-- // -->
	
</div>

<?php
	require_once CLIENTINC_DIR.'footer.inc.php';
?>