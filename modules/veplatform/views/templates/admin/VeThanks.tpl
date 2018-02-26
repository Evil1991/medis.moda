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
                    <h2 class="thx-msg">{l s='Thank you for selecting your Ve product' mod='veplatform'}</h2>
                    <h2 class="conf-msg">{l s='Now see below for the next steps' mod='veplatform'}</h2>
                </div>
            </div>
        </div>

        <div class="ve_main">
            <div class="company_info content_grid">
                <div class="info_text">
                    <img class="ecommerce-logo" src="{$path|escape:'htmlall':'UTF-8'}/prestashop-logo-original.png" alt="Prestashop" />
                        <p>
                            {l s='Thank you for selecting your chosen Ve Apps. You are one step closer to increasing customer engagement and conversions on your site.' mod='veplatform'}
                        </p>
                        <p>
                            {l s='An Account Manager will contact you within 2 working days to configure your first campaigns or you can contact us below to get started straight away.' mod='veplatform'}
                        </p>
                        <p>
                            {l s='Are you already a client? Then...' mod='veplatform'}
                            {l s='Creative examples of our apps available to view <a target="_blank" href="http://vecreative.veinteractive.com">here</a>.' mod='veplatform' js=true}
                        </p>
                        <ul class="social-info">
                          <li>
                            <span class="icons-envelope"></span>
                            {if $langIsoCode == 'fr'}
                            <a href="mailto:prestashopfrance@veinteractive.com">prestashopfrance@veinteractive.com</a>
                            {else}
                            <a href="mailto:prestashop@veinteractive.com">prestashop@veinteractive.com</a>
                            {/if}
                          </li>
                          <li>
                            <span class="icons-phone"></span>
                            <span class="country">UK:</span>
                            <span>+44 (0)20 337 22555</span>
                          </li>
                        {if $langIsoCode == 'fr'}
                          <li>
                            <span class="icons-phone"></span>
                            <span class="country">FR:</span>
                            <span>+33 (0)1 7098 3275</span>
                          </li>
                        {else}
                          <li>
                            <span class="icons-phone"></span>
                            <span class="country">US:</span>
                            <span>+1 857-284-7007</span>
                          </li>
                        {/if}
                        </ul>
                        <p>{l s='Best regards,' mod='veplatform'}</p>
                        <p>Ve Interactive</p>
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
