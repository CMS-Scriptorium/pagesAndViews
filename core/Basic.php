<?php

declare(strict_types=1);

namespace pagesAndViews\core;

use \LEPTON_handle;
use \LEPTON_database;
use \Lepton_singleton;
use \LEPTON_core;
use \LEPTON_tools;
use \lib_twig_box;

class Basic
{
    use LEPTON_singleton;
    
    public array $pageTree = [];
    public array $allGroups =[];

    public static $instance;

    public function show(): void
    {
        $oTWIG = lib_twig_box::getInstance();
        $oTWIG->registerModule("pagesAndViews");

        echo $oTWIG->render(
            "@pagesAndViews/list.lte",
            [
                'action'    => "#",
                'page_url'  => ADMIN_URL."/pages/settings.php?page_id=",
                'allGroups' => $this->allGroups,
                'pageTree'  => $this->pageTree
            ]
        );
    }

    public function handleSave(): void
    {
        $save = LEPTON_core::getValue("viewing_groups", "array");
        if (!is_null($save))
        {
            $database = LEPTON_database::getInstance();

            foreach ($save as $page => $accessValues)
            {
                if (!in_array(1, $accessValues))
                {
                    $accessValues[] = 1;
                }

                sort($accessValues);
                $accessString = implode(",", $accessValues);
                
                $database->simple_query(
                    "UPDATE `".TABLE_PREFIX."pages` 
                    SET `viewing_groups` = '".$accessString."'
                    WHERE `page_id` =".$page
                );
            }

            echo LEPTON_tools::display_dev("Data saved.", "pre", "ui message green");
        }
    }

    protected function getPageTree(): void
    {
        LEPTON_handle::register("page_tree");
        
        $fields = ['page_id', 'page_title', 'menu_title', 'parent', 'position', 'visibility', 'link', 'admin_groups', 'viewing_groups'];
        page_tree(0, $this->pageTree, $fields);
    }

    protected function getGroups(): void
    {
        LEPTON_database::getInstance()->execute_query(
            "SELECT `group_id`, `name`, `backend_access` FROM `".TABLE_PREFIX."groups`",
            true,
            $this->allGroups,
            true
        );
    }

    private function __construct()
    {
        // own stuff here
        $this->getGroups();
        $this->handleSave();
        $this->getPageTree();
    }
}