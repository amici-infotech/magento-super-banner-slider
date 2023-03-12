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

namespace Amici\BannerSlider\Model\Config\Source;

use Magento\Framework\Module\Manager as ModuleManager;

/**
 * Class Animations
 * @package Amici\BannerSlider\Model\Config\Source
 */
class Animations implements \Magento\Framework\Option\ArrayInterface
{
    const CAPTION_ANIMATION_BOUNCE              = 'bounce';
    const CAPTION_ANIMATION_FLASH               = 'flash';
    const CAPTION_ANIMATION_PULSE               = 'pulse';
    const CAPTION_ANIMATION_RUBBER_BAND         = 'rubberBand';
    const CAPTION_ANIMATION_SHAKE               = 'shake';
    const CAPTION_ANIMATION_SWING               = 'swing';
    const CAPTION_ANIMATION_TADA                = 'tada';
    const CAPTION_ANIMATION_WOBBLE              = 'wobble';
    const CAPTION_ANIMATION_JELLO               = 'jello';

    const CAPTION_ANIMATION_BOUNCE_IN           = 'bounceIn';
    const CAPTION_ANIMATION_BOUNCE_IN_DOWN      = 'bounceInDown';
    const CAPTION_ANIMATION_BOUNCE_IN_LEFT      = 'bounceInLeft';
    const CAPTION_ANIMATION_BOUNCE_IN_RIGHT     = 'bounceInRight';
    const CAPTION_ANIMATION_BOUNCE_IN_UP        = 'bounceInUp';

    const CAPTION_ANIMATION_BOUNCE_OUT          = 'bounceOut';
    const CAPTION_ANIMATION_BOUNCE_OUT_DOWN     = 'bounceOutDown';
    const CAPTION_ANIMATION_BOUNCE_OUT_LEFT     = 'bounceOutLeft';
    const CAPTION_ANIMATION_BOUNCE_OUT_RIGHT    = 'bounceOutRight';
    const CAPTION_ANIMATION_BOUNCE_OUT_UP       = 'bounceOutUp';

    const CAPTION_ANIMATION_FADE_IN             = 'fadeIn';
    const CAPTION_ANIMATION_FADE_IN_DOWN        = 'fadeInDown';
    const CAPTION_ANIMATION_FADE_IN_BIG         = 'fadeInDownBig';
    const CAPTION_ANIMATION_FADE_IN_LEFT        = 'fadeInLeft';
    const CAPTION_ANIMATION_FADE_IN_LEFT_BIG    = 'fadeInLeftBig';
    const CAPTION_ANIMATION_FADE_IN_RIGHT       = 'fadeInRight';
    const CAPTION_ANIMATION_FADE_IN_RIGHT_BIG   = 'fadeInRightBig';
    const CAPTION_ANIMATION_FADE_IN_UP          = 'fadeInUp';
    const CAPTION_ANIMATION_FADE_IN_UP_BIG      = 'fadeInUpBig';

    const CAPTION_ANIMATION_FADE_OUT            = 'fadeOut';
    const CAPTION_ANIMATION_FADE_OUT_DOWN       = 'fadeOutDown';
    const CAPTION_ANIMATION_FADE_OUT_DOWN_BIG   = 'fadeOutDownBig';
    const CAPTION_ANIMATION_FADE_OUT_LEFT       = 'fadeOutLeft';
    const CAPTION_ANIMATION_FADE_OUT_LEFT_BIG   = 'fadeOutLeftBig';
    const CAPTION_ANIMATION_FADE_OUT_RIGHT      = 'fadeOutRight';
    const CAPTION_ANIMATION_FADE_OUT_RIGHT_BIG  = 'fadeOutRightBig';
    const CAPTION_ANIMATION_FADE_OUT_UP         = 'fadeOutUp';
    const CAPTION_ANIMATION_FADE_OUT_UP_BIG     = 'fadeOutUpBig';
    
    const CAPTION_ANIMATION_FLIP                = 'flip';
    const CAPTION_ANIMATION_FLIP_INX            = 'flipInX';
    const CAPTION_ANIMATION_FLIP_INY            = 'flipInY';
    const CAPTION_ANIMATION_FLIP_OUTX           = 'flipOutX';
    const CAPTION_ANIMATION_FLIP_OUTY           = 'flipOutY';

    const CAPTION_ANIMATION_LIGHT_SPEED_IN      = 'lightSpeedIn';
    const CAPTION_ANIMATION_LIGHT_SPEED_OUT     = 'lightSpeedOut';

