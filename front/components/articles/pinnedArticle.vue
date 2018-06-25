<template>
		<main class="maincontent clearfix">

			<div data-script="pl_tabbed" data-widget="home-tabs" class="tabLinks homeTabs" data-tab-wrap=".tabs">
				<div class="tabs toggle">
					<ul class="tablist" role="tablist">
						<li role="tab" tabindex="0" data-tab-index="0">Matches</li>
						<li role="tab" tabindex="0" data-tab-index="1" class="active">Latest</li>
					</ul>
				</div>
			</div>

			<div class="mainwrapper hasFixedSidebar clearfix">
				<div class="home">
					

					<div class="sidebarRight active" data-ui-tab="Latest">
						<div class="col-12">
							<!-- Вывод последней записи в качестве heroarticle -->
							
							<section class="heroArticle clearfix">
								<nuxt-link class="herolink clearfix" :to="articleLink">
									<figure>
										<span class="image">
											<img src="/i/eden200.jpg" alt="West Ham United v Manchester City">
										</span>
										<figcaption>
											<span class="post-cat"></span>
											<h4 class="title">{{ article.title }}</h4>
											<p>{{ article.excerpt }}</p>
										</figcaption>
									</figure>
								</nuxt-link>
								
							</section>
							
							<!-- \Вывод последней записи в качестве heroarticle -->
						</div>
					</div>
				</div>
			</div>
		</main>
</template>

<script>
  export default {
    name: 'pinnedArticle',

    computed: {
      articleLink() {
        return '/articles/' + this.article.id
      },

      article() {
        return this.$store.getters.getPinnedArticle
      }
    }
  }
</script>