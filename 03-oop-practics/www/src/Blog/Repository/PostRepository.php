<?php
declare(strict_types=1);

namespace App\Blog\Repository;


use App\Blog\Entity\Category;
use App\Blog\Entity\Post;
use Framework\Database\ORM\EntityRepository;
use Framework\Database\ORM\Exceptions\NoRecordException;
use Framework\Database\PaginatedQuery;
use Framework\Database\Query;
use Pagerfanta\Pagerfanta;



/**
 * Created by PhpStorm at 05.12.2023
 *
 * @PostRepository
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @package App\Blog\Repository
 */
class PostRepository extends EntityRepository
{


       /**
        * @param \PDO $connection
       */
       public function __construct(\PDO $connection)
       {
           parent::__construct($connection, Post::class, 'posts');
       }



       public function findPublic(): Query
       {
            $categoryTable = CategoryRepository::getTableName();

            return $this->makeQuery()
                        ->select('p.*, c.name as category_name, c.slug as category_slug')
                        ->from('posts', 'p')
                        ->join($categoryTable. ' as c', 'c.id = p.category_id')
                        ->orderBy('p.created_at DESC');
       }

}