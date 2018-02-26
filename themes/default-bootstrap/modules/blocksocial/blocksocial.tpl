<section id="social_block">
	<ul>
		{if $facebook_url != ''}
			<li class="facebook">
				<a target="_blank" href="{$facebook_url|escape:html:'UTF-8'}">
					<span>{l s='Facebook' mod='blocksocial'}</span>
				</a>
			</li>
		{/if}
        {if $VK_url != ''}
            <li class="vk">
                <a target="_blank" href="{$VK_url|escape:html:'UTF-8'}">
                    <span>{l s='Вконтакте' mod='blocksocial'}</span>
                </a>
            </li>
        {/if}
        {if $ODK_url != ''}
            <li class="odk">
                <a target="_blank" href="{$ODK_url|escape:html:'UTF-8'}">
                    <span>{l s='Одноклассники' mod='blocksocial'}</span>
                </a>
            </li>
        {/if}
		{if $twitter_url != ''}
			<li class="twitter">
				<a target="_blank" href="{$twitter_url|escape:html:'UTF-8'}">
					<span>{l s='Twitter' mod='blocksocial'}</span>
				</a>
			</li>
		{/if}
		{if $rss_url != ''}
			<li class="rss">
				<a target="_blank" href="{$rss_url|escape:html:'UTF-8'}">
					<span>{l s='RSS' mod='blocksocial'}</span>
				</a>
			</li>
		{/if}
        {if $youtube_url != ''}
        	<li class="youtube">
        		<a href="{$youtube_url|escape:html:'UTF-8'}">
        			<span>{l s='Youtube' mod='blocksocial'}</span>
        		</a>
        	</li>
        {/if}
        {if $google_plus_url != ''}
        	<li class="google-plus">
        		<a href="{$google_plus_url|escape:html:'UTF-8'}">
        			<span>{l s='Google Plus' mod='blocksocial'}</span>
        		</a>
        	</li>
        {/if}
        {if $pinterest_url != ''}
        	<li class="pinterest">
        		<a href="{$pinterest_url|escape:html:'UTF-8'}">
        			<span>{l s='Pinterest' mod='blocksocial'}</span>
        		</a>
        	</li>
        {/if}
	</ul>
    {*<h4>{l s='Follow us' mod='blocksocial'}</h4>*}
</section>
<div class="clearfix"></div>