    const CAPTION_ANIMATION_ROTATE_IN           = 'rotateIn';
    const CAPTION_ANIMATION_ROTATE_IN_DOWN_LEFT = 'rotateInDownLeft';
    const CAPTION_ANIMATION_ROTATE_IN_DOWN_RIGHT= 'rotateInDownRight';
    const CAPTION_ANIMATION_ROTATE_IN_UP_LEFT   = 'rotateInUpLeft';
    const CAPTION_ANIMATION_ROTATE_IN_UP_RIGHT  = 'rotateInUpRight';

    const CAPTION_ANIMATION_ROTATE_OUT          = 'rotateOut';
    const CAPTION_ANIMATION_ROTATE_OUTDOWN_LEFT = 'rotateOutDownLeft';
    const CAPTION_ANIMATION_ROTATE_OUTDOWN_RIGHT= 'rotateOutDownRight';
    const CAPTION_ANIMATION_ROTATE_OUT_UP_LEFT  = 'rotateOutUpLeft';
    const CAPTION_ANIMATION_ROTATE_OUT_UP_RIGHT = 'rotateOutUpRight';

    const CAPTION_ANIMATION_SLIDE_IN_UP         = 'slideInUp';
    const CAPTION_ANIMATION_SLIDE_IN_DOWN       = 'slideInDown';
    const CAPTION_ANIMATION_SLIDE_IN_LEFT       = 'slideInLeft';
    const CAPTION_ANIMATION_SLIDE_IN_RIGHT      = 'slideInRight';
    
    const CAPTION_ANIMATION_SLIDE_OUT_UP        = 'slideOutUp';
    const CAPTION_ANIMATION_SLIDE_OUT_DOWN      = 'slideOutDown';
    const CAPTION_ANIMATION_SLIDE_OUT_LEFT      = 'slideOutLeft';
    const CAPTION_ANIMATION_SLIDE_OUT_RIGHT     = 'slideOutRight';

    const CAPTION_ANIMATION_ZOOM_IN             = 'zoomIn';
    const CAPTION_ANIMATION_ZOOM_IN_DOWN        = 'zoomInDown';
    const CAPTION_ANIMATION_ZOOM_IN_LEFT        = 'zoomInLeft';
    const CAPTION_ANIMATION_ZOOM_IN_RIGHT       = 'zoomInRight';
    const CAPTION_ANIMATION_ZOOM_IN_UP          = 'zoomInUp';
    
    const CAPTION_ANIMATION_ZOOM_OUT            = 'zoomOut';
    const CAPTION_ANIMATION_ZOOM_OUT_DOWN       = 'zoomOutDown';
    const CAPTION_ANIMATION_ZOOM_OUT_LEFT       = 'zoomOutLeft';
    const CAPTION_ANIMATION_ZOOM_OUT_RIGHT      = 'zoomOutRight';
    const CAPTION_ANIMATION_ZOOM_OUT_UP         = 'zoomOutUp';

    const CAPTION_ANIMATION_HINGE               = 'hinge';
    const CAPTION_ANIMATION_JACK_IN_THE_BOX     = 'jackInTheBox';
    const CAPTION_ANIMATION_ROLL_IN             = 'rollIn';
    const CAPTION_ANIMATION_ROLL_OUT            = 'rollOut';

    /**
     * @var ModuleManager
     */
    protected $moduleManager;

    /**
     * @param ModuleManager $moduleManager
     * @param SliderFactory $sliderFactory
     */
    public function __construct(
        ModuleManager $moduleManager
    ) {
        $this->moduleManager = $moduleManager;
    }

