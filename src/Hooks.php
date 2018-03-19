<?php

namespace Fawpami;

require_once 'Icon.php';

class Hooks
{
    /** @var Fawpami */
    private $fawpami;

    /**
     * @param Fawpami $fawpami
     */
    public function __construct($fawpami)
    {
        $this->fawpami = $fawpami;
    }

    /**
     * Replace Font Awesome class string with icon SVG data URI
     *
     * @param array $args
     *
     * @return array
     */
    public function filterRegisterPostTypeArgs($args)
    {
        if (isset($args['menu_icon'])) {
            $menuIcon = $args['menu_icon'];
            $isFaClass = $this->fawpami->isFaClass($menuIcon);
            $isFaClassV4 = $this->fawpami->isFaClassV4($menuIcon);

            if ($isFaClass || $isFaClassV4) {
                if ($isFaClassV4) {
                    $this->fawpami->addV4SyntaxWarning($menuIcon);
                    $menuIcon = $this->fawpami->faV5Class($menuIcon);
                }
                try {
                    $icon = new Icon($menuIcon, $this->fawpami);
                    $args['menu_icon'] = $icon->svgDataUri();
                } catch (Exception $exception) {
                    $this->fawpami->adminNotices->add(
                        $exception->getMessage(),
                        'error'
                    );
                    try {
                        $icon = new Icon(
                            'fas fa-exclamation-triangle',
                            $this->fawpami
                        );
                        $args['menu_icon'] = $icon->svgDataUri();
                    } catch (Exception $e) {
                        /*
                         * This shouldn't happen because we know the exclamation
                         * triangle icon is valid
                         */
                    }
                }
            }
        }

        return $args;
    }

    /**
     * Replace Font Awesome class string with icon SVG data URI
     *
     * @param string $url
     *
     * @return string
     */
    public function filterSetUrlScheme($url)
    {
        $isFaClass = $this->fawpami->isFaClass($url);
        $isFaClassV4 = $this->fawpami->isFaClassV4($url);

        if ($isFaClass || $isFaClassV4) {
            $menuIcon = $url;
            if ($isFaClassV4) {
                $this->fawpami->addV4SyntaxWarning($menuIcon);
                $menuIcon = $this->fawpami->faV5Class($menuIcon);
            }

            try {
                $icon = new Icon($menuIcon, $this->fawpami);
                return $icon->svgDataUri();
            } catch (Exception $exception) {
                $this->fawpami->adminNotices->add(
                    $exception->getMessage(),
                    'error'
                );
                try {
                    $icon = new Icon(
                        'fas fa-exclamation-triangle',
                        $this->fawpami
                    );
                    return $icon->svgDataUri();
                } catch (Exception $e) {
                    /*
                     * This shouldn't happen because we know the exclamation
                     * triangle icon is valid
                     */
                }
            }
        }

        return $url;
    }
}
