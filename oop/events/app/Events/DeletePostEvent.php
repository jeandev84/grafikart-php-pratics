<?php
declare(strict_types=1);

namespace App\Events;


use App\Entity\Post;
use Grafikart\Events\Event;

/**
 * Created by PhpStorm at 04.12.2023
 *
 * @DeletePostEvent
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @package App\Events
 */
class DeletePostEvent extends Event
{
      public function __construct(Post $post)
      {
          $this->setName('database.delete.post');
          $this->setTarget($post);
      }
}