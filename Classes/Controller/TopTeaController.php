<?php

namespace TTN\Tea\Controller;

use Psr\Http\Message\ResponseInterface;
use TTN\Tea\Domain\Repository\TeaRepository;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class TopTeaController extends ActionController
{
    /**
     * @param TeaRepository $teaRepository
     */
    public function __construct(private TeaRepository $teaRepository)
    {
    }

    /**
     * @return ResponseInterface
     */
    public function indexAction(): ResponseInterface
    {
        $topTeas = $this->teaRepository->findTopTeas();
        if (0 < $topTeas->count()) {
            $this->view->assign('topTeas', $topTeas);
        } else {
            $this->view->assign('error', 'No Top Teas found.');
        }

        return $this->htmlResponse();
    }
}