    /**
     * Return array of sliders
     *
     * @return array
     */
    public function toOptionArray()
    {
        if (!$this->moduleManager->isEnabled('Amici_BannerSlider')) {
            return [];
        }
        $animations = [
            [
                'value' => self::CAPTION_ANIMATION_BOUNCE,
                'label' => __('bounce'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_FLASH,
                'label' => __('flash'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_PULSE,
                'label' => __('pulse'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_RUBBER_BAND,
                'label' => __('rubberBand'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_SHAKE,
                'label' => __('shake'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_SWING,
                'label' => __('swing'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_WOBBLE,
                'label' => __('wobble'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_TADA,
                'label' => __('tada'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_JELLO,
                'label' => __('jello'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_BOUNCE_IN,
                'label' => __('bounceIn'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_BOUNCE_IN_DOWN,
                'label' => __('bounceInDown'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_BOUNCE_IN_LEFT,
                'label' => __('bounceInLeft'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_BOUNCE_IN_RIGHT,
                'label' => __('bounceInRight'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_BOUNCE_IN_UP,
                'label' => __('bounceInUp'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_BOUNCE_OUT,
                'label' => __('bounceOut'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_BOUNCE_OUT_LEFT,
                'label' => __('bounceOutLeft'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_BOUNCE_OUT_DOWN,
                'label' => __('bounceOutDown'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_BOUNCE_OUT_RIGHT,
                'label' => __('bounceOutRight'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_BOUNCE_OUT_UP,
                'label' => __('bounceOutUp'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_FADE_IN,
                'label' => __('fadeIn'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_FADE_IN_DOWN,
                'label' => __('fadeInDown'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_FADE_IN_BIG,
                'label' => __('fadeInDownBig'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_FADE_IN_LEFT,
                'label' => __('fadeInLeft'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_FADE_IN_LEFT_BIG,
                'label' => __('fadeInLeftBig'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_FADE_IN_RIGHT,
                'label' => __('fadeInRight'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_FADE_IN_RIGHT_BIG,
                'label' => __('fadeInRightBig'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_FADE_IN_UP,
                'label' => __('fadeInUp'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_FADE_IN_UP_BIG,
                'label' => __('fadeInUpBig'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_FADE_OUT,
                'label' => __('fadeOut'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_FADE_OUT_DOWN,
                'label' => __('fadeOutDown'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_FADE_OUT_DOWN_BIG,
                'label' => __('fadeOutDownBig'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_FADE_OUT_LEFT,
                'label' => __('fadeOutLeft'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_FADE_OUT_LEFT_BIG,
                'label' => __('fadeOutLeftBig'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_FADE_OUT_RIGHT,
                'label' => __('fadeOutRight'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_FADE_OUT_RIGHT_BIG,
                'label' => __('fadeOutRightBig'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_FADE_OUT_UP,
                'label' => __('fadeOutUp'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_FADE_OUT_UP_BIG,
                'label' => __('fadeOutUpBig'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_FLIP,
                'label' => __('flip'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_FLIP_INX,
                'label' => __('flipInX'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_FLIP_INY,
                'label' => __('flipInY'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_FLIP_OUTX,
                'label' => __('flipOutX'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_FLIP_OUTY,
                'label' => __('flipOutY'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_LIGHT_SPEED_IN,
                'label' => __('lightSpeedIn'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_LIGHT_SPEED_OUT,
                'label' => __('lightSpeedOut'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_ROTATE_IN,
                'label' => __('rotateIn'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_ROTATE_IN_DOWN_LEFT,
                'label' => __('rotateInDownLeft'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_ROTATE_IN_DOWN_RIGHT,
                'label' => __('rotateInDownRight'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_ROTATE_IN_UP_LEFT,
                'label' => __('rotateInUpLeft'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_ROTATE_IN_UP_RIGHT,
                'label' => __('rotateInUpRight'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_ROTATE_OUT,
                'label' => __('rotateOut'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_ROTATE_OUTDOWN_LEFT,
                'label' => __('rotateOutDownLeft'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_ROTATE_OUTDOWN_RIGHT,
                'label' => __('rotateOutDownRight'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_ROTATE_OUT_UP_LEFT,
                'label' => __('rotateOutUpLeft'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_ROTATE_OUT_UP_RIGHT,
                'label' => __('rotateOutUpRight'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_SLIDE_IN_UP,
                'label' => __('slideInUp'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_SLIDE_IN_DOWN,
                'label' => __('slideInDown'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_SLIDE_IN_LEFT,
                'label' => __('slideInLeft'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_SLIDE_IN_RIGHT,
                'label' => __('slideInRight'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_SLIDE_OUT_UP,
                'label' => __('slideOutUp'),
            ],

            [
                'value' => self::CAPTION_ANIMATION_SLIDE_OUT_DOWN,
                'label' => __('slideOutDown'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_SLIDE_OUT_LEFT,
                'label' => __('slideOutLeft'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_SLIDE_OUT_RIGHT,
                'label' => __('slideOutRight'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_ZOOM_IN,
                'label' => __('zoomIn'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_ZOOM_IN_DOWN,
                'label' => __('zoomInDown'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_ZOOM_IN_LEFT,
                'label' => __('zoomInLeft'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_ZOOM_IN_RIGHT,
                'label' => __('zoomInRight'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_ZOOM_IN_UP,
                'label' => __('zoomInUp'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_ZOOM_OUT,
                'label' => __('zoomOut'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_ZOOM_OUT_DOWN,
                'label' => __('zoomOutDown'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_ZOOM_OUT_LEFT,
                'label' => __('zoomOutLeft'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_ZOOM_OUT_RIGHT,
                'label' => __('zoomOutRight'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_ZOOM_OUT_UP,
                'label' => __('zoomOutUp'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_HINGE,
                'label' => __('hinge'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_JACK_IN_THE_BOX,
                'label' => __('jackInTheBox'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_ROLL_IN,
                'label' => __('rollIn'),
            ],
            [
                'value' => self::CAPTION_ANIMATION_ROLL_OUT,
                'label' => __('rollOut'),
            ]

        ];

        return $animations;
    }
}
