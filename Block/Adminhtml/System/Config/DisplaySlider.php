<?php

/**
 * AmiciInfotech
 * Copyright (C) 2023 AmiciInfotech <contact@amiciinfotech.com>
 *
 * NOTICE OF LICENSE
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see http://opensource.org/licenses/gpl-3.0.html.
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    AmiciInfotech
 * @package     Amici_BannerSlider
 * @copyright   Copyright (c) 2023 AmiciInfotech (https://amiciinfotech.com/)
 * @license     https://amiciinfotech.com/license-agreement.html
 * @author      AmiciInfotech <contact@amiciinfotech.com>
 */

namespace Amici\BannerSlider\Block\Adminhtml\System\Config;

/**
 * Class DisplaySlider
 * @package Amici\BannerSlider\Block\Adminhtml\System\Config
 */
class DisplaySlider extends \Magento\Config\Block\System\Config\Form\Field
{
    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        return '
		<div class="notices-wrapper">
		        <div class="messages">
		            <div class="message" style="margin-top: 10px;">
		                <strong>' . __('To add slider via phtml template file.') . '</strong><br />
		                $this->getLayout()<br />
		                ->createBlock(
		                		&nbsp;&nbsp;"Amici\BannerSlider\Block\BannerSlider",<br />
		                		&nbsp;&nbsp;"md.slider.<strong>block_unique_name</strong>",<br />
		                		&nbsp;&nbsp;&nbsp;&nbsp;[<br />
						            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"data" => <br />
						            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[ <br />
						            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"slider_id" => <strong>your_slider_id</strong> <br />
						            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;]<br />
						        &nbsp;&nbsp;&nbsp;&nbsp;] <br />
		            	)<br />
		            	->setData("area", "frontend")<br />
		            	->toHtml();
		            </div>
		            <div class="message" style="margin-top: 10px;">
		                <strong>' . __('To add slider in cms page or block.') . '</strong><br />
		{{block class="Amici\BannerSlider\Block\BannerSlider" name="cms.<strong>
		block_unique_name</strong>.slider" slider_id="<strong>your_slider_id</strong>"}}
		            </div>
		            <div class="message" style="margin-top: 10px;">
		                <strong>' . __('To add slider via xml to any block/container') . '</strong><br />
		                &lt;block class="Amici\BannerSlider\Block\BannerSlider"&gt;<br />
                           &nbsp;&nbsp;&lt;arguments&gt;<br />
        &nbsp;&nbsp;&nbsp;&nbsp;&lt;argument name="slider_id" xsi:type="string"&gt;
        <strong>your_slider_id</strong>&lt;/argument&gt;<br />
                           &nbsp;&nbsp;&lt;/arguments&gt;<br />
                       &lt;/block>
		            </div>
		        </div>
		</div>';
    }
}
