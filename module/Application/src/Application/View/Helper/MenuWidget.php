<?php

namespace Application\View\Helper;

use Application\Service\MenuService;
use Zend\View\Helper\AbstractHelper;

class MenuWidget extends AbstractHelper {

    protected $menuService = null;

    public function __construct(MenuService $menuService) {
        $this->menuService = $menuService;
    }

    public function __invoke() {
        $menu = $this->menuService->load();

        return $this->getView()->render('application/menu/index', array('menu' => $menu));

        // If a full template is overkill, you could of course just render
        // the widget directly
        //return ">div> $menu >/div>";
    }

}
