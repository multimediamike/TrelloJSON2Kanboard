<?php

namespace Kanboard\Plugin\TrelloJSON2Kanboard\Controller;

use Kanboard\Controller\BaseController;

/**
 * TrelloJSON2Kanboard Controller
 *
 * @package  Kanboard\Plugin\TrelloJSON2Kanboard\Controller
 * @author   Wilton Rodrigues
 */
class ImportedProjectListController extends BaseController
{
    public function show()
    {
        if ($this->userSession->isAdmin()) {
            $projectIds = $this->projectModel->getAllIds();
        } else {
            $projectIds = $this->projectPermissionModel->getProjectIds($this->userSession->getId());
        }

        $query = $this->projectModel->getQueryByProjectIds($projectIds);
        $search = $this->request->getStringParam('search');

        if ($search !== '') {
            $query->ilike('projects.name', '%' . $search . '%');
        }

        $paginator = $this->paginator
            ->setUrl('ImportedProjectListController', 'show')
            ->setMax(20)
            ->setOrder('name')
            ->setQuery($query)
            ->calculate();

        $this->response->html($this->helper->layout->app('project_list/listing', array(
            'paginator'   => $paginator,
            'title'       => t('Projects') . ' (' . $paginator->getTotal() . ')',
            'values'      => array('search' => $search),
        )));
    }
}
