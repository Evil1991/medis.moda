{* 
 * NOTICE OF LICENSE
 *
 * This source file is subject to the GNU General Public License (GPL) version 3
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/
 *
 * @author    Ve Interactive <info@veinteractive.com>
 * @copyright 2015 Ve Interactive
 * @license   http://www.gnu.org/licenses/ GNU General Public License (GPL) version 3
 *}

    {if $productAlert }
    <div class="bootstrap">
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert">×</button>
            {$productAlert|escape:'htmlall':'UTF-8'}
        </div>
    </div>
    {/if}

    <div id="veinteractive_main">
        
        <div class="ve_header">
            <div class="header_top content_grid">
                <div class="left_header">
                     <img src="{$path|escape:'htmlall':'UTF-8'}main-logo.png" alt="VeInteractive">
                </div>
                <div class="right_header">
                    <nav class="main_menu">
                       <ul>
                          <li>
                            {if $showLogin }
                              <span class="cli_quest">{l s='Are you already a client? Then...' mod='veplatform'}</span>
                              <a href="http://veplatform.veinteractive.com/Account/Login?ReturnUrl=%2f">Login</a>
                             {/if}
                          </li>
                      </ul>
                    </nav>
                </div>
            </div>

            <div class="faint-line">
                <div class="main_messages content_grid">
                    <h2 class="thx-msg">{l s='Thank you for installing VePlatform with Prestashop' mod='veplatform'}</h2>
                    <h2 class="conf-msg">{l s='Now choose from our range of applications' mod='veplatform'}</h2>
                </div>
            </div>
        </div>

        <div class="ve_main">
            <div class="company_info content_grid">
                <div class="info_text">
                    <img class="ecommerce-logo" src="{$path|escape:'htmlall':'UTF-8'}/prestashop-logo-original.png" alt="Prestashop" />
                        <p>
                            {l s='By integrating the VePlatform into your Prestashop webstore, you now have instant access to its suite of retargeting, remarketing and re-engagement apps designed to:' mod='veplatform'}
                        </p>
                        <ul class="ve-list">
                          <li>{l s='Reduce your website\'s bounce rate' mod='veplatform'}</li>
                          <li>{l s='Recover lost sales with email, display retargeting and SMS messaging' mod='veplatform'}</li>
                          <li>{l s='Increase conversion with real time onsite engagement' mod='veplatform'}</li>
                          <li>{l s='Reach new and existing prospects with digital display advertising' mod='veplatform'}</li>
                        </ul>
                        <p>
                            {l s='Activating all the Ve Apps on the VePlatform will deliver the maximum uplift in conversion. However, we also provide the option of selecting one or multiple apps to match your ecommerce goals.' mod='veplatform'}
                        </p>
                </div>
            </div>

            <form name="myedit" id="myedit" action="" method="post">
                <div class="product_activation">
                    <div class="product_activation_content content_grid">
                        <h2 class="product_act_title">{l s='Please select from the following apps' mod='veplatform'}</h2>

                        <div id="veads-section" class="veads product">
                            <div class="product_logo product-logo-clickable {if $veApi->isProductActive('veads')}no-clickable{/if}" data-target="adsCb" data-value="veads"></div>
                            <div class="product_name">
                                <p>{l s='Dynamic display advertising' mod='veplatform'}</p>
                            </div>
                            <input type="checkbox" class="veplatform-checkbox" id="adsCb" name="product[]" value="veads" checked{if $veApi->isProductActive('veads')} disabled{/if} />
                            <label for="adsCb"></label>
                            <button id="veads_moreinfo" class="quest_btn ve-open-info" data-target="veads_info_content">
                                {l s='Find out more' mod='veplatform'} <span class="icons-pike"></span>
                            </button>
                        </div>

                        <div id="veassist-section" class="veassist product">
                            <div class="product_logo product-logo-clickable {if $veApi->isProductActive('veassist')}no-clickable{/if}" data-target="assistCb" data-value="veassist"></div>
                            <div class="product_name">
                                <p>{l s='Search optimization' mod='veplatform'}</p>
                            </div>
                            <input type="checkbox" class="veplatform-checkbox" id="assistCb" name="product[]" value="veassist" checked{if $veApi->isProductActive('veassist')} disabled{/if} />
                            <label for="assistCb"></label>
                            <button id="veassist_moreinfo" class="quest_btn ve-open-info" data-target="veassist_info_content">
                                {l s='Find out more' mod='veplatform'} <span class="icons-pike"></span>
                            </button>
                        </div>

                        <div id="vechat-section" class="vechat product">
                            <div class="product_logo product-logo-clickable {if $veApi->isProductActive('vechat')}no-clickable{/if}" data-target="chatCb" data-value="vechat"></div>
                            <div class="product_name">
                                <p>{l s='Increase website conversion' mod='veplatform'}</p>
                            </div>
                            <input type="checkbox" class="veplatform-checkbox" id="chatCb" name="product[]" value="vechat" checked{if $veApi->isProductActive('vechat')} disabled{/if} />
                            <label for="chatCb"></label>
                            <button id="vechat_moreinfo" class="quest_btn ve-open-info" data-target="vechat_info_content">
                              {l s='Find out more' mod='veplatform'} <span class="icons-pike"></span>
                            </button>
                        </div>

                        <div id="vecontact-section" class="vecontact product">
                            <div class="product_logo product-logo-clickable {if $veApi->isProductActive('vecontact')}no-clickable{/if}" data-target="contactCb" data-value="vecontact"></div>
                            <div class="product_name">
                              <p>{l s='Recover lost shopping carts' mod='veplatform'}</p>
                            </div>
                            <input type="checkbox" class="veplatform-checkbox" id="contactCb" name="product[]" value="vecontact" checked{if $veApi->isProductActive('vecontact')} disabled{/if} />
                            <label for="contactCb"></label>
                            <button id="vecontact_moreinfo" class="quest_btn ve-open-info" data-target="vecontact_info_content">
                              {l s='Find out more' mod='veplatform'} <span class="icons-pike"></span>
                            </button>
                        </div>
                            
                        <div class="vebutton">
                            <input type="submit" name="submit" value="{l s='Confirm Selection' mod='veplatform'}" id="confirm-btn" class="confirm-btn" />
                        </div>

                        <div class="product-extra-info">
                            <div id="vechat_info_content" class="hidden ve-info-content">
                                <div class="extra_content content_grid">
                                    <h2 class="product_act_title">VeChat: {l s='Increase website conversion' mod='veplatform'}</h2>
                                    <div class="product_logo"></div>
                                    <p>
                                        {l s='VeChat re-engages your customers at the point they abandon your website and prevents lost sales caused by price comparison shopping, site usability or distraction during the purchase process.  The VeChat automated agent delivers real-time re-marketing messages. VeChat can also deliver promotional codes to specific segments based on purchasing behaviour.' mod='veplatform'}
                                    </p>
                                    <button id="vechat_closeinfo" class="quest_btn ve-close-info" data-target="vechat_info_content">{l s='Close App Details' mod='veplatform'}</button>
                                </div>
                            </div>
                            <div id="vecontact_info_content" class="hidden ve-info-content">
                              <div class="extra_content content_grid">
                                <h2 class="product_act_title">VeContact: {l s='Recover lost shopping carts' mod='veplatform'}</h2>
                                <div class="product_logo"></div>
                                <p>
                                    {l s='VeContact increases your sales by delivering real-time emails to customers who abandon at the check-out, enticing them back to complete their purchase with highly targeted and personalised content. Includes promo code integration and compatible across all devices.' mod='veplatform'}
                                </p>
                                <button id="vecontact_closeinfo" class="quest_btn ve-close-info" data-target="vecontact_info_content">{l s='Close App Details' mod='veplatform'}</button>
                              </div>
                            </div>
                            <div id="veassist_info_content" class="hidden ve-info-content">
                                <div class="extra_content content_grid">
                                    <h2 class="product_act_title">VeAssist: {l s='Search optimization' mod='veplatform'}</h2>
                                    <div class="product_logo"></div>
                                    <p>
                                        {l s='VeAssist is an onsite product matching tool that directly tackles bounce caused by the disconnect that can exist between search and the products displayed on landing pages. Activated when a customer hits the back button to bounce, VeAssist interrogates your inventory and uses \'exact\' and \'nearest\' match logic to present the customer with enhanced product results, based on their original search engine query. Compatible with all search engines.' mod='veplatform'}
                                    </p>
                                    <button id="veassist_closeinfo" class="quest_btn ve-close-info" data-target="veassist_info_content">{l s='Close App Details' mod='veplatform'}</button>
                                </div>
                            </div>
                            <div id="veads_info_content" class="hidden ve-info-content">
                                <div class="extra_content content_grid">
                                    <h2 class="product_act_title">Veads: {l s='Dynamic display advertising' mod='veplatform'}</h2>
                                    <div class="product_logo"></div>
                                    <p>
                                        {l s='VeAds harnesses the power of customer and purchasing intent data to deliver advertising campaigns that meet all advertiser KPIs. VeAds helps you target and convert new audiences, on a vast scale, across all connected devices. A successful digital advertising campaign uses a blend of prospecting and on and off site re-engagement to ensure that marketing dollars invested generate the best possible return.' mod='veplatform'}
                                    </p>
                                    <button id="veads_closeinfo" class="quest_btn ve-close-info" data-target="veads_info_content">{l s='Close App Details' mod='veplatform'}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="legal_info content_grid">
                <div class="info_text">
                    <p>
                        {l s='All Ve Apps are free to install and deploy. There are no upfront costs for set up, one-off charges or ongoing subscription costs. We only charge on a cost per acquisition basis meaning you only pay a commission when one of our apps converts a sale on your site. If they all contribute to a sale, you still only pay once.' mod='veplatform'}
                    </p>
                </div>
            </div>
        </div>

        <div class="ve_footer">
            <div class="footer-content content_grid">
                <div class="footer-left">
                    <span><a target="_blank" href="http://www.veinteractive.com">Ve Interactive</a></span>
                </div>
                <div class="footer-center">
                    <img src="{$path|escape:'htmlall':'UTF-8'}/prestashop-logo-footer.png" alt="Prestashop">
                </div>
                <div class="footer-right">
                    <span>&copy; {$currentYear|escape:'htmlall':'UTF-8'} {l s='All rights Reserved.' mod='veplatform'} Ve Interactive </span>
                </div>
            </div>
        </div>

</div>
