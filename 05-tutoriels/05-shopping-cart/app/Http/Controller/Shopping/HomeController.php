<?php
declare(strict_types=1);

namespace App\Http\Controller\Shopping;

use App\Http\AbstractController;
use App\Http\Controller\ShoppingController;
use App\Repository\ProductRepository;
use Grafikart\Http\Request\ServerRequest;
use Grafikart\Http\Response\Response;

/**
 * HomeController
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package  App\Http\Controller\Shopping
 */
class HomeController extends ShoppingController
{
    /**
     * @param ServerRequest $request
     * @return Response
    */
    public function index(ServerRequest $request): Response
    {
        $productRepository = new ProductRepository($this->getConnection());

        return $this->render('shopping/home/index', [
            'products' => $productRepository->findAll()
        ]);
    }
}